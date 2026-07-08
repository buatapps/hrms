<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Overtime extends BaseController
{
    public function index()
    {
        $date = date('Y-m-d');
        $plant_id = 0;
        $employee_group_id = 0;

        $data = [
            'title'     => 'Overtime',
            'date'      => $date,
            'plant_id'  => $plant_id,
            'employee_group_id' => $employee_group_id,
            'plant'     => $this->PlantModel->findAll(),
            'group'     => $this->EmployeeGroupModel->findAll(),
            'list_data' => $this->OvertimeModel->dataOvertime($plant_id, $employee_group_id),
        ];

        return view('overtime/index', $data);
    }

    public function add()
    {
        $hariIni = date('w');
        $date = date('Y-m-d');

        // Siapkan default value
        $start_time = '';
        $end_time   = '';

        // Cek apakah hari kerja atau akhir pekan
        if ($hariIni >= 1 && $hariIni <= 5) {
            // Senin sampai Jumat
            $start_time = '16:30';
            $end_time   = '19:30';
        } else {
            // Sabtu & Minggu
            $start_time = '08:00';
            $end_time   = '16:30';
        }
        $data = [
            'title'     => 'Overtime Add',
            'employee'  => $this->EmployeeModel->findAll(),
            'start_time' => $start_time,
            'end_time'  => $end_time,
            'total_hours' => 3,
            'date'      => $date
        ];

        return view('overtime/add', $data);
    }

    public function save()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'employee_id' => 'required|numeric',
            'date'        => 'required|valid_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'total_hours' => 'required|numeric',
            'jobdesk'     => 'permit_empty|string',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'employee_id' => $this->request->getPost('employee_id'),
            'date'        => $this->request->getPost('date'),
            'jobdesk'     => $this->request->getPost('jobdesk'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_time'    => $this->request->getPost('end_time'),
            'total_hours' => $this->request->getPost('total_hours'),
        ];

        $this->OvertimeModel->save($data);

        return redirect()->to(base_url('overtime'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Overtime Edit',
            'employee' => $this->EmployeeModel->findAll(),
            'list_data' => $this->OvertimeModel->where(['id' => $id])->first()
        ];

        return view('overtime/edit', $data);
    }

    public function update()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'employee_id' => 'required|numeric',
            'date'        => 'required|valid_date',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'total_hours' => 'required|numeric',
            'jobdesk'     => 'permit_empty|string',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'employee_id' => $this->request->getPost('employee_id'),
            'date'        => $this->request->getPost('date'),
            'jobdesk'     => $this->request->getPost('jobdesk'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_time'    => $this->request->getPost('end_time'),
            'total_hours' => $this->request->getPost('total_hours'),
        ];

        $this->OvertimeModel->save($data);

        return redirect()->to(base_url('overtime'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->OvertimeModel->delete($id);
        return redirect()->to(base_url('overtime'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function report()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $plant_id = $this->request->getPost('plant_id');
        $employee_group_id = $this->request->getPost('employee_group_id');

        if (!$start_date || !$end_date) {
            $start_date = date('Y-m-20', strtotime('first day of last month'));
            $end_date = date('Y-m-19');
        }

        // NILAI DEFAULT
        if ($plant_id === null) {
            $plant_id = 0; // atau ID tertentu, misal 1
        }
        if ($employee_group_id === null) {
            $employee_group_id = 0; // atau ID tertentu, misal 2
        }


        $plant = $this->PlantModel->findAll();
        $employee_group = $this->EmployeeGroupModel->findAll();
        $employees = $this->EmployeeModel->dataEmployeeFilter($plant_id, $employee_group_id, $division_id);

        // Ambil semua data lembur dalam periode
        $overtimes = $this->OvertimeModel
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->findAll();

        // Buat peta lembur [employee_id][date] => total_hours
        $ot_map = [];
        foreach ($overtimes as $ot) {
            $ot_map[$ot->employee_id][$ot->date] = $ot->total_hours;
        }

        // Buat periode tanggal
        $period = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);
        while ($current <= $end) {
            $period[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }



        $data = [
            'title'      => 'Overtime Report',
            'start_date' => $start_date,
            'end_date'   => $end_date,
            'employees'  => $employees,
            'period'     => $period,
            'ot_map'     => $ot_map,
            'plant'      => $plant,
            'group'      => $employee_group,
            'plant_id'   => $plant_id,
            'employee_group_id' => $employee_group_id,
        ];

        return view('overtime/report', $data);
    }

    public function report_user()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $employee_id = $this->request->getPost('employee_id');

        if (!$start_date || !$end_date) {
            $start_date = date('Y-m-20', strtotime('first day of last month'));
            $end_date = date('Y-m-19');
        }

        $employee = $this->EmployeeModel->where(['division_id' => $division_id])->findAll();
        $employees = $this->EmployeeModel->dataEmployeeFilter2($employee_id, $division_id);

        // 🔁 Loop tanggal
        $dates = [];
        $current = strtotime($start_date);
        $last = strtotime($end_date);
        while ($current <= $last) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        // 🕒 Ambil data lembur per tanggal
        $overtime_data = [];
        foreach ($dates as $date) {
            $dataLembur = $this->OvertimeModel->getOvertimeByEmployeeAndDate($employee_id, $date);
            $overtime_data[] = [
                'date'      => $date,
                'name'      => $employees[0]->name ?? '',
                'total_hours'  => $dataLembur->total_hours ?? '',
                'jobdesk'   => $dataLembur->jobdesk ?? '',
            ];
        }

        $data = [
            'title'        => 'Overtime Report',
            'start_date'   => $start_date,
            'end_date'     => $end_date,
            'employee'     => $employee,
            'employee_id'  => $employee_id,
            'overtime_data' => $overtime_data
        ];

        return view('overtime/report_user', $data);
    }

    public function export()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $plant_id = $this->request->getPost('plant_id');
        $employee_group_id = $this->request->getPost('employee_group_id');

        // Ambil data karyawan
        $employees = $this->EmployeeModel->dataEmployeeFilter($plant_id, $employee_group_id, $division_id);

        // Ambil data lembur
        $overtimes = $this->OvertimeModel
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->findAll();

        // Mapping lembur
        $ot_map = [];
        foreach ($overtimes as $ot) {
            $ot_map[$ot->employee_id][$ot->date] = $ot->total_hours;
        }

        // Generate periode tanggal
        $period = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);
        while ($current <= $end) {
            $period[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        // Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $col = 'A';
        $sheet->setCellValue($col++ . '1', 'No');
        $sheet->setCellValue($col++ . '1', 'Name');
        $sheet->setCellValue($col++ . '1', 'Plant');
        $sheet->setCellValue($col++ . '1', 'Group');

        foreach ($period as $date) {
            $sheet->setCellValue($col++ . '1', date('d M', strtotime($date)));
        }
        $sheet->setCellValue($col . '1', 'Total');

        // Data
        $row = 2;
        $no = 1;
        foreach ($employees as $emp) {
            $col = 'A';
            $sheet->setCellValue($col++ . $row, $no++);
            $sheet->setCellValue($col++ . $row, $emp->name);
            $sheet->setCellValue($col++ . $row, $emp->plant);
            $sheet->setCellValue($col++ . $row, $emp->employee_group);

            $total = 0;
            foreach ($period as $date) {
                $hours = $ot_map[$emp->id][$date] ?? '';
                if ($hours !== '') $total += $hours;
                $sheet->setCellValue($col++ . $row, $hours);
            }
            $sheet->setCellValue($col . $row, $total);
            $row++;
        }

        $lastCol = $col; // col terakhir dari loop sebelumnya (sudah naik 1x dari yang dipakai)

        $lastRow = $row - 1; // row terakhir (karena barusan ++ terakhir)

        // Styling border all cells
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Output Excel
        $filename = 'overtime_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    public function export2()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $employee_id = $this->request->getPost('employee_id');

        if (!$start_date || !$end_date) {
            $start_date = date('Y-m-20', strtotime('first day of last month'));
            $end_date = date('Y-m-19');
        }

        $employee = $this->EmployeeModel->findAll();
        $employees = $this->EmployeeModel->dataEmployeeFilter2($employee_id, $division_id);

        // 🔁 Buat list tanggal
        $dates = [];
        $current = strtotime($start_date);
        $last = strtotime($end_date);
        while ($current <= $last) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        // 🕒 Ambil data lembur per tanggal
        $overtime_data = [];
        foreach ($dates as $date) {
            $dataLembur = $this->OvertimeModel->getOvertimeByEmployeeAndDate($employee_id, $date);
            $overtime_data[] = [
                'date'        => $date,
                'name'        => $employees[0]->name ?? '',
                'total_hours' => $dataLembur->total_hours ?? '',
                'jobdesk'     => $dataLembur->jobdesk ?? '',
            ];
        }

        // 📊 Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 📝 Header
        $header = ['No', 'Name', 'Date', 'Overtime', 'Jobdesk'];
        $col = 'A';
        foreach ($header as $head) {
            $sheet->setCellValue($col++ . '1', $head);
        }

        // 🧾 Isi data
        $total = 0;
        $row = 2;
        $no = 1;
        foreach ($overtime_data as $item) {
            $hours = (float) $item['total_hours'];
            $total += $hours;

            $col = 'A';
            $sheet->setCellValue($col++ . $row, $no++);
            $sheet->setCellValue($col++ . $row, $item['name']);
            $sheet->setCellValue($col++ . $row, date('d-m-Y', strtotime($item['date'])));
            $sheet->setCellValue($col++ . $row, $item['total_hours']);
            $sheet->setCellValue($col++ . $row, $item['jobdesk']);

            $row++;
        }

        // ➕ Tambah total di bawah
        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->mergeCells("A{$row}:C{$row}");
        $sheet->setCellValue('D' . $row, number_format($total, 2));
        $sheet->getStyle("A{$row}:D{$row}")->getFont()->setBold(true);

        // 🎨 Border semua data + total
        $lastCol = 'E';
        $lastRow = $row;
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // 📤 Output file
        $filename = 'overtime_' . str_replace(' ', '_', strtolower($employees[0]->name ?? 'unknown')) . '_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }


    public function form()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title' => 'Form',
            'list_data' => $this->OvertimeHeaderModel->dataForm($division_id)
        ];

        return view('overtime/form', $data);
    }

    public function form_add()
    {
        if (in_groups('admin')) {
            $division_id = user()->division_id;
        } else {
            $division_id = '';
        }
        $data = [
            'title' => 'Form Overtime',
            'employees' => $this->EmployeeModel->where(['employee_status_id !=' => 3, 'division_id' => $division_id])->findAll()
        ];

        return view('overtime/form_add', $data);
    }

    public function form_save()
    {

        $date = $this->request->getVar('date');
        $created_by = user()->id;

        $employee_id = $this->request->getVar('employee_id');
        $jobdesk = $this->request->getVar('jobdesk');
        $total_hours = $this->request->getVar('total_hours');

        $this->OvertimeHeaderModel->save([
            'date' => $date,
            'created_by' => $created_by,
            'status' => 'submitted'
        ]);

        $header_id = $this->OvertimeHeaderModel->db->insertID();

        // Simpan detail (contoh insertBatch)
        $details = [];
        foreach ($employee_id as $i => $emp) {
            $details[] = [
                'header_id'   => $header_id,
                'employee_id' => $emp,
                'jobdesk'     => $jobdesk[$i],
                'total_hours' => $total_hours[$i],
                'created_at'  => date('Y-m-d H:i:s')
            ];
        }

        if (!empty($details)) {
            $this->OvertimeDetailModel->insertBatch($details);
        }

        return redirect()->to(base_url('overtime/form'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function update_status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // Validasi input minimal
        if (!$id || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid input.'
            ]);
        }

        $update = $this->OvertimeHeaderModel->update($id, [
            'status' => $status
        ]);

        if ($update) {
            session()->setFlashdata('success', 'Status berhasil diperbarui!');
            return $this->response->setJSON([
                'success' => true,
                'redirect' => base_url('overtime/form')
            ]);
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui status.');
            return $this->response->setJSON([
                'success' => false,
                'redirect' => base_url('overtime/form')
            ]);
        }
    }

    public function form_edit($id)
    {
        $detail_data = $this->OvertimeDetailModel
            ->select('overtime_detail_form.*, data_employee.name as name')
            ->join('data_employee', 'data_employee.id = overtime_detail_form.employee_id')
            ->where('header_id', $id)
            ->findAll();
        $data = [
            'title'     => 'Edit Form',
            'header_data' => $this->OvertimeHeaderModel->where(['id' => $id])->first(),
            'detail_data' => $detail_data,
            'employees' => $this->EmployeeModel->findAll()
        ];

        return view('overtime/form_edit', $data);
    }

    public function delete_employee($header_id, $id)
    {
        $this->OvertimeDetailModel->delete($id);
        return redirect()->to(base_url('overtime/form_edit/' . $header_id))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function form_update($header_id)
    {
        $date = $this->request->getVar('date');

        $employee_id = $this->request->getVar('employee_id');
        $jobdesk = $this->request->getVar('jobdesk');
        $total_hours = $this->request->getVar('total_hours');

        $this->OvertimeHeaderModel->update($header_id, [
            'date' => $date
        ]);

        $this->OvertimeDetailModel
            ->where('header_id', $header_id)
            ->delete();

        // Simpan detail (contoh insertBatch)
        $details = [];
        foreach ($employee_id as $i => $emp) {
            $details[] = [
                'header_id'   => $header_id,
                'employee_id' => $emp,
                'jobdesk'     => $jobdesk[$i],
                'total_hours' => $total_hours[$i],
                'created_at'  => date('Y-m-d H:i:s')
            ];
        }

        if (!empty($details)) {
            $this->OvertimeDetailModel->insertBatch($details);
        }

        return redirect()->to(base_url('overtime/form'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function form_delete($id)
    {
        $this->OvertimeHeaderModel->delete($id);
        $this->OvertimeDetailModel
            ->where('header_id', $id)
            ->delete();
        return redirect()->to(base_url('overtime/form'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function form_detail($id)
    {
        $detail_data = $this->OvertimeDetailModel
            ->join('data_employee', 'data_employee.id = overtime_detail_form.employee_id')
            ->where('header_id', $id)
            ->findAll();


        $header_data = $this->OvertimeHeaderModel
            ->select('overtime_header_form.*, users.username')
            ->join('users', 'users.id = overtime_header_form.created_by')
            ->where('overtime_header_form.id', $id)
            ->first();
        $data = [
            'title'      => 'Details Form',
            'header_data' => $header_data,
            'detail_data' => $detail_data,
        ];

        return view('overtime/details_form', $data);
    }

    public function form_print($id)
    {
        $detail_data = $this->OvertimeDetailModel
            ->join('data_employee', 'data_employee.id = overtime_detail_form.employee_id')
            ->where('header_id', $id)
            ->findAll();


        $header_data = $this->OvertimeHeaderModel
            ->select('overtime_header_form.*, users.username')
            ->join('users', 'users.id = overtime_header_form.created_by')
            ->where('overtime_header_form.id', $id)
            ->first();

        return view('overtime/form_print', [
            'header_data' => $header_data,
            'detail_data' => $detail_data,
        ]);
    }
}
