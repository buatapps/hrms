<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
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

class Dashboard extends BaseController
{

    public function index()
    {
        if (in_groups('Japan')) {
            $thistoday = date('d F Y');
            $today = date('Y-m-d');

            $date = $this->request->getGet('date') ?? date('Y-m-d');
            $startDate  = $this->request->getGet('start_date') ?? date('Y-m-d');
            $endDate    = $this->request->getGet('end_date') ?? date('Y-m-d');
            $divisionId = $this->request->getGet('division_id');

            if ($divisionId === '' || $divisionId === null || $divisionId === 'all') {
                $divisionId = null;
            }

            $selectedDivisionId = $divisionId ?? 'all';

            $filterChart = $this->getGlobalFilterUI(
                $this->request->getGet('division_id'),
                $this->request->getGet('start_date'),
                $this->request->getGet('end_date')
            );

            // Summary Employee
            $namicoh = $this->getEmployeeSummary('namicoh');
            $japan   = $this->getEmployeeSummary('japan');
            // End Summary Employee

            //Percentage
            $attendancePercentage = $this->getAttendancePercentage($startDate, $endDate, $divisionId);
            //end percentage

            //percentage per departemen
            $attendanceDepartment  = $this->getAttendancePercentagePerDepartment($startDate, $endDate, $divisionId);
            //end percentage per departemen

            //division chart bar
            $divisionChart = $this->getDivisionChart();
            //end division chart bar

            //non Schedule
            $dayRaw = $this->DashboardModel->getNonSchedule($startDate, $endDate, [1, 5], 'day');

            $nightRaw = $this->DashboardModel->getNonSchedule($startDate, $endDate, [2, 6], 'night');

            $nonScheduleDay = [
                'listNonSchedule' => $dayRaw,
                'totalNonSchedule' => count($dayRaw),
                'type' => 'day'
            ];

            $nonScheduleNight = [
                'listNonSchedule' => $nightRaw,
                'totalNonSchedule' => count($nightRaw),
                'type' => 'night'
            ];

            //end non schedule

            $data = [
                'title'             => 'Dashboard',
                'today'             => $today,
                'thistoday'         => $thistoday,
                'date'              => $date,
                'divisionId'        => $divisionId,
                'japan'             => $japan,
                'namicoh'           => $namicoh,
                'nonScheduleDay'    => $nonScheduleDay,
                'nonScheduleNight'  => $nonScheduleNight,
                'selectedDivisionId' => $selectedDivisionId
            ];
            $data = array_merge($data,  $divisionChart, $attendancePercentage, $filterChart, $attendanceDepartment);
            return view('dashboard/dashboard_japan', $data);
        } else {

            $data = [
                'title' => ''
            ];
            return view('dashboard/index', $data);
        }
    }

    private function getEmployeeSummary($type = 'namicoh')
    {
        if ($type === 'namicoh') {
            return [
                'total'           => $this->DashboardModel->countEmployee(null, null, 1, 12, null),
                'nonactive'       => $this->DashboardModel->countEmployee(3, null, 1, 12, null),
                'activePermanent' => $this->DashboardModel->countEmployee(1, null, 1, 12, null),
                'activeContract'  => $this->DashboardModel->countEmployee(2, null, 1, 12, null),
                'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, 1, 12, null),
                'men'             => $this->DashboardModel->countEmployee([1, 2], 1, 1, 12, null),
                'women'           => $this->DashboardModel->countEmployee([1, 2], 2, 1, 12, null),
            ];
        }

        if ($type === 'japan') {
            return [
                'total'           => $this->DashboardModel->countEmployee(null, null, null, null, 12),
                'nonactive'       => $this->DashboardModel->countEmployee(3, null, null, null, 12),
                'activePermanent' => $this->DashboardModel->countEmployee(1, null, null, null, 12),
                'activeContract'  => $this->DashboardModel->countEmployee(2, null, null, null, 12),
                'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, null, null, 12),
                'men'             => $this->DashboardModel->countEmployee(null, 1, null, null, 12),
                'women'           => $this->DashboardModel->countEmployee(null, 2, null, null, 12),
            ];
        }

        return [];
    }

    private function getGlobalFilterUI($divisionId, $startDate, $endDate)
    {
        $db = \Config\Database::connect();

        $division = $db->table('division')
            ->select('id, name')
            ->where('deleted_at', null, false)
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $divisionName = '';
        foreach ($division as $d) {
            if ($d['id'] == $divisionId) {
                $divisionName = $d['name'];
                break;
            }
        }

        // format label periode baru
        $periodeLabel = $divisionName . ' | ' .
            date('d M Y', strtotime($startDate)) .
            ' - ' .
            date('d M Y', strtotime($endDate));

        return [
            'division'      => $division,
            'division_id'   => $divisionId,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'periodeLabel'  => $periodeLabel,
        ];
    }

    private function getDivisionChart()
    {
        $divisionRaw = $this->DashboardModel->employeeByDivision();

        $labels = [];
        $series = [];

        foreach ($divisionRaw as $row) {
            $labels[] = $row['name'];
            $series[] = (int) $row['total'];
        }

        return [
            'divisionLabels' => $labels,
            'divisionSeries' => $series,
        ];
    }

