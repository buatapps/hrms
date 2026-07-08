<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use DatePeriod;
use DateInterval;


class Attendance extends BaseController
{
    public function index()
    {
        $today = new Time('now');
        $dates = explode(' ', $today);
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $list_data = $this->AttendanceModel->attendaceEmployee($dates[0], $division_id)->getResultObject();

        // end mencari yang tidak finger
        $data = [
            'title'     => 'Attendance',
            'list_data' => $list_data,
            'attendance_machine' => $this->AttendanceMachineModel->findall(),
            'attendance_machine_id' => null,
            'dates'     => $dates[0],
        ];

        return view('attendance/index', $data);
    }

    public function not_absent($date)
    {
        //get pin yang absen / finger
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $attendance = $this->AttendanceModel->attendaceEmployee($date, $division_id)->getResultObject();
        $pin_id = array();
        foreach ($attendance as $row) {
            $pin_id[] = $row->pin;
        }

        // get pin yang absent
        $absent = $this->AttendanceModel->getAbsent($date)->getResultObject();

        $pin_absent = array();
        foreach ($absent as $row) {
            $pin_absent[] = $row->employee_pin;
        }

        // get pin terlambat
        $late = $this->AttendanceModel->getLate($date)->getResultObject();
        $pin_late = array();
        foreach ($late as $row) {
            $pin_late[] = $row->employee_pin;
        }

        // mencari yang tidak absen / finger
        $list_data = $this->AttendanceModel->dataAbsent($pin_id, $pin_absent, $pin_late, $date, $division_id)->getResultObject();


        $data = [
            'title'         => 'No Attendance',
            'list_data'     => $list_data,
            'date'          => $date
        ];

        return view('attendance/not_absent', $data);
    }