    private function getAttendancePercentage($startDate, $endDate, $divisionId = null)
    {
        $plants = $this->PlantModel->findAll();

        // =========================
        // TOTAL SCHEDULE
        // =========================
        $totalDayShift = $this->DashboardModel->getTotalShiftByRange(
            $startDate,
            $endDate,
            [1, 5],
            $divisionId
        );

        $totalNightShift = $this->DashboardModel->getTotalShiftByRange(
            $startDate,
            $endDate,
            [2, 6],
            $divisionId
        );

        // =========================
        // ATTENDANCE BY PLANT
        // =========================
        $attendanceDay = $this->DashboardModel->getAttendancePerPlantRange(
            $startDate,
            $endDate,
            [1, 5],
            $divisionId
        );

        $attendanceNight = $this->DashboardModel->getAttendancePerPlantRange(
            $startDate,
            $endDate,
            [2, 6],
            $divisionId
        );

        // =========================
        // MAPPING ATTENDANCE
        // =========================
        $attendanceDayMap = [];
        $totalDay = 0;

        foreach ($attendanceDay as $row) {
            $attendanceDayMap[$row->plant_id] = $row->total;
            $totalDay += $row->total;
        }

        $attendanceNightMap = [];
        $totalNight = 0;

        foreach ($attendanceNight as $row) {
            $attendanceNightMap[$row->plant_id] = $row->total;
            $totalNight += $row->total;
        }

        // =========================
        // SCHEDULE PER PLANT
        // =========================
        $dayShiftPerPlant = $this->DashboardModel->getTotalShiftPerPlantRange(
            $startDate,
            $endDate,
            [1, 5],
            $divisionId
        );

        $nightShiftPerPlant = $this->DashboardModel->getTotalShiftPerPlantRange(
            $startDate,
            $endDate,
            [2, 6],
            $divisionId
        );

        $dayMap = [];
        foreach ($dayShiftPerPlant as $row) {
            $dayMap[$row->plant_id] = $row->total;
        }

        $nightMap = [];
        foreach ($nightShiftPerPlant as $row) {
            $nightMap[$row->plant_id] = $row->total;
        }

        // =========================
        // PERIODE LABEL
        // =========================
        $periodDayShift = formatTanggalIndo($startDate) . ' - ' . formatTanggalIndo($endDate);

        $nightStartDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
        $nightEndDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));

        $periodNightShift = formatTanggalIndo($nightStartDate) . ' - ' . formatTanggalIndo($nightEndDate);

        // =========================
        // OUTPUT
        // =========================
        return [
            'plants' => $plants,

            'totalDayShift' => $totalDayShift,
            'totalNightShift' => $totalNightShift,

            'dayMap' => $dayMap,
            'nightMap' => $nightMap,

            'attendanceDayMap' => $attendanceDayMap,
            'attendanceNightMap' => $attendanceNightMap,

            'totalDay' => $totalDay,
            'totalNight' => $totalNight,

            'startDate' => $startDate,
            'endDate' => $endDate,

            'divisionId' => $divisionId,

            'periodDayShift' => $periodDayShift,
            'periodNightShift' => $periodNightShift,
        ];
    }

    private function getAttendancePercentagePerDepartment($startDate, $endDate, $divisionId = null)
    {
        // =========================
        // GET DATA
        // =========================
        $daySchedule = $this->DashboardModel
            ->getTotalShiftPerDepartmentRange($startDate, $endDate, [1, 5], $divisionId);

        $nightSchedule = $this->DashboardModel
            ->getTotalShiftPerDepartmentRange($startDate, $endDate, [2, 6], $divisionId);

        $dayAttendance = $this->DashboardModel
            ->getAttendancePerDepartmentRange($startDate, $endDate, [1, 5], $divisionId);

        $nightAttendance = $this->DashboardModel
            ->getAttendancePerDepartmentRange($startDate, $endDate, [2, 6], $divisionId);

        // =========================
        // MAPPING SCHEDULE
        // =========================
        $dayScheduleMap = [];

        foreach ($daySchedule as $row) {
            $dayScheduleMap[$row->plant_id][$row->division_id] = [
                'division_name' => $row->division_name,
                'total'         => $row->total
            ];
        }

        $nightScheduleMap = [];

        foreach ($nightSchedule as $row) {
            $nightScheduleMap[$row->plant_id][$row->division_id] = [
                'division_name' => $row->division_name,
                'total'         => $row->total
            ];
        }

        // =========================
        // MAPPING ATTENDANCE
        // =========================
        $dayAttendanceMap = [];

        foreach ($dayAttendance as $row) {
            $dayAttendanceMap[$row->plant_id][$row->division_id] = [
                'division_name' => $row->division_name,
                'total'         => $row->total
            ];
        }

        $nightAttendanceMap = [];

        foreach ($nightAttendance as $row) {
            $nightAttendanceMap[$row->plant_id][$row->division_id] = [
                'division_name' => $row->division_name,
                'total'         => $row->total
            ];
        }

        // =========================
        // RETURN
        // =========================
        return [
            'dayScheduleDepartmentMap'     => $dayScheduleMap,
            'nightScheduleDepartmentMap'   => $nightScheduleMap,

            'dayAttendanceDepartmentMap'   => $dayAttendanceMap,
            'nightAttendanceDepartmentMap' => $nightAttendanceMap,

            'divisionId' => $divisionId,
        ];
    }

    public function absent_employee($startDate, $endDate, $type, $plantId = null, $divisionId = null)
    {
        // =========================
        // SHIFT CONFIG
        // =========================
        $shiftIds = ($type === 'day') ? [1, 5] : [2, 6];

        // normalize division
        $divisionId = ($divisionId === 'all' || empty($divisionId)) ? null : $divisionId;

        // =========================
        // GET DATA
        // =========================
        $listAbsent = $this->DashboardModel
            ->getScheduledAbsent($startDate, $endDate, $shiftIds, $type, $divisionId);

        // =========================
        // OPTIONAL FILTER BY PLANT
        // =========================
        if ($plantId) {
            $listAbsent = array_filter($listAbsent, function ($row) use ($plantId) {
                return $row->plant_id == $plantId;
            });
        }

        // ABSENT
        $absentData = $this->AbsentModel
            ->select('absent.*, absent_type.name as type_name')
            ->join('absent_type', 'absent_type.id = absent.absent_type_id', 'left')
            ->where('absent.deleted_at', null)
            ->findAll();

        $absentMap = [];

        foreach ($absentData as $absent) {

            $date = date('Y-m-d', strtotime($absent->date));

            $absentMap[$absent->employee_id][$date] = $absent;
        }

        return view('dashboard/absent_employee', [
            'title'       => 'Absent Employee',
            'listAbsent'  => $listAbsent,
            'startDate'   => $startDate,
            'endDate'     => $endDate,
            'type'        => $type,
            'plantId'     => $plantId,
            'divisionId'  => $divisionId,
            'absentMap'   => $absentMap
        ]);
    }

    // public function absent_plant_new($today, $shift, $plantID)
    // {
    //     // Tentukan shift & range waktu
    //     if ($shift === 'day') {
    //         $start = $today . ' 05:00:00';
    //         $end   = $today . ' 14:59:59';
    //         $shiftIds = [1, 5];
    //     } else { // night
    //         $nightDate = date('Y-m-d', strtotime($today . ' -1 day'));
    //         $start = $nightDate . ' 15:00:00';
    //         $end   = $today . ' 04:59:59';
    //         $shiftIds = [2, 6];
    //     }

    //     $absentList = $this->DashboardModel->getAbsentPerPlant(
    //         $today,
    //         $start,
    //         $end,
    //         $shiftIds,
    //         $plantID
    //     );

    //     $data = [
    //         'title' => 'Absent Plant',
    //         'thistoday' => $today,
    //         'shift_name' => $shift,
    //         'plant_name' => 'PLANT ' . $plantID,
    //         'absentList' => $absentList
    //     ];

    //     return view('dashboard/absent_detail', $data);
    // }

    //============================= versi single day =========================================
    // private function getAttendancePercentage($startDate, $endDate)
    // {
    //     $totalDayShift = $this->DashboardModel->getTotalShiftByDate($date, [1, 5]);
    //     $totalNightShift = $this->DashboardModel->getTotalShiftByDate($date, [2, 6]);

    //     $notSchedule = $this->DashboardModel->getEmployeeWithoutScheduleToday($date)->countAllResults();
    //     $buildernotschedule = $this->DashboardModel->getEmployeeWithoutScheduleToday($date);

    //     $listNotSchedule = $buildernotschedule->select('e.id, e.name, e.employee_id')
    //         ->orderBy('e.name', 'ASC')
    //         ->get()
    //         ->getResult();

    //     $plants = $this->PlantModel->findAll();

    //     $dayShiftPerPlant = $this->DashboardModel->getTotalShiftPerPlant($date, [1, 5]);
    //     $nightShiftPerPlant = $this->DashboardModel->getTotalShiftPerPlant($date, [2, 6]);

    //     $dayMap = [];
    //     foreach ($dayShiftPerPlant as $row) {
    //         $dayMap[$row->plant_id] = $row->total;
    //     }

    //     $nightMap = [];
    //     foreach ($nightShiftPerPlant as $row) {
    //         $nightMap[$row->plant_id] = $row->total;
    //     }

    //     $dayStart = $date . ' 05:00:00';
    //     $dayEnd   = $date . ' 14:59:59';

    //     $attendanceDay = $this->DashboardModel->getAttendancePerPlant(
    //         $date,
    //         $dayStart,
    //         $dayEnd,
    //         [1, 5]
    //     );

    //     $nightDate = date('Y-m-d', strtotime($date . ' -1 day'));
    //     $nightStart = $nightDate . ' 15:00:00';
    //     $nightEnd   = $date . ' 04:59:59';

    //     $attendanceNight = $this->DashboardModel->getAttendancePerPlant(
    //         $nightDate,
    //         $nightStart,
    //         $nightEnd,
    //         [2, 6]
    //     );

    //     $totalDay = 0;
    //     $attendanceDayMap = [];

    //     foreach ($attendanceDay as $row) {
    //         $attendanceDayMap[$row->plant_id] = $row->total;
    //         $totalDay += $row->total;
    //     }

    //     $totalNight = 0;
    //     $attendanceNightMap = [];

    //     foreach ($attendanceNight as $row) {
    //         $attendanceNightMap[$row->plant_id] = $row->total;
    //         $totalNight += $row->total;
    //     }

    //     $thistodayPercentage = date('d F Y', strtotime($date));

    //     $todayFormat = formatTanggalIndo($date);
    //     $nightDateFormat = formatTanggalIndo($nightDate);

    //     return [
    //         'totalDayShift' => $totalDayShift,
    //         'totalNightShift' => $totalNightShift,
    //         'notSchedule' => $notSchedule,
    //         'listNotSchedule' => $listNotSchedule,
    //         'plants' => $plants,
    //         'dayMap' => $dayMap,
    //         'nightMap' => $nightMap,
    //         'attendanceDayMap' => $attendanceDayMap,
    //         'attendanceNightMap' => $attendanceNightMap,
    //         'totalDay' => $totalDay,
    //         'totalNight' => $totalNight,
    //         'todayFormat' => $todayFormat,
    //         'nightDateFormat' => $nightDateFormat,
    //         'thistodayPercentage' => $thistodayPercentage,
    //     ];
    // }

    // private function getDivisionFilterChart($divisionId, $month, $year)
    // {
    //     $db = \Config\Database::connect();

    //     $division = $db->table('division')
    //         ->select('id, name')
    //         ->where('deleted_at', null, false)
    //         ->orderBy('name', 'ASC')
    //         ->get()
    //         ->getResultArray();

    //     $divisionName = '';
    //     foreach ($division as $d) {
    //         if ($d['id'] == $divisionId) {
    //             $divisionName = $d['name'];
    //             break;
    //         }
    //     }

    //     $monthName = date('F', mktime(0, 0, 0, $month, 1));
    //     $periodeLabel = $year . ' ' . $monthName . ' - ' . $divisionName;

    //     return [
    //         'division'      => $division,
    //         'periodeLabel'  => $periodeLabel,
    //         'division_id'   => $divisionId,
    //         'month_input'   => $month,
    //         'year_input'    => $year,
    //     ];
    // }

    public function chartDivision()
    {
        // =========================
        // GLOBAL FILTER INPUT
        // =========================
        $startDate  = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate    = $this->request->getGet('end_date') ?? date('Y-m-t');
        $divisionId = $this->request->getGet('division_id');

        if ($divisionId === 'all') {
            $divisionId = null;
        }

        // =========================
        // DATA FROM MODEL (UPDATED KPI VERSION)
        // =========================
        $data_chart_bar = $this->DashboardModel
            ->getAbsentDivisionRange($startDate, $endDate, $divisionId);

        // =========================
        // DIVISION MASTER (OPTIONAL FILTER SAFE)
        // =========================
        $db = \Config\Database::connect();

        $divisions = $db->table('division')
            ->select('id, name')
            ->where('deleted_at', null)
            ->when(!empty($divisionId), function ($q) use ($divisionId) {
                return $q->where('id', $divisionId);
            })
            ->where('id !=', 12)
            ->get()
            ->getResultArray();

        // =========================
        // ABSENT TYPES
        // =========================
        $absentTypes = $db->table('absent_type')
            ->select('id, name')
            ->whereIn('id', [1, 2, 6, 7, 16])
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $extraTypes = ['Cuti Monday', 'Cuti Friday'];

        $typeNames = array_column($absentTypes, 'name');
        $allTypes  = array_merge($typeNames, $extraTypes);

        // =========================
        // INIT MATRIX
        // =========================
        $matrix = [];

        foreach ($allTypes as $type) {
            foreach ($divisions as $div) {
                $matrix[$type][$div['name']] = 0;
            }
        }

        // =========================
        // FILL MATRIX
        // =========================
        foreach ($data_chart_bar as $row) {

            $type = $row['absent_type'];
            $div  = $row['division'];

            $matrix[$type][$div] = ($matrix[$type][$div] ?? 0) + (int) $row['total'];

            // CUTI SPECIAL CASE
            if ($row['absent_type_id'] == 16) {

                $day = (int) date('N', strtotime($row['date']));

                if ($day == 1) {
                    $matrix['Cuti Monday'][$div] += (int) $row['total'];
                }

                if ($day == 5) {
                    $matrix['Cuti Friday'][$div] += (int) $row['total'];
                }
            }
        }

        // =========================
        // BUILD SERIES
        // =========================
        $categories = array_column($divisions, 'name');
        $series = [];

        foreach ($allTypes as $type) {

            $data = [];

            foreach ($divisions as $div) {
                $data[] = $matrix[$type][$div['name']] ?? 0;
            }

            $series[] = [
                'name' => $type,
                'data' => $data
            ];
        }

        // =========================
        // RESPONSE
        // =========================
        return $this->response->setJSON([
            'categories' => $categories,
            'series'     => $series,
            'period'     => date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate))
        ]);
    }

    public function chartEmployeePerformance()
    {
        $divisionId = $this->request->getGet('division_id');

        if (!is_numeric($divisionId)) {
            $divisionId = null;
        } else {
            $divisionId = (int)$divisionId;
        }

        $startDate  = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate    = $this->request->getGet('end_date') ?? date('Y-m-t');

        $absentGroups = [
            'sakit' => [2],
            'alpa' => [1],
            'late_coming' => [4],
            'cuti' => [12, 13, 16]
        ];

        $result = [];

        foreach ($absentGroups as $key => $typeIds) {
            $result[$key] = $this->DashboardModel->getAbsentDivisionRangeType(
                $startDate,
                $endDate,
                $divisionId,
                $typeIds
            );
        }

        foreach ($result as $key => &$items) {

            $map = [];

            foreach ($items as $row) {
                $name = $row['employee_name'];

                if (!isset($map[$name])) {
                    $map[$name] = 0;
                }

                $map[$name] += $row['total'];
            }

            arsort($map);

            $sorted = [];
            foreach ($map as $name => $total) {
                $sorted[] = [
                    'employee_name' => $name,
                    'total' => $total
                ];
            }

            $result[$key] = $sorted;
        }

        $periodLabel = formatTanggalIndo($startDate) . " - " . formatTanggalIndo($endDate);

        return $this->response->setJSON([
            'debug' => $result,
            'charts' => $result,
            'period' => $periodLabel
        ]);
    }

    private function buildChartAbsentEmployee($divisionId, $month, $year, $absentTypeId)
    {
        $db = \Config\Database::connect();

        $dataRaw = $this->DashboardModel
            ->getChartAbsentEmployee($divisionId, $month, $year, $absentTypeId);

        $typeName = $db->table('absent_type')
            ->select('name')
            ->whereIn('id', $absentTypeId)
            ->get()
            ->getResultArray();

        $typeName = array_column($typeName, 'name');
        $typeName = implode(', ', $typeName);

        $categories = [];
        $seriesData = [];

        foreach ($dataRaw ?? [] as $row) {
            $categories[] = $row['employee_name'];
            $seriesData[] = (int) $row['total'];
        }

        if (empty($categories)) {
            $categories[] = 'No Data';
            $seriesData[] = 0;
        }

        return [
            'categories' => $categories,
            'series' => [
                [
                    'name' => $typeName,
                    'data' => $seriesData
                ]
            ]
        ];
    }

    public function chartAbsentTrend()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate   = $this->request->getGet('end_date') ?? date('Y-m-t');

        $divisionId = $this->request->getGet('division_id');

        if (!is_numeric($divisionId)) {
            $divisionId = null;
        } else {
            $divisionId = (int)$divisionId;
        }

        $db = \Config\Database::connect();

        $types = $db->table('absent_type')
            ->select('id, name')
            ->where('deleted_at', null)
            ->get()
            ->getResultArray();

        // =====================================
        // BUILD DATE RANGE (IMPORTANT PART)
        // =====================================
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        $categories = [];
        $dateKeys = [];

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');

            $categories[] = $date->format('d M Y');
            $dateKeys[] = $key;
        }

        $series = [];

        foreach ($types as $type) {

            $dataRaw = $this->DashboardModel
                ->getAbsentTrendByRange(
                    $startDate,
                    $endDate,
                    [$type['id']],
                    $divisionId
                );

            // map date → total
            $map = [];

            foreach ($dataRaw as $row) {
                $map[$row['date']] = (int) $row['total'];
            }

            $data = [];

            foreach ($dateKeys as $key) {
                $data[] = $map[$key] ?? 0;
            }

            $series[] = [
                'name' => $type['name'],
                'data' => $data
            ];
        }

        return $this->response->setJSON([
            'charts' => [
                'categories' => $categories,
                'series' => $series
            ],
            'period' => date('d M Y', strtotime($startDate))
                . ' - ' .
                date('d M Y', strtotime($endDate))
        ]);
    }

    // public function chartMonthlyAbsentTrend()
    // {
    //     $month = (int) ($this->request->getGet('month') ?? date('m'));
    //     $year  = (int) ($this->request->getGet('year') ?? date('Y'));
    //     $divisionId = $this->request->getGet('division_id') ?? null;
    //     // $month = 3;
    //     // $year  = 2026;


    //     $db = \Config\Database::connect();

    //     // ambil semua absent type
    //     $types = $db->table('absent_type')
    //         ->select('id, name')
    //         ->where('deleted_at', null)
    //         ->get()
    //         ->getResultArray();

    //     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //     // categories tanggal
    //     $categories = [];
    //     for ($i = 1; $i <= $daysInMonth; $i++) {
    //         $categories[] = (string)$i;
    //     }

    //     $series = [];

    //     foreach ($types as $type) {

    //         $dataRaw = $this->DashboardModel
    //             ->getMonthlyAbsentTrend($month, $year, [$type['id']], $divisionId);

    //         $map = [];
    //         foreach ($dataRaw as $row) {
    //             $map[(int)$row['day']] = (int)$row['total'];
    //         }

    //         $data = [];
    //         for ($i = 1; $i <= $daysInMonth; $i++) {
    //             $data[] = $map[$i] ?? 0;
    //         }

    //         $series[] = [
    //             'name' => $type['name'],
    //             'data' => $data
    //         ];
    //     }

    //     $periodLabel = date('F Y', strtotime("$year-$month-01"));


    //     return $this->response->setJSON([
    //         'debug' => [
    //             'month' => $month,
    //             'year' => $year,
    //             'division' => $divisionId
    //         ],
    //         'charts' => [
    //             'categories' => $categories,
    //             'series' => $series
    //         ],
    //         'period' => $periodLabel
    //     ]);
    // }

    // private function isShiftActive($shiftIds)
    // {
    //     $currentTime = date('H:i:s');
    //     $startTime = $this->DashboardModel->getShiftStartTime($shiftIds);

    //     return $startTime && $currentTime >= $startTime;
    // }

    public function dashboard_employee()
    {

        $month = date('m');
        $year  = date('Y');
        $thistoday = date('d F Y'); // hasil: 21 January 2026
        $today = date('Y-m-d');

        $thistoday = date('d F Y');
        $today = date('Y-m-d');

        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $startDate  = $this->request->getGet('start_date') ?? date('Y-m-d');
        $endDate    = $this->request->getGet('end_date') ?? date('Y-m-d');
        $divisionId = $this->request->getGet('division_id');

        $divisionId = ($divisionId === 'all' || empty($divisionId))
            ? null
            : $divisionId;

        $filterChart = $this->getGlobalFilterUI(
            $this->request->getGet('division_id'),
            $this->request->getGet('start_date'),
            $this->request->getGet('end_date')
        );

        // Summary Employee
        $namicoh = $this->getEmployeeSummary('namicoh');
        $japan   = $this->getEmployeeSummary('japan');
        // End Summary Employee

        $divisionRaw = $this->DashboardModel->employeeByDivision();
        $divisionLabels = [];
        $divisionSeries = [];

        foreach ($divisionRaw as $row) {
            $divisionLabels[] = $row['name'];
            $divisionSeries[] = (int) $row['total'];
        }

        $monthlyDivision = $this->DashboardModel->employeeJoinThisMonthByDivision();
        $monthlyTotal    = array_sum(array_column($monthlyDivision, 'total'));



        $resignDivision = $this->DashboardModel->employeeResignByDivision($month, $year);
        $resignTotal    = $this->DashboardModel->totalEmployeeResign($month, $year);

        $contractDivision = $this->DashboardModel->employeeContractEndByDivision($month, $year);
        $contractTotal    = $this->DashboardModel->totalEmployeeContractEnd($month, $year);



        $lateToday = $this->DashboardModel->employeeLateTodayByDivision($today);

        $postionRaw = $this->DashboardModel->getTotalPerJabatan();
        $categories = [];
        $totals     = [];

        foreach ($postionRaw as $row2) {
            $categories[] = $row2['position'] . '(' . $row2['total'] . ')';
            $totals[]     = (int) $row2['total'];
        }

        $summary = [];

        // Hadir
        $summary[] = [
            'name'  => 'Hadir',
            'total' => $this->DashboardModel->totalHadirToday($today),
            'type'  => 'present'
        ];

        // Absent
        $absents = $this->DashboardModel->totalAbsentByTypeToday($today);
        foreach ($absents as $row) {
            $summary[] = [
                'name'            => $row['name'],
                'total'           => $row['total'],
                'absent_type_id'  => $row['absent_type_id'],
                'type'            => 'absent'
            ];
        }

        //chart line
        $currentMonth = date('n'); // 1-12
        $currentYear  = date('Y');

        $monthsMap = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        $endMonth = ($currentMonth == 12) ? 12 : $currentMonth + 1;

        $series = [];

        // Loop semua bulan dari 1–12 untuk sumbu
        for ($m = 1; $m <= 12; $m++) {
            // Hanya ambil data sampai endMonth
            if ($m > $endMonth) {
                continue;
            }

            $rows = $this->DashboardModel
                ->getTotalEmployeePerDivisionUpToMonth($m, $currentYear);

            foreach ($rows as $row) {
                $division = $row['division'];
                $total    = (int) $row['total'];

                if (!isset($series[$division])) {
                    $series[$division] = [
                        'name' => $division,
                        'data' => array_fill(0, 12, null)
                    ];
                }

                // index 0 = Januari
                $series[$division]['data'][$m - 1] = $total;
            }
        }

        // Reset series array agar numerik untuk ApexCharts
        $series = array_values($series);

        // Sumbu X tetap full Jan–Des
        $categories2 = array_values($monthsMap);



        //Chart Bar Absent Type
        $categories_3 = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $categories_3[] = $d;
        }

        $series_3 = $this->DashboardModel->totalAbsentPerTypeMonth($year, $month);

        //percentage
        $attendancePercentage = $this->getAttendancePercentage($startDate, $endDate);
        //end percentage

        //non Schedule
        $dayRaw = $this->DashboardModel->getNonSchedule($startDate, $endDate, [1, 5], 'day');

        $nightRaw = $this->DashboardModel->getNonSchedule($startDate, $endDate, [2, 6], 'night');

        $nonScheduleDay = [
            'listNonSchedule' => $dayRaw,
            'totalNonSchedule' => count($dayRaw),
            'type' => 'day'
        ];

        $nonScheduleNight = [
            'listNonSchedule' => $nightRaw,
            'totalNonSchedule' => count($nightRaw),
            'type' => 'night'
        ];

        $data = [
            'title'     => 'Dashboard Employee',
            'today' => $today,
            'date' => $date,
            'japan'     => $japan,
            'namicoh'     => $namicoh,
            'divisionLabels' => $divisionLabels,
            'divisionSeries' => $divisionSeries,
            'jabatanCategories' => $categories,
            'jabatanTotals' => $totals,
            'months' => $categories2,
            'seriesLineDivision' => $series,
            'monthlyDivision' => $monthlyDivision,
            'monthlyTotal' => $monthlyTotal,
            'resignDivision' => $resignDivision,
            'resignTotal' => $resignTotal,
            'contractDivision' => $contractDivision,
            'contractTotal' => $contractTotal,
            'lateToday' => $lateToday,
            'summary' => $summary,
            'series_3' => $series_3,
            'categories_3' => $categories_3,
            'name_month'     => date('F') . ' ' . $year,
            'thistoday'     => $thistoday,
            'nonScheduleDay' => $nonScheduleDay,
            'nonScheduleNight' => $nonScheduleNight,
            'month_input' => $month,
            'year_input' => $year
        ];
        $data = array_merge($data, $attendancePercentage, $filterChart);
        return view('dashboard/dashboard_employee', $data);
    }

    public function late()
    {
        $today = new Time('now');
        $dates = explode(' ', $today);
        $division_id = in_groups('admin') ? user()->division_id : null;
        $employe_late = $this->DashboardModel->employee_late($dates[0], $division_id);

        $data = [
            'title'     => 'Employee Late',
            'date'      => $dates[0],
            'employee_late' => $employe_late
        ];
        return view('dashboard/late', $data);
    }

    public function absent()
    {
        $today = new Time('now');
        $dates = explode(' ', $today);
        $employee_absent = $this->DashboardModel->employee_absent($dates[0]);
        $data = [
            'title'     => 'Employee Absent',
            'employee_absent'   => $employee_absent,
            'date'      => $dates[0]
        ];

        return view('dashboard/absent', $data);
    }

    public function count_makan()
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $result = $this->CountFoodModel->getDashboardCountByStatus($date); // pakai method baru

        $counts = [];
        foreach ($result as $row) {
            $counts[strtoupper($row->status)] = (int) $row->count_status;
        }
        $data = [
            'title'     => 'Dashboard Count Makan',
            'date'      => $date,
            'counts' => $counts,
        ];

        return view('dashboard/count_makan', $data);
    }

    public function order_catering()
    {

        $today = date('Y-m-d');

        // Cari hari Senin minggu ini
        $start = date('Y-m-d', strtotime('monday this week', strtotime($today)));

        // Cari hari Minggu minggu ini
        $end = date('Y-m-d', strtotime('sunday this week', strtotime($today)));

        // Ambil data: total per status per tanggal
        $query = $this->CountFoodModel->select('date, status, COUNT(*) as total')
            ->where('date >=', $start)
            ->where('date <=', $end)
            ->groupBy('date, status')
            ->orderBy('date', 'ASC')
            ->get()
            ->getResult();

        // Siapkan struktur data chart
        $statusList = ['MAKAN', 'PUASA', 'DIET', 'TIDAK MAKAN', 'TIDAK PUASA'];
        $dateList = [];
        $dataSeries = [];

        // Inisialisasi struktur kosong per status
        foreach ($statusList as $status) {
            $dataSeries[$status] = [];
        }

        // Ambil tanggal unik (berurutan)
        $period = [];
        $startDate = strtotime($start);
        $endDate = strtotime($end);
        while ($startDate <= strtotime($end)) {
            $d = date('Y-m-d', $startDate);
            $period[] = $d;
            $startDate = strtotime('+1 day', $startDate);
        }

        // Siapkan semua status per tanggal default 0
        foreach ($statusList as $status) {
            foreach ($period as $date) {
                $dataSeries[$status][$date] = 0;
            }
        }

        // Isi dengan data dari query
        foreach ($query as $row) {
            $dataSeries[$row->status][$row->date] = (int) $row->total;
        }

        // Format untuk ApexCharts
        $series = [];
        foreach ($statusList as $status) {
            $series[] = [
                'name' => $status,
                'data' => array_values($dataSeries[$status])
            ];
        }

        $data = [
            'title' => 'Dashboard Report Order Catering',
            'date' => date('Y-m-d'),
            'categories' => array_map(fn($d) => date('d M', strtotime($d)), $period),
            'series' => $series,
        ];

        return view('dashboard/order_catering', $data);
    }


    // public function grafik_karyawan_old()
    // {
    //     $result = $this->DashboardModel->grafikEmployee();

    //     $dataChart = [];

    //     foreach ($result as $row) {
    //         $plant = str_replace('Plant', 'Pl.', $row['plant']);
    //         $label = $plant . ' - ' . $row['employee_group'];
    //         $value = (int)$row['total'];

    //         $dataChart[] = [
    //             'x' => $label,
    //             'y' => $value,
    //             'fillColor' => $value >= 100 ? '#FF4560' : '#008FFB'
    //         ];
    //     }

    //     $data = [
    //         'title' => 'Dashboard Grafik Karyawan',
    //         'data'  => json_encode($dataChart)
    //     ];

    //     return view('dashboard/grafik_karyawan', $data);
    // }

    function grafik_karyawan()
    {
        $year = date('Y');

        $dataGrafik = $this->DashboardModel->grafikKaryawanPerDivisiPerBulan($year);

        // Sinkronkan panjang data per series dengan jumlah kategori (12 bulan)
        foreach ($dataGrafik['series'] as &$s) {
            $s['data'] = array_slice($s['data'], -12); // ambil 12 data terakhir
        }

        return view('dashboard/grafik_karyawan', [
            'title' => "Grafik Karyawan per Divisi - $year",
            'series' => json_encode($dataGrafik['series']),
            'categories' => json_encode($dataGrafik['categories']),
            'year' => $year
        ]);
    }



    public function notifikasi()
    {
        $datetime = Time::parse('now');
        $newDate = $datetime->addMonths(1);
        $explode = explode(' ', $newDate);
        $date = $explode[0];
        $simexpired = $this->SimModel->dataExpired($date);
        $stnkexpired = $this->StnkModel->dataPajakExpired($date);
        $platexpired = $this->StnkModel->dataPlatExpired($date);

        $contract = $this->ContractModel->ContractExpired($date);
        $data = [
            'title'     => 'Dashboard Notifikasi',
            'simexpired' => $simexpired,
            'stnkexpired' => $stnkexpired,
            'platexpired' => $platexpired,
            'contract'      => $contract
        ];

        return view('dashboard/notifikasi', $data);
    }

    public function exportChartPdf()
    {
        $data = $this->request->getJSON();
        $chartImage = $data->chartImage ?? '';
        $chartImage = preg_replace('/^data:image\/\w+;base64,/', '', $chartImage);

        $html = '<h2>Absent Chart</h2>';
        $html .= '<img src="data:image/png;base64,' . $chartImage . '" width="100%">';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function absent_plant($shiftId, $plantId)
    {
        // $date = date('Y-m-d');
        $date = date('Y-m-d');
        $thistoday = date('d F Y'); // hasil: 21 January 2026
        $employee = $this->DashboardModel->getAbsentByShiftAndPlant($shiftId, $plantId, $date);
        $data = [
            'title'      => 'Absent Plant',
            'shift_id'   => $shiftId,
            'plant_id'   => $plantId,
            'date'       => $date,
            'thistoday'    => $thistoday,
            'employee'  => $employee,
            'plant'      => $this->DashboardModel->getPlant($plantId),
            'shift'      => $this->DashboardModel->getShift($shiftId),
        ];

        return view('dashboard/absent_plant', $data);
    }



    public function export_percentage($startDate, $endDate = null)
    {
        if (!$startDate) {
            return redirect()->back()->with('error', 'Date tidak valid');
        }

        // =========================
        // DEFAULT END DATE
        // =========================
        if (!$endDate) {
            $endDate = date('Y-m-t', strtotime($startDate));
            $startDate = date('Y-m-01', strtotime($startDate));
        }

        $year  = date('Y', strtotime($startDate));
        $month = date('m', strtotime($startDate));

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // =========================
        // PRELOAD PLANTS
        // =========================
        $plants = $this->PlantModel->findAll();

        // =========================
        // PRELOAD SHIFT (ONLY ONCE)
        // =========================
        $dayShiftRaw = $this->DashboardModel->getTotalShiftPerPlant($startDate, [1, 5]);
        $nightShiftRaw = $this->DashboardModel->getTotalShiftPerPlant($startDate, [2, 6]);

        $dayMap = [];
        foreach ($dayShiftRaw as $row) {
            $dayMap[$row->plant_id] = $row->total;
        }

        $nightMap = [];
        foreach ($nightShiftRaw as $row) {
            $nightMap[$row->plant_id] = $row->total;
        }

        // =========================
        // INIT DATA STORAGE
        // =========================
        $data = [];

        // =========================
        // LOOP PER HARI (EXCEL COLUMN)
        // =========================
        for ($d = 1; $d <= $daysInMonth; $d++) {

            $currentDate = date('Y-m-d', strtotime("$year-$month-$d"));

            // =====================
            // DAY SHIFT ATTENDANCE
            // =====================
            $dayStart = $currentDate . ' 05:00:00';
            $dayEnd   = $currentDate . ' 14:59:59';

            $attendanceDay = $this->DashboardModel->getAttendancePerPlant(
                $currentDate,
                $dayStart,
                $dayEnd,
                [1, 5]
            );

            $attendanceDayMap = [];
            foreach ($attendanceDay as $row) {
                $attendanceDayMap[$row->plant_id] = $row->total;
            }

            // =====================
            // NIGHT SHIFT (CROSS DAY)
            // =====================
            $nightDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));

            $nightStart = $nightDate . ' 15:00:00';
            $nightEnd   = $currentDate . ' 04:59:59';

            $attendanceNight = $this->DashboardModel->getAttendancePerPlant(
                $nightDate,
                $nightStart,
                $nightEnd,
                [2, 6]
            );

            $attendanceNightMap = [];
            foreach ($attendanceNight as $row) {
                $attendanceNightMap[$row->plant_id] = $row->total;
            }

            // =====================
            // BUILD DATA MATRIX
            // =====================
            foreach ($plants as $p) {

                $plantId = $p->id;

                // DAY SHIFT
                $totalDay = $dayMap[$plantId] ?? 0;
                $presentDay = $attendanceDayMap[$plantId] ?? 0;

                $percentDay = ($totalDay > 0)
                    ? round(($presentDay / $totalDay) * 100, 2)
                    : 0;

                $data[$plantId]['DayShift'][$currentDate] = $percentDay;

                // NIGHT SHIFT
                $totalNight = $nightMap[$plantId] ?? 0;
                $presentNight = $attendanceNightMap[$plantId] ?? 0;

                $percentNight = ($totalNight > 0)
                    ? round(($presentNight / $totalNight) * 100, 2)
                    : 0;

                $data[$plantId]['NightShift'][$currentDate] = $percentNight;
            }
        }

        // =========================
        // EXCEL
        // =========================
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $lastCol = Coordinate::stringFromColumnIndex(3 + $daysInMonth);

        $sheet->setCellValue('A1', 'Present Attendance Employee');
        $sheet->mergeCells('A1:C1');

        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->mergeCells("D1:{$lastCol}1");

        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'PLANT');
        $sheet->setCellValue('C2', 'SHIFT');

        $col = 'D';
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $sheet->setCellValue($col . '2', $d);
            $col++;
        }

        // =========================
        // FILL ROWS
        // =========================
        $row = 3;
        $no = 1;

        foreach ($plants as $p) {

            $startRow = $row;

            foreach (['DayShift', 'NightShift'] as $shift) {

                if ($shift === 'DayShift') {
                    $sheet->setCellValue("A$row", $no);
                    $sheet->setCellValue("B$row", $p->name);
                }

                $sheet->setCellValue("C$row", $shift);

                $col = 'D';

                for ($d = 1; $d <= $daysInMonth; $d++) {

                    $currentDate = date('Y-m-d', strtotime("$year-$month-$d"));

                    $value = $data[$p->id][$shift][$currentDate] ?? 0;

                    $sheet->setCellValue($col . $row, round($value, 1) . '%');

                    $col++;
                }

                $row++;
            }

            $sheet->mergeCells("A{$startRow}:A" . ($row - 1));
            $sheet->mergeCells("B{$startRow}:B" . ($row - 1));

            $no++;
        }

        // =========================
        // STYLE
        // =========================
        $lastRow = $row - 1;

        $sheet->getStyle("A1:{$lastCol}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle("A1:{$lastCol}{$lastRow}")
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // =========================
        // OUTPUT
        // =========================
        $filename = "percentage_attendance_$year-$month.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        setcookie("downloadDone", "true", time() + 60, "/");

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