    public function search()
    {
        $attendance_machine_id = $this->request->getVar('attendance_machine_id');
        $date = $this->request->getVar('date');
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));

        $list_data = $this->AttendanceModel->logAttendance($date, $attendance_machine_id, $division_id)->getResultObject();

        $data = [
            'title'     => 'Attendance Search',
            'attendance_machine_id'     => $attendance_machine_id,
            'dates'     => $date,
            'list_data' => $list_data,
            'attendance_machine' => $this->AttendanceMachineModel->findall(),
        ];

        return view('attendance/index', $data);
    }

    public function download($attendance_machine_id)
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $date = new Time('now');
        $dates = explode(' ', $date);
        $list_data = $this->AttendanceModel->logAttendance($dates[0], $attendance_machine_id, $division_id)->getResultObject();
        $data = [
            'title'             => 'Download',
            'attendance_machine' => $this->AttendanceMachineModel->findall(),
            'attendance_machine_id' => $attendance_machine_id,
            'list_data'         => $list_data
        ];

        return view('attendance/download', $data);
    }

    public function download_all()
    {
        error_reporting(0);
        set_time_limit(0);

        $machines = $this->AttendanceMachineModel->findAll();

        $success = [];
        $failed = [];

        foreach ($machines as $machine) {
            $result = $this->processDownloadMachine($machine);

            if (str_contains($result, 'Success')) {
                $success[] = ($machine->name ?? $machine->ip) . ' - ' . $result;
            } else {
                $failed[] = ($machine->name ?? $machine->ip) . ' - ' . $result;
            }
        }

        return redirect()->to(base_url('attendance/download/0'))
            ->with('success_list', $success)
            ->with('failed_list', $failed);
    }

    public function parseData($data, $p1, $p2)
    {
        $data = " " . $data;
        $result = "";
        $start = strpos($data, $p1);
        if ($start != "") {
            $end = strpos(strstr($data, $p1), $p2);
            if ($end != "") {
                $result = substr($data, $start + strlen($p1), $end - strlen($p1));
            }
        }
        return $result;
    }

    public function download_log()
    {
        error_reporting(0);
        set_time_limit(0);
        $attendance_machine_id = $this->request->getVar('attendance_machine_id');
        $attendance_machine = $this->AttendanceMachineModel->where('id', $attendance_machine_id)->first();
        $ip = $attendance_machine->ip;
        $key = $attendance_machine->key;

        $Connect = fsockopen($ip, "80", $errno, $errstr, 1);

        if ($Connect) {
            $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine = "\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
            fputs($Connect, "Content-Type: text/xml" . $newLine);
            fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
            fputs($Connect, $soap_request . $newLine);
            $buffer = "";
            while ($Response = fgets($Connect, 2048)) {
                $buffer = $buffer . $Response;
            }
        } else {
            return redirect()->to(base_url('attendance/download/' . $attendance_machine_id))->with('danger', 'data <strong>Failed!</strong> Machine not connected, check network device');
        }

        $buffer = $this->ParseData($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
        $buffer = explode("\r\n", $buffer);

        for ($a = 0; $a < count($buffer); $a++) {
            $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
            $PIN = $this->ParseData($data, "<PIN>", "</PIN>");
            $DateTime = $this->ParseData($data, "<DateTime>", "</DateTime>");
            $Verified = $this->ParseData($data, "<Verified>", "</Verified>");
            $Status = $this->ParseData($data, "<Status>", "</Status>");

            $checkData = $this->AttendanceModel->checkData($attendance_machine_id, $PIN, $DateTime, $Verified, $Status);

            if ($checkData == 0) {
                $days = explode(' ', $DateTime);

                $this->AttendanceModel->save([
                    'attendance_machine_id' => $attendance_machine_id,
                    'pin'                   => $PIN,
                    'datetime'              => $DateTime,
                    'date'                  => $days[0],
                    'time'                  => $days[1],
                    'verified'              => $Verified,
                    'status'                => $Status
                ]);


                // employee is late
                $checkAttendance = $this->AttendanceModel->checkAttendance($PIN, $days[0]);
                if ($checkAttendance != 0) {
                    $day = date('l', strtotime($DateTime));
                    $schedule = $this->EmployeeScheduleModel->employeeSchedule($PIN, $days[0], $day);

                    if ($schedule->getNumRows() != 0) {
                        $sch = $schedule->getResultObject();
                        if ($sch[0]->entry_time < $days[1]) {
                            $checkEmployeeLate = $this->AttendanceModel->checkEmployeeLate($PIN, $days[0]);
                            if ($checkEmployeeLate == 0) {
                                $this->EmployeeLateModel->save([
                                    'employee_pin'  => $PIN,
                                    'date'          => $days[0],
                                    'entry_time'    => $sch[0]->entry_time,
                                    'late_hour'     => $days[1]
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->to(base_url('attendance/download/' . $attendance_machine_id))->with('success', 'data <strong>Download</strong> successfully');
    }

    private function processDownloadMachine($attendance_machine)
    {
        $ip = $attendance_machine->ip;
        $key = $attendance_machine->key;
        $attendance_machine_id = $attendance_machine->id;

        $Connect = fsockopen($ip, "80", $errno, $errstr, 1);

        if (!$Connect) {
            return 'Connection failed';
        }

        $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
        $newLine = "\r\n";

        fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
        fputs($Connect, "Content-Type: text/xml" . $newLine);
        fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
        fputs($Connect, $soap_request . $newLine);

        $buffer = "";
        while ($Response = fgets($Connect, 2048)) {
            $buffer .= $Response;
        }

        if (empty($buffer)) {
            return 'Empty response';
        }

        $buffer = $this->parseData($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
        $buffer = explode("\r\n", $buffer);

        $inserted = 0;

        foreach ($buffer as $row) {
            $data = $this->parseData($row, "<Row>", "</Row>");
            $PIN = $this->parseData($data, "<PIN>", "</PIN>");
            $DateTime = $this->parseData($data, "<DateTime>", "</DateTime>");
            $Verified = $this->parseData($data, "<Verified>", "</Verified>");
            $Status = $this->parseData($data, "<Status>", "</Status>");

            if (!$PIN || !$DateTime) continue;

            $checkData = $this->AttendanceModel->checkData($attendance_machine_id, $PIN, $DateTime, $Verified, $Status);

            if ($checkData == 0) {
                $days = explode(' ', $DateTime);

                $this->AttendanceModel->save([
                    'attendance_machine_id' => $attendance_machine_id,
                    'pin' => $PIN,
                    'datetime' => $DateTime,
                    'date' => $days[0],
                    'time' => $days[1],
                    'verified' => $Verified,
                    'status' => $Status
                ]);

                $inserted++;
            }
        }

        return "Success ($inserted data)";
    }

    public function form_absent($id)
    {
        $employee = $this->EmployeeModel->where('id', $id)->first();
        $absent = $this->AbsentTypeModel->findall();
        $data = [
            'title'     => 'Form Absent',
            'employee'  => $employee,
            'absent'    => $absent,
            'date'      => date('Y-m-d')
        ];

        return view('attendance/form_absent', $data);
    }

    public function save_absent()
    {
        $employee_id = $this->request->getVar('employee_id');
        $employee_pin = $this->request->getVar('employee_pin');
        $date = $this->request->getVar('date');
        $end_date = $this->request->getVar('end_date');
        $absent_type_id = $this->request->getVar('absent_type_id');
        $information = $this->request->getVar('information');
        $late_hour = $this->request->getVar('late_hour');

        if ($absent_type_id == '6') {
            $day = date('l', strtotime($date));
            $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
            $entry_time = $schedule[0]->entry_time;
            $this->EmployeeLateModel->save([
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        } else {
            $this->AbsentModel->save([
                'date'          => $date,
                'end_date'      => $end_date,
                'employee_id'   => $employee_id,
                'employee_pin'  => $employee_pin,
                'absent_type_id' => $absent_type_id,
                'information'   => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }

        return redirect()->to(base_url('attendance/not_absent/' . $date))->with('success', 'data <strong>Save</strong> successfully');
    }

    public function report()
    {
        $dateNow = new Time('now');
        $dates = explode(' ', $dateNow);

        $date      = $dates[0];
        $shift_id = '';
        $plant_id  = '';
        $employee_group_id  = '';
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $division = $division_id ? [$this->DivisionModel->find($division_id)] : $this->DivisionModel->findAll();
        $status  = '';

        $list_data = $this->AttendanceModel->dataAttendanceEmployee($date, $shift_id, $plant_id, $employee_group_id, $division_id, $status);
        $Countresult = $this->AttendanceModel->summaryAttendance($date);
        // View
        $data = [
            'title' => 'Report Attendance',
            'date' => $date,
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id,
            'division_id' => $division_id,
            'shift_id' => $shift_id,
            'status' => $status,
            'plant' => $this->PlantModel->findAll(),
            'group' => $this->EmployeeGroupModel->findAll(),
            'division' => $division,
            'shift' => $this->ShiftModel->findAll(),
            'list_data' => $list_data,
            'result' => $Countresult
        ];
        return view('attendance/report', $data);
    }


    public function search_report()
    {
        $date = $this->request->getVar('date');
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');
        $division_id = $this->request->getVar('division_id');
        $shift_id = $this->request->getVar('shift_id');
        $status = $this->request->getVar('status');

        $list_data = $this->AttendanceModel->dataAttendanceEmployee($date, $shift_id, $plant_id, $employee_group_id, $division_id, $status);
        $Countresult = $this->AttendanceModel->summaryAttendance($date);
        // View
        $data = [
            'title' => 'Report Attendance',
            'date' => $date,
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id,
            'division_id' => $division_id,
            'shift_id' => $shift_id,
            'status' => $status,
            'plant' => $this->PlantModel->findAll(),
            'group' => $this->EmployeeGroupModel->findAll(),
            'division' => $this->DivisionModel->where(['id' => $division_id])->findAll(),
            'shift' => $this->ShiftModel->findAll(),
            'list_data' => $list_data,
            'result' => $Countresult
        ];
        return view('attendance/report', $data);
    }

    public function report_export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $date               = $this->request->getVar('date');
        $plant_id           = $this->request->getVar('plant_id');
        $employee_group_id  = $this->request->getVar('employee_group_id');
        $division_id        = $this->request->getVar('division_id');
        $shift_id           = $this->request->getVar('shift_id');
        $status             = $this->request->getVar('status');

        $list_data = $this->AttendanceModel
            ->dataAttendanceEmployee($date, $shift_id, $plant_id, $employee_group_id, $division_id, $status);

        // ================= HEADER =================
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Employee ID');
        $sheet->setCellValue('D1', 'Position');
        $sheet->setCellValue('E1', 'Division');
        $sheet->setCellValue('F1', 'Plant');
        $sheet->setCellValue('G1', 'Group');
        $sheet->setCellValue('H1', 'Status');
        $sheet->setCellValue('I1', 'Shift');
        $sheet->setCellValue('J1', 'Entry Time');
        $sheet->setCellValue('K1', 'Clock Out');
        $sheet->setCellValue('L1', 'IN');
        $sheet->setCellValue('M1', 'OUT');
        $sheet->setCellValue('N1', 'Information');

        // ================= BODY =================
        $row = 2;
        $no  = 1;

        foreach ($list_data as $key) {

            // Info Absent / Form
            $info = '-';
            if ($key->jam_masuk === null && $key->jam_pulang === null) {
                $absent = \Config\Database::connect()->table('absent')
                    ->join('absent_type', 'absent_type.id = absent.absent_type_id')
                    ->where('employee_pin', $key->employee_pin)
                    ->where("'$date' BETWEEN `date` AND `end_date`", null, false)
                    ->get()->getRow();

                if ($absent) {
                    $info = $absent->name;
                } else {
                    $info = '-';
                }
            }

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $key->name);
            $sheet->setCellValue('C' . $row, $key->employee_id);
            $sheet->setCellValue('D' . $row, $key->position);
            $sheet->setCellValue('E' . $row, $key->division);
            $sheet->setCellValue('F' . $row, $key->plant);
            $sheet->setCellValue('G' . $row, $key->employee_group);
            $sheet->setCellValue('H' . $row, $key->employee_status);
            $sheet->setCellValue('I' . $row, $key->shift_name);
            $sheet->setCellValue('J' . $row, $key->entry_time);
            $sheet->setCellValue('K' . $row, $key->clock_out);
            $sheet->setCellValue('L' . $row, $key->jam_masuk);
            $sheet->setCellValue('M' . $row, $key->jam_pulang);
            $sheet->setCellValue('N' . $row, $info);

            $row++;
        }

        // ================= AUTO WIDTH =================
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // ================= DOWNLOAD =================
        $filename = 'Attendance_Report_' . $date . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function report_user()
    {
        $employee = in_groups('admin')
            ? $this->EmployeeModel->where('employee_status_id !=', 3)
            ->where('division_id', user()->division_id)
            ->findAll()
            : $this->EmployeeModel->where('employee_status_id !=', 3)
            ->findAll();
        $data = [
            'title'     => 'Report User',
            'list_data' => [],
            'employee'  => $employee,
            'start_date' => date('Y-m-20', strtotime('-1 month')),
            'end_date' => date('Y-m-21'),
            'employee_id' => '',
        ];

        return view('attendance/report_user', $data);
    }

    public function search_report_user()
    {
        $employee_id = $this->request->getPost('employee_id');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        $employee = in_groups('admin')
            ? $this->EmployeeModel->where('employee_status_id !=', 3)
            ->where('division_id', user()->division_id)
            ->findAll()
            : $this->EmployeeModel->where('employee_status_id !=', 3)
            ->findAll();

        $list_data = $this->AttendanceModel->dataAttendanceEmployeeUserWithAllDates($employee_id, $start_date, $end_date);
        $data = [
            'title'     => 'Report User',
            'list_data' => $list_data,
            'employee'  => $employee,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'employee_id' => $employee_id,
        ];

        return view('attendance/report_user', $data);
    }

    public function report_user_export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $employee_id = $this->request->getPost('employee_id');
        $start_date  = $this->request->getPost('start_date');
        $end_date    = $this->request->getPost('end_date');

        $list_data = $this->AttendanceModel->dataAttendanceEmployeeUserWithAllDates($employee_id, $start_date, $end_date);
        $employee = $this->EmployeeModel->where('id', $employee_id)->get()->getRow();

        $sheet->setCellValue('A1', 'Employee');
        $sheet->setCellValue('B1', ': ' . $employee->name);

        $sheet->setCellValue('A2', 'Employee ID');
        $sheet->setCellValue('B2', ': ' . $employee->employee_id);

        $sheet->setCellValue('A3', 'Date');
        $sheet->setCellValue('B3', ': ' . $start_date . ' to ' . $end_date);

        // Header kolom
        $startRow = 5;
        $sheet->setCellValue('A' . $startRow, 'No');
        $sheet->setCellValue('B' . $startRow, 'Date');
        $sheet->setCellValue('C' . $startRow, 'Shift');
        $sheet->setCellValue('D' . $startRow, 'Entry Time');
        $sheet->setCellValue('E' . $startRow, 'Clock Out');
        $sheet->setCellValue('F' . $startRow, 'Attendance IN');
        $sheet->setCellValue('G' . $startRow, 'Attendance OUT');
        $sheet->setCellValue('H' . $startRow, 'Telat (Min)');
        $sheet->setCellValue('I' . $startRow, 'Status');

        $row = 6;
        $no  = 1;
        $hadir = 0;
        $tidak_hadir = 0;
        $total_telat = 0;

        foreach ($list_data as $d) {

            // Tentukan status harian
            if ($d->jam_masuk || $d->jam_pulang) {
                $status = 'Hadir';

                if ($d->jam_masuk && $d->jam_masuk > $d->entry_time) {
                    $status = 'Telat';
                }

                if ($d->jam_pulang && $d->jam_pulang < $d->clock_out) {
                    $status = 'Pulang Cepat';
                }
            } else {
                $status = 'Tidak Hadir';
            }

            $telat_menit = 0;
            if ($d->jam_masuk && $d->jam_masuk > $d->entry_time) {
                $telat_menit = ceil((strtotime($d->jam_masuk) - strtotime($d->entry_time)) / 60);
            }

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d->date);
            $sheet->setCellValue('C' . $row, $d->shift_name);
            $sheet->setCellValue('D' . $row, $d->entry_time);
            $sheet->setCellValue('E' . $row, $d->clock_out);
            $sheet->setCellValue('F' . $row, $d->jam_masuk ?? '-');
            $sheet->setCellValue('G' . $row, $d->jam_pulang ?? '-');
            $sheet->setCellValue('H' . $row, $telat_menit);
            $sheet->setCellValue('I' . $row, $status);

            if ($d->jam_masuk || $d->jam_pulang) {
                $hadir++;
            } else {
                $tidak_hadir++;
            }
            $total_telat += $telat_menit;
            $row++;
        }

        $row += 2;
        $sheet->setCellValue('F' . $row, 'Hadir');
        $sheet->setCellValue('G' . $row, $hadir);

        $row++;
        $sheet->setCellValue('F' . $row, 'Tidak Hadir');
        $sheet->setCellValue('G' . $row, $tidak_hadir);

        $row++;
        $sheet->setCellValue('F' . $row, 'Total Telat (Menit)');
        $sheet->setCellValue('G' . $row, $total_telat);

        // Auto width
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Attendance_' .
            strtoupper(str_replace(' ', '_', $employee->name)) .
            '_' . $start_date . '_to_' . $end_date . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



    public function form_absent_report($date, $id)
    {
        $employee = $this->EmployeeModel->where('id', $id)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee tidak ditemukan');
        }
        $absent = $this->AbsentTypeModel->findall();
        $data = [
            'title'     => 'Form Absent',
            'employee'  => $employee,
            'absent'    => $absent,
            'date'      => $date
        ];

        return view('attendance/form_absent_report', $data);
    }

    public function save_absent_report()
    {
        $employee_id = $this->request->getVar('employee_id');
        $employee_pin = $this->request->getVar('employee_pin');
        $date = $this->request->getVar('date');
        $end_date = $this->request->getVar('end_date');
        $absent_type_id = $this->request->getVar('absent_type_id');
        $information = $this->request->getVar('information');
        $late_hour = $this->request->getVar('late_hour');

        if ($absent_type_id == '6') {
            $day = date('l', strtotime($date));
            $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
            $entry_time = $schedule[0]->entry_time;
            $this->EmployeeLateModel->save([
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        } else {
            $this->AbsentModel->save([
                'date'          => $date,
                'end_date'      => $end_date,
                'employee_id'   => $employee_id,
                'employee_pin'  => $employee_pin,
                'absent_type_id' => $absent_type_id,
                'information'   => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }

        return redirect()->to(base_url('attendance/report/'))->with('success', 'data <strong>Save</strong> successfully!, Back to Attendance Report and refresh them!');
    }

    public function absent()
    {
        $date = date('Y-m-d');

        if (in_groups('admin')) {
            $division_id = user()->division_id;
        } else {
            $division_id = null;
        }
        $absent = $this->AbsentModel->Absent($date, $division_id);
        $employee_late = $this->EmployeeLateModel->EmployeeLate($date);
        $list_data = array_merge($absent, $employee_late);


        $data = [
            'title'     => 'Absent',
            'list_data' => $list_data,
            'date'      => $date
        ];

        return view('attendance/absent', $data);
    }

    public function absent_search()
    {
        $date = $this->request->getVar('date');
        if (in_groups('admin')) {
            $division_id = user()->division_id;
        } else {
            $division_id = null;
        }
        $data = [
            'title'     => 'Absent',
            'list_data' => $this->AbsentModel->Absent($date, $division_id),
            'date'      => $date
        ];

        return view('attendance/absent', $data);
    }

    public function absent_add()
    {
        $data = [
            'title'     => 'Absent Add',
            'absent_type' => $this->AbsentTypeModel->findAll(),
            'employee'  => $this->EmployeeModel->findAll(),
            'date'      => date('Y-m-d')
        ];

        return view('attendance/absent_add', $data);
    }

    public function absent_save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $date = $this->request->getVar('date');
        $end_date = $this->request->getVar('end_date');
        $absent_type_id = $this->request->getVar('absent_type_id');
        $late_hour = $this->request->getVar('late_hour');
        $information = $this->request->getVar('information');

        $emp_pin = $this->EmployeeModel->where(['id' => $employee_id])->first();
        $employee_pin = $emp_pin->employee_pin;

        if ($absent_type_id == '6') {
            $day = date('l', strtotime($date));
            $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
            $entry_time = $schedule[0]->entry_time;
            $this->EmployeeLateModel->save([
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
            $this->AttendanceModel->save([
                'attendance_machine_id' => '1',
                'pin'                   => $employee_pin,
                'datetime'              => $date . ' ' . $late_hour,
                'date'                  => $date,
                'time'                  => $late_hour,
                'verified'              => '1',
                'status'                => '255'
            ]);
        } elseif ($absent_type_id == '5') {
            $this->AttendanceModel->save([
                'attendance_machine_id' => '1',
                'pin'                   => $employee_pin,
                'datetime'              => $date . ' ' . $late_hour,
                'date'                  => $date,
                'time'                  => $late_hour,
                'verified'              => '1',
                'status'                => '255'
            ]);
        } elseif ($absent_type_id == '7') {
            $this->AttendanceModel->save([
                'attendance_machine_id' => '1',
                'pin'                   => $employee_pin,
                'datetime'              => $date . ' ' . $late_hour,
                'date'                  => $date,
                'time'                  => $late_hour,
                'verified'              => '1',
                'status'                => '255'
            ]);
        } else {
            $this->AbsentModel->save([
                'date'          => $date,
                'end_date'      => $end_date,
                'employee_id'   => $employee_id,
                'employee_pin'  => $employee_pin,
                'absent_type_id' => $absent_type_id,
                'information'   => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }

        if ($absent_type_id == '6') {
            return redirect()->to(base_url('attendance/employee_late'))->with('success', 'data <strong>Save</strong> successfully!');
        } else {
            return redirect()->to(base_url('attendance/absent'))->with('success', 'data <strong>Save</strong> successfully!');
        }
    }

    public function absent_edit($id)
    {
        $list_data = $this->AbsentModel->where(['id' => $id])->first();

        $data = [
            'title'     => 'Absent Edit',
            'list_data' => $list_data,
            'absent_type' => $this->AbsentTypeModel->findAll(),
            'employee'  => $this->EmployeeModel->findAll(),
            'employee_id' => $id,
            'late_hour' => null
        ];
        session()->set('previous_url', previous_url());
        return view('attendance/absent_edit', $data);
    }

    public function absent_update()
    {
        $id = $this->request->getVar('id');

        $employee_id = $this->request->getVar('employee_id');
        $date = $this->request->getVar('date');
        $end_date = $this->request->getVar('end_date');
        $absent_type_id = $this->request->getVar('absent_type_id');
        $late_hour = $this->request->getVar('late_hour');
        $information = $this->request->getVar('information');

        $emp_pin = $this->EmployeeModel->where(['id' => $employee_id])->first();
        $employee_pin = $emp_pin->employee_pin;

        //simpan log history
        $oldData = $this->AbsentModel->find($id);
        $newData = [
            'absent_type_id' => $absent_type_id
        ];
        $this->logAbsent($employee_id, $oldData, $newData);

        if ($absent_type_id == '6') {
            $this->AbsentModel->delete($id);
            $day = date('l', strtotime($date));
            $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
            $entry_time = $schedule[0]->entry_time;
            $this->EmployeeLateModel->save([
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }
        if ($absent_type_id == '7') {
            $this->AttendanceModel->save([
                'attendance_machine_id' => '1',
                'pin'                   => $employee_pin,
                'datetime'              => $date . ' ' . $late_hour,
                'date'                  => $date,
                'time'                  => $late_hour,
                'verified'              => '1',
                'status'                => '255'
            ]);
        } else {
            $this->AbsentModel->save([
                'id'            => $id,
                'date'          => $date,
                'end_date'      => $end_date,
                'employee_id'   => $employee_id,
                'employee_pin'  => $employee_pin,
                'absent_type_id' => $absent_type_id,
                'information'   => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }


        $previousUrl = session()->get('previous_url') ?? base_url();
        $path = parse_url($previousUrl, PHP_URL_PATH);

        // Tentukan target default
        $target = 'attendance/absent';

        // Cek kondisi khusus
        if (str_contains($path, 'attendance/search_report')) {
            $target = 'attendance/report';
        } elseif (str_contains($path, 'attendance/absent_search')) {
            $target = 'attendance/absent'; // Sebenarnya ini sama dengan default
        }

        return redirect()->to(base_url($target))->with('success', 'Data updated');
    }

    public function absent_delete($id)
    {
        $this->AbsentModel->delete($id);
        $previousUrl = session()->get('previous_url');
        return redirect()->to($previousUrl ?? base_url('attendance/absent'))
            ->with('success', 'data absent deleted');
    }

    public function employee_late()
    {
        $date = date('Y-m-d');
        $plant_id = null;
        $employee_group_id = null;
        $plant = $this->PlantModel->findAll();
        $group = $this->EmployeeGroupModel->findAll();
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Employee Late',
            'list_data' => $this->EmployeeLateModel->EmployeeLateData($date, $plant_id, $employee_group_id, $division_id),
            'date'      => $date,
            'plant'     => $plant,
            'group'     => $group,
            'plant_id'  => $plant_id,
            'employee_group_id' => $employee_group_id
        ];

        return view('attendance/employee_late', $data);
    }

    public function employee_late_search()
    {
        $date = $this->request->getVar('date');
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');
        $plant = $this->PlantModel->findAll();
        $group = $this->EmployeeGroupModel->findAll();
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Employee Late',
            'list_data' => $this->EmployeeLateModel->EmployeeLateData($date, $plant_id, $employee_group_id, $division_id),
            'date'      => $date,
            'plant'     => $plant,
            'group'     => $group,
            'plant_id'  => $plant_id,
            'employee_group_id' => $employee_group_id
        ];

        return view('attendance/employee_late', $data);
    }

    public function employee_late_add()
    {
        $data = [
            'title'     => 'Employee Late Add',
            'employee'  => $this->EmployeeModel->findAll(),
            'date'      => date('Y-m-d')
        ];

        return view('attendance/employee_late_add', $data);
    }

    public function employee_late_save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $date = $this->request->getVar('date');
        $late_hour = $this->request->getVar('late_hour');
        $information = $this->request->getVar('information');

        $emp_pin = $this->EmployeeModel->where(['id' => $employee_id])->first();
        $employee_pin = $emp_pin->employee_pin;

        $day = date('l', strtotime($date));
        $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
        $entry_time = $schedule[0]->entry_time;

        $check = $this->EmployeeLateModel->checkData($date, $employee_pin)->getNumRows();
        if ($check != 0) {
            $rowCheck = $this->EmployeeLateModel->checkData($date, $employee_pin)->getResultObject();
            $id = $rowCheck[0]->id;

            $this->EmployeeLateModel->save([
                'id'  => $id,
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        } else {

            $this->EmployeeLateModel->save([
                'employee_pin'  => $employee_pin,
                'date'          => $date,
                'entry_time'    => $entry_time,
                'late_hour'     => $late_hour,
                'information'     => $information,
                'created_at'    => new Time('now'),
                'updated_at'    => new Time('now'),
            ]);
        }

        return redirect()->to(base_url('attendance/employee_late'))->with('success', 'data <strong>Save</strong> successfully!');
    }

    public function employee_late_edit($id)
    {
        $list_data = $this->EmployeeLateModel->where(['id' => $id])->first();
        $emp = $this->EmployeeModel->where(['employee_pin' => $list_data->employee_pin])->first();
        $employee_id = $emp->id;
        $data = [
            'title'     => 'Employee Late Add',
            'employee'  => $this->EmployeeModel->findAll(),
            'employee_id' => $employee_id,
            'list_data' => $list_data
        ];

        return view('attendance/employee_late_edit', $data);
    }

    public function employee_late_update()
    {
        $id = $this->request->getVar('employee_id');
        $employee_id = $this->request->getVar('employee_id');
        $date = $this->request->getVar('date');
        $late_hour = $this->request->getVar('late_hour');
        $information = $this->request->getVar('information');

        $emp_pin = $this->EmployeeModel->where(['id' => $employee_id])->first();
        $employee_pin = $emp_pin->employee_pin;

        $day = date('l', strtotime($date));
        $schedule = $this->EmployeeScheduleModel->employeeSchedule($employee_pin, $date, $day)->getResultObject();
        $entry_time = $schedule[0]->entry_time;

        $this->EmployeeLateModel->save([
            'id'  => $id,
            'employee_pin'  => $employee_pin,
            'date'          => $date,
            'entry_time'    => $entry_time,
            'late_hour'     => $late_hour,
            'information'     => $information,
            'created_at'    => new Time('now'),
            'updated_at'    => new Time('now'),
        ]);

        return redirect()->to(base_url('attendance/employee_late'))->with('success', 'data <strong>Update</strong> successfully!');
    }

    public function employee_late_delete($id)
    {
        $this->EmployeeLateModel->delete($id);
        return redirect()->to(base_url('attendance/employee_late'))->with('success', 'data <strong>Delete</strong> successfully!');
    }

    public function report_department()
    {
        $month = $this->request->getGet('month') ?? date('m');
        $year  = $this->request->getGet('year') ?? date('Y');

        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $plant_id = $this->request->getGet('plant_id') ?? 1;
        $employee_group_id = $this->request->getGet('employee_group_id') ?? 1;

        $list_data = $this->AttendanceModel->attendanceDepartment($year, $month, $division_id, $plant_id, $employee_group_id);
        $division = $division_id ? [$this->DivisionModel->find($division_id)] : $this->DivisionModel->findAll();
        // View
        $data = [
            'title' => 'Report Attendance Department',
            'year' => $year,
            'month' => $month,
            'division_id' => $division_id,
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id,
            'division' => $division,
            'plant' => $this->PlantModel->findAll(),
            'group' => $this->EmployeeGroupModel->findAll(),
            'list_data' => $list_data
        ];
        return view('attendance/report_department', $data);
    }

    public function search_report_department()
    {
        $month = $this->request->getGet('month') ?? date('m');
        $year  = $this->request->getGet('year') ?? date('Y');

        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $plant_id = $this->request->getGet('plant_id') ?? 1;
        $employee_group_id = $this->request->getGet('employee_group_id') ?? 1;

        $list_data = $this->AttendanceModel->attendanceDepartment($year, $month, $division_id, $plant_id, $employee_group_id);
        $division = $division_id ? [$this->DivisionModel->find($division_id)] : $this->DivisionModel->findAll();
        // View
        $data = [
            'title' => 'Report Attendance Department',
            'year' => $year,
            'month' => $month,
            'division_id' => $division_id,
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id,
            'division' => $division,
            'plant' => $this->PlantModel->findAll(),
            'group' => $this->EmployeeGroupModel->findAll(),
            'list_data' => $list_data
        ];
        return view('attendance/report_department', $data);
    }

    public function report_department_export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $year  = $this->request->getPost('year');
        $month = $this->request->getPost('month');

        $division_id = resolveDivisionFilter($this->request->getPost('division_id'));

        $plant_id          = $this->request->getPost('plant_id') ?? 1;
        $employee_group_id = $this->request->getPost('employee_group_id') ?? 1;

        $list_data = $this->AttendanceModel
            ->attendanceDepartment($year, $month, $division_id, $plant_id, $employee_group_id);

        $division = $this->DivisionModel->find($division_id);
        $plant = $this->PlantModel->find($plant_id);
        $group = $this->EmployeeGroupModel->find($employee_group_id);

        // ===== HEADER ATAS =====
        $sheet->setCellValue('A1', 'Division');
        $sheet->setCellValue('B1', ': ' . $division->name);

        $sheet->setCellValue('A2', 'Plant');
        $sheet->setCellValue('B2', ': ' . ($plant->name ?? '-'));

        $sheet->setCellValue('A3', 'Group');
        $sheet->setCellValue('B3', ': ' . ($group->name ?? '-'));

        $sheet->setCellValue('A4', 'Period');
        $sheet->setCellValue('B4', ': ' . date('F Y', strtotime("$year-$month-01")));


        // ===== TABLE HEADER =====
        $startRow = 6;
        $sheet->setCellValue('A' . $startRow, 'No');
        $sheet->setCellValue('B' . $startRow, 'Date');
        $sheet->setCellValue('C' . $startRow, 'Name');
        $sheet->setCellValue('D' . $startRow, 'Shift');
        $sheet->setCellValue('E' . $startRow, 'Entry');
        $sheet->setCellValue('F' . $startRow, 'Out');
        $sheet->setCellValue('G' . $startRow, 'IN');
        $sheet->setCellValue('H' . $startRow, 'OUT');
        $sheet->setCellValue('I' . $startRow, 'Late (Min)');
        $sheet->setCellValue('J' . $startRow, 'Status');

        // ===== DATA =====
        $row = 5;
        $no = 1;
        $hadir = 0;
        $tidak_hadir = 0;
        $total_telat = 0;

        foreach ($list_data as $d) {

            if ($d->jam_masuk || $d->jam_pulang) {
                $status = 'Hadir';
                if ($d->jam_masuk && $d->jam_masuk > $d->entry_time) $status = 'Telat';
                if ($d->jam_pulang && $d->jam_pulang < $d->clock_out) $status = 'Pulang Cepat';
            } else {
                $status = 'Tidak Hadir';
            }

            $telat_menit = 0;
            if ($d->jam_masuk && $d->jam_masuk > $d->entry_time) {
                $telat_menit = ceil((strtotime($d->jam_masuk) - strtotime($d->entry_time)) / 60);
            }

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $d->date);
            $sheet->setCellValue('C' . $row, $d->name);
            $sheet->setCellValue('D' . $row, $d->shift_name);
            $sheet->setCellValue('E' . $row, $d->entry_time);
            $sheet->setCellValue('F' . $row, $d->clock_out);
            $sheet->setCellValue('G' . $row, $d->jam_masuk ?? '-');
            $sheet->setCellValue('H' . $row, $d->jam_pulang ?? '-');
            $sheet->setCellValue('I' . $row, $telat_menit);
            $sheet->setCellValue('J' . $row, $status);

            if ($d->jam_masuk || $d->jam_pulang) $hadir++;
            else $tidak_hadir++;

            $total_telat += $telat_menit;
            $row++;
        }

        // ===== SUMMARY =====
        $row += 2;
        $sheet->setCellValue('H' . $row, 'Hadir');
        $sheet->setCellValue('I' . $row, $hadir);

        $row++;
        $sheet->setCellValue('H' . $row, 'Tidak Hadir');
        $sheet->setCellValue('I' . $row, $tidak_hadir);

        $row++;
        $sheet->setCellValue('H' . $row, 'Total Telat (Min)');
        $sheet->setCellValue('I' . $row, $total_telat);

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $division_name = strtoupper(str_replace(' ', '_', $division->name));
        $filename = "Attendance_{$division_name}_{$year}_{$month}.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function reportmonthlydepartment()
    {
        $start_date = $this->request->getGet('start_date') ?: date('Y-m-25', strtotime('-1 month'));
        $end_date   = $this->request->getGet('end_date') ?: date('Y-m-24');

        $division_id = resolveDivisionFilter($this->request->getGet('division_id'));
        $plant_id = $this->request->getGet('plant_id');
        $employee_group_id = $this->request->getGet('employee_group_id');

        /**
         * =========================================================
         * DIVISION
         * =========================================================
         */
        $division = in_groups('admin')
            ? [$this->DivisionModel->find(user()->division_id)]
            : $this->DivisionModel->findAll();

        /**
         * =========================================================
         * EMPLOYEE MASTER
         * =========================================================
         */
        $employeeBuilder = $this->EmployeeModel
            ->select('
            e.id,
            e.employee_id,
            e.name,
            d.name as division,
            p.name as plant,
            eg.name as employee_group
        ')
            ->from('employee e')
            ->join('division d', 'd.id = e.division_id', 'left')
            ->join('plant p', 'p.id = e.plant_id', 'left')
            ->join('employee_group eg', 'eg.id = e.employee_group_id', 'left')
            ->whereIn('e.employee_status_id', [1, 2])
            ->where('e.division_id', $division_id);

        if (!empty($plant_id)) {
            $employeeBuilder->where('e.plant_id', $plant_id);
        }

        if (!empty($employee_group_id)) {
            $employeeBuilder->where('e.employee_group_id', $employee_group_id);
        }

        $employeesRaw = $employeeBuilder->findAll();

        $employees = [];
        foreach ($employeesRaw as $row) {
            $employees[$row->id] = (object) [
                'id' => $row->id,
                'employee_id' => $row->employee_id,
                'name' => $row->name,
                'division' => $row->division,
                'plant' => $row->plant,
                'employee_group' => $row->employee_group,
            ];
        }

        /**
         * =========================================================
         * ATTENDANCE RAW DATA
         * =========================================================
         */
        $list_data = $this->AttendanceModel->getAttendanceRaw(
            $start_date,
            $end_date,
            $division_id,
            $plant_id,
            $employee_group_id
        );

        /**
         * =========================================================
         * SCAN MAP (IN/OUT)
         * =========================================================
         */
        $scanMap = [];

        /**
         * =========================================================
         * SCHEDULE MAP (CLOCK OUT RULE)
         * =========================================================
         */
        $scheduleMap = [];

        foreach ($list_data as $row) {

            $empId = $row->id;
            $date  = $row->date;
            $time  = $row->time;

            // if (!$empId || !$date || !$time) {
            //     continue;
            // }

            /**
             * INIT
             */
            if (!isset($scanMap[$empId][$date])) {
                $scanMap[$empId][$date] = [
                    'in'  => null,
                    'out' => null,
                    'overtime' => '0.00'
                ];
            }

            /**
             * STORE CLOCK OUT (SCHEDULE)
             */
            if (!isset($scheduleMap[$empId][$date])) {
                $scheduleMap[$empId][$date] = $row->clock_out ?? null;
            }

            $inStart  = $row->start_scan_in;
            $inEnd    = $row->end_scan_in;
            $outStart = $row->start_scan_out;
            $outEnd   = $row->end_scan_out;

            $timeUnix     = strtotime($time);
            $inStartUnix  = strtotime($inStart);
            $inEndUnix    = strtotime($inEnd);
            $outStartUnix = strtotime($outStart);
            $outEndUnix   = strtotime($outEnd);

            $hasSchedule = $inStart && $inEnd && $outStart && $outEnd;

            /**
             * =========================================================
             * IN LOGIC
             * =========================================================
             */
            if (
                !$hasSchedule ||
                ($timeUnix >= $inStartUnix && $timeUnix <= $inEndUnix)
            ) {
                if (
                    $scanMap[$empId][$date]['in'] === null ||
                    $timeUnix < strtotime($scanMap[$empId][$date]['in'])
                ) {
                    $scanMap[$empId][$date]['in'] = $time;
                }
            }

            /**
             * =========================================================
             * OUT LOGIC
             * =========================================================
             */
            if (
                !$hasSchedule ||
                ($timeUnix >= $outStartUnix && $timeUnix <= $outEndUnix)
            ) {
                if (
                    $scanMap[$empId][$date]['out'] === null ||
                    $timeUnix > strtotime($scanMap[$empId][$date]['out'])
                ) {
                    $scanMap[$empId][$date]['out'] = $time;
                }
            }
        }

        /**
         * =========================================================
         * FINAL PASS: OVERTIME CALCULATION
         * =========================================================
         */
        foreach ($scanMap as $empId => $dates) {
            foreach ($dates as $date => $val) {

                $outTime  = $val['out'] ?? null;
                $clockOut = $scheduleMap[$empId][$date] ?? null;
                $inTime   = $val['in'] ?? null;

                if ($clockOut) {

                    // ADA SCHEDULE
                    $overtimeSeconds = strtotime($outTime) - strtotime($clockOut);

                    if ($overtimeSeconds > 0) {

                        $hours   = floor($overtimeSeconds / 3600);
                        $minutes = floor(($overtimeSeconds % 3600) / 60);

                        $scanMap[$empId][$date]['overtime'] =
                            $hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
                    }
                } else {

                    // TANPA SCHEDULE
                    if ($inTime && $outTime) {

                        $durationSeconds = strtotime($outTime) - strtotime($inTime);

                        if ($durationSeconds > 0) {

                            $hours   = floor($durationSeconds / 3600);
                            $minutes = floor(($durationSeconds % 3600) / 60);

                            $scanMap[$empId][$date]['overtime'] =
                                $hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
                        }
                    }
                }
            }
        }

        /**
         * =========================================================
         * PERIOD
         * =========================================================
         */
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            (new DateTime($end_date))->modify('+1 day')
        );

        $periode_label =
            date('d M Y', strtotime($start_date)) .
            ' s/d ' .
            date('d M Y', strtotime($end_date));

        /**
         * =========================================================
         * RETURN VIEW
         * =========================================================
         */
        return view('attendance/report_monthly_department', [
            'title' => 'Report Attendance Monthly Department',

            'periode_label' => $periode_label,
            'period'        => $period,

            'start_date' => $start_date,
            'end_date'   => $end_date,

            'division_id' => $division_id,
            'plant_id'    => $plant_id,
            'employee_group_id' => $employee_group_id,

            'division' => $division,
            'plant'    => $this->PlantModel->findAll(),
            'group'    => $this->EmployeeGroupModel->findAll(),

            'employees' => $employees,
            'scanMap'   => $scanMap
        ]);
    }

    public function searchreportmonyhlydepartment()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date   = $this->request->getPost('end_date');
        $division_id = $this->request->getPost('division_id');
        $plant_id    = $this->request->getPost('plant_id');
        $employee_group_id = $this->request->getPost('employee_group_id');

        return redirect()->to(
            base_url('attendance/reportmonthlydepartment') .
                '?' . http_build_query([
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'division_id' => $division_id,
                    'plant_id'   => $plant_id,
                    'employee_group_id' => $employee_group_id
                ])
        );
    }

    public function export_report_monthly_department()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $start_date = $this->request->getPost('start_date');
        $end_date   = $this->request->getPost('end_date');

        $division_id = resolveDivisionFilter($this->request->getPost('division_id'));
        $plant_id    = $this->request->getPost('plant_id');
        $employee_group_id = $this->request->getPost('employee_group_id');

        /**
         * =========================================================
         * PERIOD
         * =========================================================
         */
        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            (new DateTime($end_date))->modify('+1 day')
        );

        /**
         * =========================================================
         * EMPLOYEE MASTER
         * =========================================================
         */
        $employeeBuilder = $this->EmployeeModel
            ->select('
            e.id,
            e.employee_id,
            e.name,
            d.name as division,
            p.name as plant,
            eg.name as employee_group
        ')
            ->from('employee e')
            ->join('division d', 'd.id = e.division_id', 'left')
            ->join('plant p', 'p.id = e.plant_id', 'left')
            ->join('employee_group eg', 'eg.id = e.employee_group_id', 'left')
            ->whereIn('e.employee_status_id', [1, 2])
            ->where('e.division_id', $division_id);

        if (!empty($plant_id)) {
            $employeeBuilder->where('e.plant_id', $plant_id);
        }

        if (!empty($employee_group_id)) {
            $employeeBuilder->where('e.employee_group_id', $employee_group_id);
        }

        $employeesRaw = $employeeBuilder->findAll();

        $employees = [];
        foreach ($employeesRaw as $row) {
            $employees[$row->id] = $row;
        }

        /**
         * =========================================================
         * ATTENDANCE RAW
         * =========================================================
         */
        $list_data = $this->AttendanceModel->getAttendanceRaw(
            $start_date,
            $end_date,
            $division_id,
            $plant_id,
            $employee_group_id
        );

        /**
         * =========================================================
         * BUILD SCAN MAP
         * =========================================================
         */
        $scanMap = [];

        foreach ($list_data as $row) {

            $empId = $row->id;
            $date  = $row->date;
            $time  = $row->time;

            // if (!$empId || !$date || !$time) {
            //     continue;
            // }

            if (!isset($scanMap[$empId][$date])) {
                $scanMap[$empId][$date] = [
                    'in'  => null,
                    'out' => null,
                    'overtime' => '0.00'
                ];
            }

            if (!isset($scheduleMap[$empId][$date])) {
                $scheduleMap[$empId][$date] = $row->clock_out ?? null;
            }

            $inStart  = $row->start_scan_in;
            $inEnd    = $row->end_scan_in;
            $outStart = $row->start_scan_out;
            $outEnd   = $row->end_scan_out;

            $timeUnix     = strtotime($time);
            $inStartUnix  = strtotime($inStart);
            $inEndUnix    = strtotime($inEnd);
            $outStartUnix = strtotime($outStart);
            $outEndUnix   = strtotime($outEnd);

            $hasSchedule = $inStart && $inEnd && $outStart && $outEnd;

            /**
             * IN
             */
            if (
                !$hasSchedule ||
                ($timeUnix >= $inStartUnix && $timeUnix <= $inEndUnix)
            ) {
                if (
                    $scanMap[$empId][$date]['in'] === null ||
                    $timeUnix < strtotime($scanMap[$empId][$date]['in'])
                ) {
                    $scanMap[$empId][$date]['in'] = $time;
                }
            }

            /**
             * OUT
             */
            if (
                !$hasSchedule ||
                ($timeUnix >= $outStartUnix && $timeUnix <= $outEndUnix)
            ) {
                if (
                    $scanMap[$empId][$date]['out'] === null ||
                    $timeUnix > strtotime($scanMap[$empId][$date]['out'])
                ) {
                    $scanMap[$empId][$date]['out'] = $time;
                }
            }
        }

        foreach ($scanMap as $empId => $dates) {
            foreach ($dates as $date => $val) {

                $outTime  = $val['out'] ?? null;
                $clockOut = $scheduleMap[$empId][$date] ?? null;
                $inTime   = $val['in'] ?? null;

                if ($clockOut) {

                    // ADA SCHEDULE
                    $overtimeSeconds = strtotime($outTime) - strtotime($clockOut);

                    if ($overtimeSeconds > 0) {

                        $hours   = floor($overtimeSeconds / 3600);
                        $minutes = floor(($overtimeSeconds % 3600) / 60);

                        $scanMap[$empId][$date]['overtime'] =
                            $hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
                    }
                } else {

                    // TANPA SCHEDULE
                    if ($inTime && $outTime) {

                        $durationSeconds = strtotime($outTime) - strtotime($inTime);

                        if ($durationSeconds > 0) {

                            $hours   = floor($durationSeconds / 3600);
                            $minutes = floor(($durationSeconds % 3600) / 60);

                            $scanMap[$empId][$date]['overtime'] =
                                $hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
                        }
                    }
                }
            }
        }

        /**
         * =========================================================
         * HEADER (MERGE COLSPAN 2)
         * =========================================================
         */
        $rowHeader1 = 3;
        $col = 'A';

        /**
         * STATIC HEADER
         */
        $sheet->setCellValue($col++ . $rowHeader1, 'No');
        $sheet->setCellValue($col++ . $rowHeader1, 'Employee ID');
        $sheet->setCellValue($col++ . $rowHeader1, 'Name');
        $sheet->setCellValue($col++ . $rowHeader1, 'Division');
        $sheet->setCellValue($col++ . $rowHeader1, 'Plant');
        $sheet->setCellValue($col++ . $rowHeader1, 'Group');

        /**
         * DATE HEADER (NO IN/OUT)
         */
        foreach ($period as $date) {
            $sheet->setCellValue($col++ . $rowHeader1, $date->format('j M Y'));
        }

        /**
         * TOTAL OT
         */
        $sheet->setCellValue($col++ . $rowHeader1, 'TOTAL OT');

        /**
         * =========================================================
         * DATA START
         * =========================================================
         */
        $row = 4;
        $no = 1;

        foreach ($employees as $emp) {

            $col = 'A';
            $totalOvertimeMinutes = 0;

            // =========================
            // MASTER DATA ROWSPAN
            // =========================
            $sheet->mergeCells("A{$row}:A" . ($row + 1));
            $sheet->setCellValue("A{$row}", $no++);

            $sheet->mergeCells("B{$row}:B" . ($row + 1));
            $sheet->setCellValue("B{$row}", $emp->employee_id);

            $sheet->mergeCells("C{$row}:C" . ($row + 1));
            $sheet->setCellValue("C{$row}", $emp->name);

            $sheet->mergeCells("D{$row}:D" . ($row + 1));
            $sheet->setCellValue("D{$row}", $emp->division);

            $sheet->mergeCells("E{$row}:E" . ($row + 1));
            $sheet->setCellValue("E{$row}", $emp->plant);

            $sheet->mergeCells("F{$row}:F" . ($row + 1));
            $sheet->setCellValue("F{$row}", $emp->employee_group);

            $col = 'G';

            // =========================
            // IN OUT ROW
            // =========================
            foreach ($period as $date) {

                $tgl = $date->format('Y-m-d');

                $in  = $scanMap[$emp->id][$tgl]['in'] ?? '-';
                $out = $scanMap[$emp->id][$tgl]['out'] ?? '-';
                $ot  = $scanMap[$emp->id][$tgl]['overtime'] ?? '0.00';

                $sheet->setCellValue($col++ . $row, $in);
                $sheet->setCellValue($col++ . $row, $out);

                if ($ot !== '0.00') {
                    [$jam, $menit] = explode('.', $ot);
                    $totalOvertimeMinutes += ((int)$jam * 60) + (int)$menit;
                }
            }

            // =========================
            // TOTAL OT
            // =========================
            $totalJam   = floor($totalOvertimeMinutes / 60);
            $totalMenit = $totalOvertimeMinutes % 60;

            $totalOT = $totalJam . '.' . str_pad($totalMenit, 2, '0', STR_PAD_LEFT);

            $sheet->mergeCells($col . $row . ':' . $col . ($row + 1));
            $sheet->setCellValue($col . $row, $totalOT);

            // =========================
            // DETAIL OT ROW
            // =========================
            $col = 'G';

            foreach ($period as $date) {

                $tgl = $date->format('Y-m-d');
                $ot  = $scanMap[$emp->id][$tgl]['overtime'] ?? '0.00';

                $sheet->mergeCells($col . ($row + 1) . ':' . chr(ord($col) + 1) . ($row + 1));
                $sheet->setCellValue($col . ($row + 1), $ot !== '0.00' ? $ot : '-');

                $col++;
                $col++;
            }

            $row += 2;
        }

        /**
         * =========================================================
         * AUTO SIZE
         * =========================================================
         */
        foreach (range('A', $col) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        /**
         * =========================================================
         * DOWNLOAD
         * =========================================================
         */
        $filename = "Report_Attendance_" . date('dMY', strtotime($start_date)) .
            "_to_" . date('dMY', strtotime($end_date)) . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function employee_late_today($division_id = null)
    {
        // date fix hari ini
        $today = date('Y-m-d');

        $list_data = $this->AttendanceModel->employeeLateToday($today, $division_id);


        // load view
        $data = [
            'title' => 'Report Attendance Monthly Department',
            'date'  => $today,
            'list_data' => $list_data
        ];
        return view('attendance/employee_late_today', $data);
    }

    public function present_today()
    {
        $today = date('Y-m-d');
        $data = [
            'title'      => 'Employee Hadir',
            'thistoday'  => date('d F Y'),
            'list_data'  => $this->AttendanceModel->presentEmployeeToday($today)
        ];

        return view('attendance/present_today', $data);
    }

    public function absent_today($absent_type_id)
    {
        $today = date('Y-m-d');
        $absent_type = $this->AbsentTypeModel->where('id', $absent_type_id)->first();
        $data = [
            'title'      => 'Employee ' . ' ' . $absent_type->name,
            'thistoday'  => date('d F Y'),
            'list_data'  => $this->AttendanceModel->presentEmployeeAbsent($today, $absent_type_id)
        ];

        return view('attendance/present_today', $data);
    }

    function logAbsent($employee_id, $oldData, $newData)
    {
        if (
            $oldData->absent_type_id == $newData['absent_type_id']
        ) {
            return;
        }

        $this->LogHistoryAbsentModel->insertLog([
            'employee_id' => $employee_id,
            'absent_id' => $oldData->id,
            'employee_id' => $employee_id,
            'date' => $oldData->date,
            'status_before' => $oldData->absent_type_id,
            'status_after' => $newData['absent_type_id'],
            'changed_by' => user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
