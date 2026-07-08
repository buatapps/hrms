<?php

namespace App\Models;

use CodeIgniter\Model;
use DatePeriod;
use DateTime;
use DateInterval;

class DashboardModel extends Model
{
    //==================== function getEmployeeSummary ======================
    public function countEmployee(
        $employee_status_id = null,
        $gender_id = null,
        $company_id = null,
        $exclude_division_id = null,
        $division_id = null
    ) {
        $builder = $this->db->table('employee');

        if (is_array($employee_status_id)) {
            $builder->whereIn('employee_status_id', $employee_status_id);
        } elseif ($employee_status_id != null) {
            $builder->where('employee_status_id', $employee_status_id);
        }

        if ($gender_id != null) {
            $builder->where('gender_id', $gender_id);
        }

        if ($company_id != null) {
            $builder->where('company_id', $company_id);
        }

        if ($exclude_division_id != null) {
            $builder->where('division_id !=', $exclude_division_id);
        }

        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }

        return $builder->countAllResults();
    }

    //=================== function dashboard_employee ==================
    public function getTotalPerJabatan()
    {
        $builder = $this->db->table('data_employee');

        $builder->select('position, COUNT(id) AS total');
        $builder->groupBy('position_id, position');
        $builder->orderBy('nomor_urut', 'ASC');

        return $builder->get()->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function getTotalEmployeePerDivisionUpToMonth(int $month, int $year)
    {
        $builder = $this->db->table('data_employee');

        $builder->select('division, COUNT(id) AS total');

        // Ambil semua employee yang masuk <= bulan & tahun yang ditentukan
        $builder->where("(YEAR(date_of_entry) < $year OR (YEAR(date_of_entry) = $year AND MONTH(date_of_entry) <= $month))");

        // Hanya employee aktif
        $builder->whereIn('employee_status_id', [1, 2]);

        $builder->groupBy('division');
        $builder->orderBy('division');

        return $builder->get()->getResultArray();
    }

    //=================== function late ==================
    public function employee_late($date, $division_id)
    {
        $builder = $this->db->table('employee_late');
        $builder->select('employee_late.employee_pin, employee.name, division.name as division, position.name as position, plant.name as plant, employee_group.name as employee_group, shift_name, entry_time, late_hour');
        $builder->join('employee', 'employee.employee_pin = employee_late.employee_pin');
        $builder->join('division', 'division.id = employee.division_id');
        $builder->join('position', 'position.id = employee.position_id');
        $builder->join('plant', 'plant.id = employee.plant_id');
        $builder->join('employee_group', 'employee_group.id = employee.employee_group_id');
        $builder->join('employee_schedule', 'employee_schedule.employee_pin = employee_late.employee_pin');
        $builder->join('working_days', 'working_days.id = employee_schedule.working_days_id');
        $builder->where('employee_late.date', $date);
        $builder->where('employee_schedule.date', $date);
        if (!empty($division_id)) {
            $builder->where('employee.division_id', $division_id);
        }
        $query = $builder->get();
        return $query->getResultObject();
    }

    //=================== function absent ==================
    public function employee_absent($date)
    {
        $builder = $this->db->table('absent');
        $builder->select('data_employee.name as name, division, position, plant, employee_group, absent_type.name as absent_type, information');
        $builder->join('data_employee', 'data_employee.id = absent.employee_id');
        $builder->join('absent_type', 'absent_type.id = absent.absent_type_id');
        $builder->where('absent.date', $date);
        $builder->orderBy('plant ASC', 'employee_group ASC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    //=================== function grafik_karyawan ==================
    public function grafikKaryawanPerDivisiPerBulan($year)
    {
        // Siapkan label bulan dan tanggal akhir
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $endDate = date("Y-m-t", strtotime("$year-$i-01"));
            $monthName = strftime('%B', strtotime("$year-$i-01"));
            $months[ucfirst(strtolower($monthName))] = $endDate;
        }

        // Ambil semua nama divisi (supaya semua divisi dijamin ada setiap bulan)
        $divisions = $this->db->table('division')->select('name')->get()->getResultArray();
        $divisionNames = array_column($divisions, 'name');

        // Inisialisasi hasil
        $result = [];
        foreach ($divisionNames as $division) {
            $result[$division] = [
                'name' => $division,
                'data' => []
            ];
        }

        // Simpan nilai sebelumnya untuk carry forward
        $prevValues = array_fill_keys($divisionNames, 0);

        foreach ($months as $label => $endDate) {
            $builder = $this->db->table('employee e');
            $builder->select('d.name AS division, COUNT(*) as total');
            $builder->join('division d', 'd.id = e.division_id');
            $builder->where('e.date_of_entry <=', $endDate);
            $builder->groupStart()
                ->where('e.resign_date IS NULL')
                ->orWhere('e.resign_date >', $endDate)
                ->groupEnd();
            $builder->groupBy('d.name');

            $query = $builder->get()->getResultArray();

            // Isi hasil dari query dan simpan sebagai previous
            $currentValues = $prevValues; // awalnya pakai yang bulan sebelumnya

            foreach ($query as $row) {
                $division = $row['division'];
                $total = (int)$row['total'];
                $currentValues[$division] = $total; // overwrite kalau ada data bulan ini
            }

            // Masukkan ke result & update prevValues
            foreach ($divisionNames as $division) {
                $result[$division]['data'][] = $currentValues[$division];
                $prevValues[$division] = $currentValues[$division];
            }
        }

        return [
            'series' => array_values($result),
            'categories' => array_keys($months)
        ];
    }

    //=================== function getDivisionChart ==================
    public function employeeByDivision()
    {
        return $this->db->table('employee')
            ->select("COALESCE(division.name, 'No Division') as name, COUNT(employee.id) as total")
            ->join('division', 'division.id = employee.division_id', 'left')
            ->whereIn('employee_status_id', [1, 2]) // active
            ->groupBy('division.name')
            ->orderBy('total DESC')
            ->get()
            ->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function employeeJoinThisMonthByDivision()
    {
        // Ambil awal & akhir bulan ini
        $startDate = date('Y-m-01');
        $endDate   = date('Y-m-t');

        $builder = $this->db->table('employee');
        $builder->select('division.name, COUNT(employee.id) as total');
        $builder->join('division', 'division.id = employee.division_id', 'left');

        $builder->where('employee.date_of_entry >=', $startDate);
        $builder->where('employee.date_of_entry <=', $endDate);

        // hanya karyawan aktif
        $builder->whereIn('employee.employee_status_id', [1, 2]);

        // exclude japan
        $builder->where('employee.division_id !=', 12);

        // safety
        $builder->where('employee.division_id IS NOT NULL', null, false);

        $builder->groupBy('employee.division_id');
        $builder->orderBy('total', 'DESC');

        return $builder->get()->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function employeeResignByDivision($month, $year)
    {
        return $this->db->table('employee')
            ->select('division.name, COUNT(employee.id) as total')
            ->join('division', 'division.id = employee.division_id', 'left')
            ->where('employee.resign_date IS NOT NULL')
            ->where('MONTH(employee.resign_date)', $month)
            ->where('YEAR(employee.resign_date)', $year)
            ->groupBy('employee.division_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function totalEmployeeResign($month, $year)
    {
        return $this->db->table('employee')
            ->where('resign_date IS NOT NULL')
            ->where('MONTH(resign_date)', $month)
            ->where('YEAR(resign_date)', $year)
            ->countAllResults();
    }

    //=================== function dashboard_employee ==================
    public function employeeContractEndByDivision($month, $year)
    {
        return $this->db->table('contract')
            ->select('division.name, COUNT(contract.id) as total')
            ->join('employee', 'employee.id = contract.employee_id', 'left')
            ->join('division', 'division.id = employee.division_id', 'left')
            ->where('contract.end_date IS NOT NULL')
            ->where('MONTH(contract.end_date)', $month)
            ->where('YEAR(contract.end_date)', $year)
            ->groupBy('employee.division_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function totalEmployeeContractEnd($month, $year)
    {
        return $this->db->table('contract')
            ->join('employee', 'employee.id = contract.employee_id', 'left')
            ->where('contract.end_date IS NOT NULL')
            ->where('MONTH(contract.end_date)', $month)
            ->where('YEAR(contract.end_date)', $year)
            ->countAllResults();
    }

    //=================== function dashboard_employee ==================
    public function employeeLateTodayByDivision($today)
    {
        return $this->db->table('employee_late')
            ->select('
            division.id as division_id,
            division.name as division_name,
            COUNT(employee_late.employee_pin) as total_employee
        ')
            ->join('employee', 'employee.employee_pin = employee_late.employee_pin', 'left')
            ->join('division', 'division.id = employee.division_id', 'left')
            ->where('employee_late.date', $today)
            ->groupBy('division.id')
            ->orderBy('total_employee', 'DESC')
            ->get()
            ->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function totalHadirToday($today)
    {
        return $this->db->table('attendance')
            ->select('COUNT(DISTINCT pin) AS total')
            ->where('date', $today)
            ->where('deleted_at', null)
            ->get()
            ->getRow()
            ->total ?? 0;
    }

    //=================== function dashboard_employee ==================
    public function totalAbsentByTypeToday($today)
    {
        return $this->db->table('absent a')
            ->select('at.name as name, at.id as absent_type_id, COUNT(*) AS total')
            ->join('absent_type at', 'at.id = a.absent_type_id', 'left')
            ->where('a.date', $today)
            ->where('a.deleted_at', null)
            ->groupBy('a.absent_type_id')
            ->orderBy('at.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    //=================== function dashboard_employee ==================
    public function totalAbsentPerTypeMonth($year, $month)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $absentTypes = $this->db->table('absent_type')->get()->getResultArray();

        // Type yang tetap berdiri sendiri
        $mainTypes = [
            'Alpa',
            'Sakit',
            'H-Work From Home',
            'I-Ijin',
            'Cuti'
        ];

        $series = [];
        $alphaTanpaKet = array_fill(0, $daysInMonth, 0);

        foreach ($absentTypes as $type) {

            $data = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {

                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

                $count = $this->db->table('absent a')
                    ->select('COUNT(*) as total')
                    ->where('a.date', $date)
                    ->where('a.absent_type_id', $type['id'])
                    ->where('a.absent_type_id !=', '7')
                    ->where('a.deleted_at', null)
                    ->get()
                    ->getRow()
                    ->total ?? 0;

                if (in_array($type['name'], $mainTypes)) {
                    $data[] = (int)$count;
                } else {
                    $alphaTanpaKet[$day - 1] += (int)$count;
                }
            }

            if (in_array($type['name'], $mainTypes)) {
                $series[] = [
                    'name' => $type['name'],
                    'data' => $data
                ];
            }
        }

        // Tambahkan gabungan di akhir
        $series[] = [
            'name' => 'Alpha - Tanpa Keterangan',
            'data' => $alphaTanpaKet
        ];

        return $series;
    }

    //================= function absent_plant =====================
    public function getAbsentByShiftAndPlant($shiftId, $plantId, $date)
    {
        return $this->db->table('employee_schedule es')
            ->select('e.id as id, e.name as name, e.employee_id as employee_id, e.employee_pin as employee_pin, at.name as absent_type_name, ab.information, eg.name as employee_group, p.name as plant, d.name as division')
            ->join('working_days wd', 'wd.id = es.working_days_id')
            ->join('employee e', 'e.id = es.employee_id')

            // attendance (cari yang tidak absen)
            ->join('attendance a', 'a.pin = e.employee_pin AND a.date = es.date', 'left')

            // absent (LEFT JOIN supaya kalau tidak ada tetap tampil)
            ->join(
                'absent ab',
                'ab.employee_id = e.id AND ab.date = es.date AND ab.absent_type_id != 7',
                'left'
            )

            ->join('absent_type at', 'at.id = ab.absent_type_id', 'left')
            ->join('employee_group eg', 'eg.id = e.employee_group_id')
            ->join('plant p', 'p.id = e.plant_id')
            ->join('division d', 'd.id = e.division_id')

            ->where('es.date', $date)
            ->where('wd.shift_id', $shiftId)
            ->where('e.plant_id', $plantId)
            ->whereIn('e.employee_status_id', [1, 2])

            // ini tetap filter tidak attendance
            ->where('a.pin IS NULL', null, false)

            ->get()
            ->getResult();
    }

    //================= function absen_employee ===================
    public function getScheduledAbsent($startDate, $endDate, $shiftIds, $type = 'day', $divisionId = null)
    {
        $isNight = ($type === 'night');

        // =========================
        // SHIFT RULE NORMALIZATION
        // =========================
        if ($isNight) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        $startTime = $isNight
            ? $startDate . ' 15:00:00'
            : $startDate . ' 05:00:00';

        $endTime = $isNight
            ? date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 04:59:59'
            : $endDate . ' 14:59:59';

        // =========================
        // SCHEDULE SUBQUERY (WITH DIVISION FILTER INSIDE)
        // =========================
        $scheduleSubBuilder = $this->db->table('employee_schedule es')
            ->select('es.employee_id, es.date')
            ->join('working_days wd', 'wd.id = es.working_days_id')
            ->join('employee e', 'e.id = es.employee_id')
            ->where('es.date >=', $startDate)
            ->where('es.date <=', $endDate)
            ->whereIn('wd.shift_id', $shiftIds);

        // 🔥 DIVISION FILTER (IMPORTANT FIX)
        if (!empty($divisionId)) {
            $scheduleSubBuilder->where('e.division_id', $divisionId);
        }

        $scheduleSub = $scheduleSubBuilder->getCompiledSelect();

        // =========================
        // ATTENDANCE SUBQUERY (PER DAY)
        // =========================
        $attendanceSub = $this->db->table('attendance')
            ->select('pin, DATE(datetime) as att_date')
            ->where('datetime >=', $startTime)
            ->where('datetime <=', $endTime)
            ->groupBy(['pin', 'DATE(datetime)'])
            ->getCompiledSelect();

        // =========================
        // MAIN QUERY (EVENT BASED ABSENT)
        // =========================
        $builder = $this->db->table("($scheduleSub) s")
            ->select('
            e.id,
            e.employee_id,
            e.name,
            s.date as absent_date,
            d.name as division,
            p.id as plant_id,
            p.name as plant,
            eg.name as employee_group
        ')
            ->join('employee e', 'e.id = s.employee_id')
            ->join('division d', 'd.id = e.division_id')
            ->join('plant p', 'p.id = e.plant_id')
            ->join('employee_group eg', 'eg.id = e.employee_group_id')

            // attendance match per day
            ->join("($attendanceSub) a", '
            a.pin = e.employee_pin 
            AND a.att_date = s.date
        ', 'left')

            // ABSENT ONLY
            ->where('a.pin IS NULL')

            //KONTRAK - PERMANENT
            ->whereIn('e.employee_status_id', [1, 2]);

        return $builder
            ->orderBy('s.date', 'ASC')
            ->orderBy('d.name', 'ASC')
            ->orderBy('e.name', 'ASC')
            ->get()
            ->getResult();
    }

    // public function getScheduledAbsent($startDate, $endDate, $shiftIds, $type = 'day')
    // {
    //     $isNight = ($type === 'night');

    //     // =========================
    //     // SHIFT RULE
    //     // =========================
    //     if ($isNight) {
    //         $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
    //         $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
    //     }

    //     $startTime = $isNight
    //         ? $startDate . ' 15:00:00'
    //         : $startDate . ' 05:00:00';

    //     $endTime = $isNight
    //         ? date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 04:59:59'
    //         : $endDate . ' 14:59:59';

    //     // =========================
    //     // SCHEDULE SUBQUERY (FIXED)
    //     // =========================
    //     $scheduleSub = $this->db->table('employee_schedule es')
    //         ->select('employee_id')
    //         ->distinct()
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->getCompiledSelect();

    //     // =========================
    //     // ATTENDANCE SUBQUERY
    //     // =========================
    //     $attendanceSub = $this->db->table('attendance')
    //         ->select('pin')
    //         ->where('datetime >=', $startTime)
    //         ->where('datetime <=', $endTime)
    //         ->groupBy('pin')
    //         ->getCompiledSelect();

    //     // =========================
    //     // MAIN QUERY
    //     // =========================
    //     return $this->db->table("($scheduleSub) s")
    //         ->select('
    //         e.id,
    //         e.employee_id,
    //         e.name,
    //         d.name as division,
    //         p.id as plant_id,
    //         p.name as plant,
    //         eg.name as employee_group
    //     ')
    //         ->join('employee e', 'e.id = s.employee_id')
    //         ->join('division d', 'd.id = e.division_id')
    //         ->join('plant p', 'p.id = e.plant_id')
    //         ->join('employee_group eg', 'eg.id = e.employee_group_id')

    //         ->join("($attendanceSub) a", 'a.pin = e.employee_pin', 'left')

    //         ->where('a.pin IS NULL')

    //         ->orderBy('e.name', 'ASC')
    //         ->get()
    //         ->getResult();
    // }

    //================= function absent_plant =====================
    public function getPlant($plantId)
    {
        return $this->db->table('plant')
            ->select('id, name')
            ->where('id', $plantId)
            ->get()
            ->getRow();
    }

    //================= function absent_plant =====================
    public function getShift($shiftId)
    {
        return $this->db->table('shift')
            ->select('id, name')
            ->where('id', $shiftId)
            ->get()
            ->getRow();
    }

    //================= function getAttendancePercentage =====================
    public function getTotalShiftByRange($startDate, $endDate, $shiftIds, $divisionId = null)
    {
        $isNightShift = array_intersect($shiftIds, [2, 6]);

        if ($isNightShift) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        $builder = $this->db->table('employee_schedule es');

        $builder->select('COUNT(DISTINCT CONCAT(es.employee_id, "-", es.date)) as total');

        $builder->join('employee e', 'e.id = es.employee_id');

        $builder->join('working_days wd', 'wd.id = es.working_days_id');

        $builder->whereIn('e.employee_status_id', [1, 2]);

        $builder->whereIn('wd.shift_id', $shiftIds);

        $builder->where('es.date >=', $startDate);
        $builder->where('es.date <=', $endDate);

        // =========================
        // DIVISION FILTER
        // =========================
        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        return (int) $builder->get()->getRow()->total;
    }
    // public function getTotalShiftByRange($startDate, $endDate, $shiftIds, $divisionId = null)
    // {
    //     // =========================
    //     // DETECT SHIFT TYPE
    //     // =========================
    //     $isNightShift = array_intersect($shiftIds, [2, 6]);

    //     // =========================
    //     // SHIFT DATE NORMALIZATION
    //     // =========================
    //     if ($isNightShift) {
    //         $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
    //         $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
    //     }

    //     // =========================
    //     // QUERY
    //     // =========================
    //     $builder = $this->db->table('employee_schedule es');

    //     $builder->join('employee e', 'e.id = es.employee_id');

    //     $builder->whereIn('e.employee_status_id', [1, 2]);

    //     $builder->whereIn('es.working_days_id', function ($subQuery) use ($shiftIds) {
    //         $subQuery->select('id')
    //             ->from('working_days')
    //             ->whereIn('shift_id', $shiftIds);
    //     });

    //     $builder->where('es.date >=', $startDate);
    //     $builder->where('es.date <=', $endDate);

    //     // =========================
    //     // GLOBAL FILTER (DIVISION)
    //     // =========================
    //     if (!empty($divisionId)) {
    //         $builder->where('e.division_id', $divisionId);
    //     }

    //     return $builder->countAllResults();
    // }

    //================= function getAttendancePercentage =====================
    // public function getTotalShiftByRange($startDate, $endDate, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->countAllResults();
    // }

    //================= function getAttendancePercentage =====================
    public function getNonSchedule($startDate, $endDate, $shiftIds, $type = 'day')
    {
        $isNight = ($type === 'night');

        if ($isNight) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        $startTime = $isNight
            ? $startDate . ' 15:00:00'
            : $startDate . ' 05:00:00';

        $endTime = $isNight
            ? date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 04:59:59'
            : $endDate . ' 14:59:59';

        // attendance subquery
        $subquery = $this->db->table('attendance')
            ->select('pin')
            ->where('datetime >=', $startTime)
            ->where('datetime <=', $endTime)
            ->groupBy('pin')
            ->getCompiledSelect();

        return $this->db->table("($subquery) a")
            ->select('e.id, e.name, e.employee_id, e.plant_id')
            ->join('employee e', 'e.employee_pin = a.pin')

            // 🔥 ini kunci: tidak punya schedule di shift itu
            ->join(
                'employee_schedule es',
                "es.employee_id = e.id 
             AND es.date BETWEEN '$startDate' AND '$endDate'",
                'left'
            )
            ->join('working_days wd', 'wd.id = es.working_days_id', 'left')

            ->whereIn('e.employee_status_id', [1, 2])
            ->whereIn('wd.shift_id', $shiftIds)

            // 🔥 NON SCHEDULE FILTER
            ->groupStart()
            ->where('es.id IS NULL')
            ->groupEnd()

            ->groupBy('e.id')
            ->get()
            ->getResult();
    }

    //================= function getAttendancePercentage =====================
    // public function getEmployeeWithoutScheduleRange($startDate, $endDate)
    // {
    //     return $this->db->table('employee e')
    //         ->join(
    //             'employee_schedule es',
    //             'es.employee_id = e.id 
    //          AND es.date >= "' . $startDate . '"
    //          AND es.date <= "' . $endDate . '"',
    //             'left'
    //         )
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->where('es.id IS NULL', null, false);
    // }

    //================= function getAttendancePercentage =====================
    public function getTotalShiftPerPlantRange($startDate, $endDate, $shiftIds, $divisionId = null)
    {
        $isNight = array_intersect($shiftIds, [2, 6]);

        if ($isNight) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        $builder = $this->db->table('employee_schedule es');

        $builder->select('
        e.plant_id,
        COUNT(DISTINCT CONCAT(es.employee_id, "-", es.date)) as total
    ');

        $builder->join('employee e', 'e.id = es.employee_id');

        $builder->join('working_days wd', 'wd.id = es.working_days_id');

        $builder->whereIn('e.employee_status_id', [1, 2]);

        $builder->whereIn('wd.shift_id', $shiftIds);

        $builder->where('es.date >=', $startDate);
        $builder->where('es.date <=', $endDate);

        // =========================
        // DIVISION FILTER
        // =========================
        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        $builder->groupBy('e.plant_id');

        return $builder->get()->getResult();
    }
    //================= function getAttendancePercentage =====================
    // public function getTotalShiftPerPlantRange($startDate, $endDate, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('e.plant_id, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy('e.plant_id')
    //         ->get()
    //         ->getResult();
    // }

    //================= function getAttendancePercentage =====================
    public function getAttendancePerPlantRange($startDate, $endDate, $shiftIds, $divisionId = null)
    {
        $isNight = array_intersect($shiftIds, [2, 6]);
        $isDay   = array_intersect($shiftIds, [1, 5]);

        $plants = [];

        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        foreach ($period as $date) {

            $currentDate = $date->format('Y-m-d');

            // =====================================
            // DAY SHIFT
            // 05:00 -> 14:59
            // =====================================
            if ($isDay) {

                $dayStart = $currentDate . ' 05:00:00';
                $dayEnd   = $currentDate . ' 14:59:59';

                $dayData = $this->getAttendanceRaw(
                    $dayStart,
                    $dayEnd,
                    $shiftIds,
                    $divisionId
                );

                foreach ($dayData as $row) {

                    if (!isset($plants[$row->plant_id])) {
                        $plants[$row->plant_id] = 0;
                    }

                    $plants[$row->plant_id] += $row->total;
                }
            }

            // =====================================
            // NIGHT SHIFT
            // yesterday 15:00 -> today 05:00
            // =====================================
            if ($isNight) {

                $nightStart = date(
                    'Y-m-d',
                    strtotime($currentDate . ' -1 day')
                ) . ' 15:00:00';

                $nightEnd = $currentDate . ' 05:00:00';

                $nightData = $this->getAttendanceRaw(
                    $nightStart,
                    $nightEnd,
                    $shiftIds,
                    $divisionId
                );

                foreach ($nightData as $row) {

                    if (!isset($plants[$row->plant_id])) {
                        $plants[$row->plant_id] = 0;
                    }

                    $plants[$row->plant_id] += $row->total;
                }
            }
        }

        // =========================
        // FORMAT RESULT
        // =========================
        $result = [];

        foreach ($plants as $plantId => $total) {

            $result[] = (object)[
                'plant_id' => $plantId,
                'total'    => $total
            ];
        }

        return $result;
    }

    private function getAttendanceRaw(
        $startTime,
        $endTime,
        $shiftIds,
        $divisionId = null
    ) {

        // =====================================
        // IMPORTANT:
        // Attendance before 05:00
        // belongs to previous date
        // for NIGHT SHIFT
        // =====================================

        $attDateCase = "
        CASE
            WHEN TIME(datetime) < '05:00:00'
                THEN DATE(DATE_SUB(datetime, INTERVAL 1 DAY))
            ELSE DATE(datetime)
        END
    ";

        $sub = $this->db->table('attendance')
            ->select("
            pin,
            $attDateCase as att_date
        ")
            ->where('datetime >=', $startTime)
            ->where('datetime <=', $endTime)
            ->groupBy([
                'pin',
                $attDateCase
            ])
            ->getCompiledSelect();

        $builder = $this->db->table("($sub) a");

        $builder->select("
        e.plant_id,
        COUNT(DISTINCT CONCAT(e.id, '-', a.att_date)) as total
    ");

        $builder->join(
            'employee e',
            'e.employee_pin = a.pin'
        );

        $builder->join(
            'employee_schedule es',
            'es.employee_id = e.id
        AND es.date = a.att_date'
        );

        $builder->join(
            'working_days wd',
            'wd.id = es.working_days_id'
        );

        $builder->whereIn('e.employee_status_id', [1, 2]);

        $builder->whereIn('wd.shift_id', $shiftIds);

        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        $builder->groupBy('e.plant_id');

        return $builder->get()->getResult();
    }
    // public function getAttendancePerPlantRange($startDate, $endDate, $shiftIds, $divisionId = null)
    // {
    //     $isNight = array_intersect($shiftIds, [2, 6]);

    //     if ($isNight) {

    //         // anchor ke endDate (bukan startDate)
    //         $shiftEndDate = $endDate;

    //         $startTime = date('Y-m-d', strtotime($shiftEndDate . ' -1 day')) . ' 15:00:00';
    //         $endTime   = $shiftEndDate . ' 05:00:00';
    //     } else {
    //         $startTime = $startDate . ' 05:00:00';
    //         $endTime   = $endDate . ' 14:59:59';
    //     }

    //     // =========================
    //     // ATTENDANCE PER DAY
    //     // =========================
    //     $attendanceSub = $this->db->table('attendance')
    //         ->select("
    //         pin,
    //         DATE(datetime) as att_date
    //     ")
    //         ->where('datetime >=', $startTime)
    //         ->where('datetime <=', $endTime)
    //         ->groupBy(['pin', 'DATE(datetime)'])
    //         ->getCompiledSelect();

    //     // =========================
    //     // MAIN QUERY
    //     // =========================
    //     $builder = $this->db->table("($attendanceSub) a");

    //     $builder->select("
    //     e.plant_id,
    //     COUNT(DISTINCT CONCAT(e.id, '-', a.att_date)) as total
    // ");

    //     $builder->join('employee e', 'e.employee_pin = a.pin');

    //     $builder->join(
    //         'employee_schedule es',
    //         "es.employee_id = e.id
    //     AND es.date = a.att_date",
    //         'inner'
    //     );

    //     $builder->join('working_days wd', 'wd.id = es.working_days_id');

    //     $builder->whereIn('e.employee_status_id', [1, 2]);

    //     $builder->whereIn('wd.shift_id', $shiftIds);

    //     if (!empty($divisionId)) {
    //         $builder->where('e.division_id', $divisionId);
    //     }

    //     $builder->groupBy('e.plant_id');

    //     return $builder->get()->getResult();
    // }

    //================= function getAttendancePercentage =====================
    // public function getAttendancePerPlantRange($startDate, $endDate, $type = 'day')
    // {
    //     $shiftIds = ($type === 'day') ? [1, 5] : [2, 6];

    //     // =====================================================
    //     // DAY SHIFT WINDOW (NORMAL)
    //     // =====================================================
    //     if ($type === 'day') {

    //         $subquery = $this->db->table('attendance')
    //             ->select('pin, MIN(datetime) as first_time')
    //             ->where('datetime >=', $startDate . ' 05:00:00')
    //             ->where('datetime <=', $endDate . ' 14:59:59')
    //             ->groupBy('pin')
    //             ->getCompiledSelect();
    //     }

    //     // =====================================================
    //     // NIGHT SHIFT WINDOW (FIXED CROSS DAY)
    //     // =====================================================
    //     else {

    //         $subquery = $this->db->table('attendance')
    //             ->select('pin, MIN(datetime) as first_time')
    //             ->where("
    //             (
    //                 (TIME(datetime) >= '15:00:00' AND DATE(datetime) BETWEEN '$startDate' AND '$endDate')
    //                 OR
    //                 (TIME(datetime) <= '04:59:59' AND DATE(datetime) BETWEEN DATE_SUB('$startDate', INTERVAL 1 DAY) AND DATE_SUB('$endDate', INTERVAL 1 DAY))
    //             )
    //         ", null, false)
    //             ->groupBy('pin')
    //             ->getCompiledSelect();
    //     }

    //     // =========================
    //     // MAIN QUERY
    //     // =========================
    //     $builder = $this->db->table("($subquery) as a")
    //         ->select('e.plant_id, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.employee_pin = a.pin')
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->join(
    //             'employee_schedule es',
    //             "es.employee_id = e.id AND es.date BETWEEN '$startDate' AND '$endDate'",
    //             'left'
    //         )
    //         ->join('working_days wd', 'wd.id = es.working_days_id', 'left');

    //     // SHIFT FILTER
    //     $builder->groupStart()
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->orWhere('es.id IS NULL')
    //         ->groupEnd();

    //     return $builder
    //         ->groupBy('e.plant_id')
    //         ->get()
    //         ->getResult();
    // }


    //================= function getAttendancePercentage =====================
    // public function getTotalShiftByDate($today, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date', $today)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->countAllResults();
    // }

    //================= function getAttendancePercentage =====================
    // public function getEmployeeWithoutScheduleToday($today)
    // {
    //     return $this->db->table('employee e')
    //         ->join(
    //             'employee_schedule es',
    //             'es.employee_id = e.id AND es.date = "' . $today . '"',
    //             'left'
    //         )
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->where('es.id IS NULL', null, false);
    // }

    //================= function getAttendancePercentage =====================
    // public function getTotalShiftPerPlant($today, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('e.plant_id, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date', $today)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy('e.plant_id')
    //         ->get()
    //         ->getResult();
    // }


    //================= function getAttendancePercentage =====================
    // public function getAttendancePerPlant($today, $startDateTime, $endDateTime, $shiftIds)
    // {
    //     $subquery = $this->db->table('attendance')
    //         ->select('pin, MIN(datetime) as first_time')
    //         ->where('datetime >=', $startDateTime)
    //         ->where('datetime <=', $endDateTime)
    //         ->groupBy('pin')
    //         ->getCompiledSelect();

    //     return $this->db->table("($subquery) as a")
    //         ->select('e.plant_id, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.employee_pin = a.pin')

    //         // 🔥 LEFT JOIN supaya lembur tetap ikut
    //         ->join(
    //             'employee_schedule es',
    //             "es.employee_id = e.id AND es.date = '$today'",
    //             'left'
    //         )

    //         ->join(
    //             'working_days wd',
    //             'wd.id = es.working_days_id',
    //             'left'
    //         )

    //         ->whereIn('e.employee_status_id', [1, 2])

    //         // 🔥 Ini penting:
    //         ->groupStart()
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->orWhere('es.id IS NULL') // kalau tidak punya schedule = lembur
    //         ->groupEnd()

    //         ->groupBy('e.plant_id')
    //         ->get()
    //         ->getResult();
    // }

    //================= function percentage attendance per department ====================
    public function getTotalShiftPerDepartmentRange($startDate, $endDate, $shiftIds, $divisionId = null)
    {
        // =========================
        // DETECT NIGHTSHIFT
        // =========================
        $isNight = array_intersect($shiftIds, [2, 6]);

        if ($isNight) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        // =========================
        // QUERY
        // =========================
        $builder = $this->db->table('employee_schedule es');

        $builder->select('
        e.plant_id,
        e.division_id,
        d.name as division_name,
        COUNT(DISTINCT e.id) as total
    ');

        $builder->join('employee e', 'e.id = es.employee_id');
        $builder->join('division d', 'd.id = e.division_id');
        $builder->join('working_days wd', 'wd.id = es.working_days_id');

        // =========================
        // FILTER
        // =========================
        $builder->whereIn('e.employee_status_id', [1, 2]);
        $builder->whereIn('wd.shift_id', $shiftIds);

        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        // =========================
        // DATE RANGE
        // =========================
        $builder->where('es.date >=', $startDate);
        $builder->where('es.date <=', $endDate);

        // =========================
        // GROUPING
        // =========================
        $builder->groupBy('e.plant_id');
        $builder->groupBy('e.division_id');
        $builder->groupBy('d.name');

        return $builder->get()->getResult();
    }

    // public function getTotalShiftPerDepartmentRange($startDate, $endDate, $shiftIds, $divisionId = null)
    // {
    //     // =========================
    //     // DETECT NIGHTSHIFT
    //     // =========================
    //     $isNight = array_intersect($shiftIds, [2, 6]);

    //     if ($isNight) {
    //         $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
    //         $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
    //     }

    //     // =========================
    //     // QUERY
    //     // =========================
    //     $builder = $this->db->table('employee_schedule es');

    //     $builder->select('
    //     e.plant_id,
    //     e.division_id,
    //     d.name as division_name,
    //     COUNT(DISTINCT es.employee_id) as total
    // ');

    //     $builder->join('employee e', 'e.id = es.employee_id');
    //     $builder->join('division d', 'd.id = e.division_id');
    //     $builder->join('working_days wd', 'wd.id = es.working_days_id');

    //     // =========================
    //     // FILTER
    //     // =========================
    //     $builder->whereIn('e.employee_status_id', [1, 2]);
    //     $builder->whereIn('wd.shift_id', $shiftIds);

    //     // 🔥 GLOBAL FILTER: DIVISION
    //     if (!empty($divisionId)) {
    //         $builder->where('e.division_id', $divisionId);
    //     }

    //     // =========================
    //     // DATE RANGE (SHIFT RULE ALREADY HANDLED)
    //     // =========================
    //     $builder->where('es.date >=', $startDate);
    //     $builder->where('es.date <=', $endDate);

    //     // =========================
    //     // GROUPING
    //     // =========================
    //     $builder->groupBy('e.plant_id');
    //     $builder->groupBy('e.division_id');

    //     return $builder->get()->getResult();
    // }

    //================= function percentage attendance per department ====================

    public function getAttendancePerDepartmentRange($startDate, $endDate, $shiftIds, $divisionId = null)
    {
        // =========================
        // SHIFT RULE DETECTION
        // =========================
        $isNight = array_intersect($shiftIds, [2, 6]);

        // =========================
        // NORMALIZE SHIFT DATE
        // =========================
        if ($isNight) {
            $startDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
            $endDate   = date('Y-m-d', strtotime($endDate . ' -1 day'));
        }

        // =========================
        // ATTENDANCE WINDOW
        // =========================
        $startTime = $isNight
            ? $startDate . ' 15:00:00'
            : $startDate . ' 05:00:00';

        $endTime = $isNight
            ? date('Y-m-d', strtotime($endDate . ' +1 day')) . ' 04:59:59'
            : $endDate . ' 14:59:59';

        // =========================
        // SUBQUERY ATTENDANCE
        // =========================
        $subquery = $this->db->table('attendance')
            ->select('pin, MIN(datetime) as first_time')
            ->where('datetime >=', $startTime)
            ->where('datetime <=', $endTime)
            ->groupBy('pin')
            ->getCompiledSelect();

        // =========================
        // MAIN QUERY
        // =========================
        $builder = $this->db->table("($subquery) as a");

        $builder->select('
        e.plant_id,
        e.division_id,
        d.name as division_name,
        COUNT(DISTINCT e.id) as total
    ');

        $builder->join('employee e', 'e.employee_pin = a.pin');

        // 🔥 DIVISION JOIN
        $builder->join('division d', 'd.id = e.division_id', 'left');

        // 🔥 ACTIVE EMPLOYEE ONLY
        $builder->whereIn('e.employee_status_id', [1, 2]);

        // 🔥 GLOBAL FILTER: DIVISION
        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        // 🔥 SCHEDULE MATCH
        $builder->join(
            'employee_schedule es',
            "es.employee_id = e.id 
         AND es.date BETWEEN '$startDate' AND '$endDate'",
            'inner'
        );

        $builder->join('working_days wd', 'wd.id = es.working_days_id');

        // 🔥 SHIFT FILTER
        $builder->whereIn('wd.shift_id', $shiftIds);

        // =========================
        // GROUPING
        // =========================
        $builder->groupBy([
            'e.plant_id',
            'e.division_id',
            'd.name'
        ]);

        $builder->orderBy('d.name', 'ASC');

        return $builder->get()->getResult();
    }

    //================= function absent_plant_new =====================
    public function getAbsentPerPlant($today, $startDateTime, $endDateTime, $shiftIds, $plantId)
    {
        $attendanceSub = $this->db->table('attendance')
            ->select('pin, MIN(datetime) as first_time')
            ->where('datetime >=', $startDateTime)
            ->where('datetime <=', $endDateTime)
            ->groupBy('pin')
            ->getCompiledSelect();

        return $this->db->table('employee_schedule es')
            ->select('
            e.id, 
            e.employee_pin, 
            e.name, 
            e.employee_id,
            d.name as division, 
            p.name as plant, 
            eg.name as employee_group,
            ab.absent_type_id,
            ab.information,
            at.name as absent_type_name
        ')
            ->join('employee e', 'e.id = es.employee_id')
            ->join('division d', 'd.id = e.division_id')
            ->join('plant p', 'p.id = e.plant_id')
            ->join('employee_group eg', 'eg.id = e.employee_group_id')
            ->join('working_days wd', 'wd.id = es.working_days_id')

            ->join("($attendanceSub) as a", 'a.pin = e.employee_pin', 'left')

            // 🔥 join absent
            ->join(
                'absent ab',
                'ab.employee_id = e.id 
                AND "' . $today . '" BETWEEN ab.date AND ab.end_date 
                AND ab.deleted_at IS NULL
                AND ab.absent_type_id != 7',
                'left'
            )

            ->join('absent_type at', 'at.id = ab.absent_type_id', 'left')

            ->where('es.date', $today)
            ->where('e.plant_id', $plantId)
            ->whereIn('wd.shift_id', $shiftIds)
            ->whereIn('e.employee_status_id', [1, 2])

            ->where('a.pin IS NULL') // tidak ada attendance

            ->orderBy('e.name', 'ASC')
            ->get()
            ->getResult();
    }

    //============ function chart employee performance by type ======
    public function getAbsentDivisionRangeType($startDate, $endDate, $divisionId = null, $typeId = [])
    {
        $builder = $this->db->table('absent a');

        $builder->select('
        e.id as employee_id,
        e.name as employee_name,
        a.absent_type_id,
        at.name as absent_type,
        COUNT(a.id) as total
    ');

        $builder->join('employee e', 'e.id = a.employee_id');
        $builder->join('absent_type at', 'at.id = a.absent_type_id');

        $builder->where('a.deleted_at', null);

        if (!empty($typeId)) {
            $builder->whereIn('a.absent_type_id', $typeId);
        }

        $builder->where('a.date >=', $startDate);
        $builder->where('a.date <=', $endDate);

        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        $builder->groupBy([
            'e.id',
            'a.absent_type_id'
        ]);

        $builder->orderBy('total', 'DESC');
        $builder->orderBy('e.name', 'ASC');

        return $builder
            ->get()
            ->getResultArray();
    }

    //============ function chartDivision ===========================
    public function getAbsentDivisionRange($startDate, $endDate, $divisionId = null)
    {
        return $this->db->table('absent a')
            ->select('
            d.id as division_id,
            d.name as division,
            a.absent_type_id,
            at.name as absent_type,
            a.date,
            COUNT(a.id) as total
        ')
            ->join('employee e', 'e.id = a.employee_id')
            ->join('division d', 'd.id = e.division_id')
            ->join('absent_type at', 'at.id = a.absent_type_id')

            // =========================
            // FILTER
            // =========================
            ->where('a.deleted_at', null)
            ->where('d.deleted_at', null)
            ->whereIn('a.absent_type_id', [1, 2, 6, 7, 16])

            // GLOBAL DATE RANGE
            ->where('a.date >=', $startDate)
            ->where('a.date <=', $endDate)

            // GLOBAL DIVISION FILTER
            ->when(!empty($divisionId), function ($builder) use ($divisionId) {
                return $builder->where('e.division_id', $divisionId);
            })

            // =========================
            // IMPORTANT: EVENT-BASED GROUPING
            // =========================
            ->groupBy([
                'd.id',
                'a.absent_type_id',
                'a.date'
            ])

            ->orderBy('a.date', 'ASC')

            ->get()
            ->getResultArray();
    }

    //============ function chartDivision ===========================
    // public function getAbsentDivisionMonthly($startDate, $endDate)
    // {
    //     return $this->db->table('absent a')
    //         ->select('
    //         d.id as division_id,
    //         d.name as division,
    //         a.absent_type_id,
    //         at.name as absent_type,
    //         a.date,
    //         COUNT(a.id) as total
    //     ')
    //         ->join('employee e', 'e.id = a.employee_id')
    //         ->join('division d', 'd.id = e.division_id')
    //         ->join('absent_type at', 'at.id = a.absent_type_id')

    //         // filter
    //         ->where('d.deleted_at', null)
    //         ->where('a.deleted_at', null)
    //         ->whereIn('a.absent_type_id', [1, 2, 6, 7, 16])

    //         // range
    //         ->where('a.date >=', $startDate)
    //         ->where('a.date <=', $endDate)

    //         // IMPORTANT: jangan buang date
    //         ->groupBy(['d.id', 'a.absent_type_id', 'a.date'])

    //         ->orderBy('COUNT(a.id)', 'DESC')
    //         ->get()
    //         ->getResultArray();
    // }

    //============= function buildChartAbsentEmployee ========================
    public function getChartAbsentEmployee($divisionId, $month, $year, $absentTypeId)
    {
        return $this->db->table('absent a')
            ->select('
            e.id as employee_id,
            e.name as employee_name,
            COUNT(a.id) as total
        ')
            ->join('employee e', 'e.id = a.employee_id')
            // ->where('a.absent_type_id', $absentTypeId)
            ->whereIn('a.absent_type_id', $absentTypeId)
            ->where('e.division_id', $divisionId)
            ->where('MONTH(a.date)', $month)
            ->where('YEAR(a.date)', $year)
            ->where('a.deleted_at', null)
            ->groupBy('a.employee_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }

    //================ function chartMonthlyAbsentTrend ======================
    public function getAbsentTrendByRange($startDate, $endDate, $typeIds, $divisionId = null)
    {
        $builder = $this->db->table('absent a')
            ->select('DATE(a.date) as date, COUNT(*) as total')
            ->join('employee e', 'e.id = a.employee_id')
            ->where('a.date >=', $startDate)
            ->where('a.date <=', $endDate)
            ->where('a.deleted_at', null)
            ->whereIn('a.absent_type_id', $typeIds);

        if (!empty($divisionId)) {
            $builder->where('e.division_id', $divisionId);
        }

        return $builder
            ->groupBy('DATE(a.date)')
            ->get()
            ->getResultArray();
    }
    // public function getMonthlyAbsentTrend($month, $year, $typeIds, $divisionId = null)
    // {
    //     $builder = $this->db->table('absent a')
    //         ->select('DAY(a.date) as day, COUNT(*) as total')
    //         ->join('employee e', 'e.id = a.employee_id')
    //         ->where('MONTH(a.date)', $month)
    //         ->where('YEAR(a.date)', $year)
    //         ->where('a.deleted_at', null)
    //         ->whereIn('a.absent_type_id', $typeIds);

    //     if (!empty($divisionId)) {
    //         $builder->where('e.division_id', $divisionId);
    //     }

    //     return $builder
    //         ->groupBy('DAY(a.date)')
    //         ->get()
    //         ->getResultArray();
    // }

    // public function getAbsentData($shiftId, $plantId, $date)
    // {
    //     // total employee (scheduled)
    //     $totalEmployee = $this->db->table('employee_schedule es')
    //         ->select('COUNT(DISTINCT e.id) as total')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->whereIn('wd.shift_id', $shiftId)
    //         ->where('es.date', $date)
    //         ->where('e.plant_id', $plantId)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->get()
    //         ->getRow()
    //         ->total ?? 0;

    //     // total attendance (present)
    //     $totalAttendance = $this->db->table('attendance a')
    //         ->select('COUNT(DISTINCT e.id) total')
    //         ->join('employee e', 'e.employee_pin = a.pin')
    //         ->join('employee_schedule es', 'es.employee_id = e.id AND es.date = a.date')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->whereIn('wd.shift_id', $shiftId)
    //         ->where('e.plant_id', $plantId)
    //         ->where('a.date', $date)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->get()
    //         ->getRow()
    //         ->total ?? 0;

    //     $percentage = $totalEmployee > 0
    //         ? round(($totalAttendance / $totalEmployee) * 100, 2)
    //         : 0;

    //     return [
    //         'total_employee'   => $totalEmployee,
    //         'total_attendance' => $totalAttendance,
    //         'percentage'       => $percentage
    //     ];
    // }

    //=============== function isShiftActive =====================
    // public function getShiftStartTime($shiftIds)
    // {
    //     return $this->db->table('working_days wd')
    //         ->selectMin('wh.entry_time')
    //         ->join('working_hours wh', 'wh.id = wd.working_hours_id')
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->get()
    //         ->getRow()
    //         ->start_time ?? null;
    // }

    // public function getTotalEmployeeByShift($shiftId, $date)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('COUNT(DISTINCT e.id) as total')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->whereIn('wd.shift_id', $shiftId)
    //         ->where('es.date', $date)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->get()
    //         ->getRow()
    //         ->total ?? 0;
    // }

    // public function employeeAbsentToday($today)
    // {

    //     return $this->db->table('absent')
    //         ->select('employee.name, division.name as division_name, absent_type.name as absent_type_name')
    //         ->join('employee', 'employee.id = absent.employee_id', 'left')
    //         ->join('division', 'division.id = employee.division_id', 'left')
    //         ->join('absent_type', 'absent_type.id = absent.absent_type_id', 'left')
    //         ->where('absent.absent_type_id !=', 7) // kecuali tipe 7
    //         ->where('absent.date', $today)
    //         ->orderBy('employee.name', 'ASC')
    //         ->get()
    //         ->getResultArray();
    // }

    // public function totalEmployeeAbsentToday($today)
    // {

    //     return $this->db->table('absent')
    //         ->where('date', $today)
    //         ->where('absent.absent_type_id !=', 7) // kecuali tipe 7
    //         ->countAllResults();
    // }

    // public function totalEmployeeLateToday($today)
    // {
    //     return $this->db->table('employee_late')
    //         ->select('COUNT(DISTINCT employee_pin) as total')
    //         ->where('date', $today)
    //         ->get()
    //         ->getRow()
    //         ->total;
    // }

    // public function employeeLateToday($today)
    // {
    //     return $this->db->table('employee_late')
    //         ->select('employee.name, division.name as division_name, employee_late.late_hour')
    //         ->join('employee', 'employee.employee_pin = employee_late.employee_pin', 'left')
    //         ->join('division', 'division.id = employee.division_id', 'left')
    //         ->where('employee_late.date', $today)
    //         ->orderBy('late_hour', 'ASC')
    //         ->get()
    //         ->getResultArray();
    // }

    // public function grafikEmployee()
    // {
    //     $builder = $this->db->table('data_employee');
    //     $builder->select('plant, employee_group, COUNT(*) as total');
    //     $builder->groupBy('plant, employee_group');
    //     $builder->orderBy('plant, employee_group');
    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    // public function countEmployee($employee_status_id = false, $gender_id = false, $company_id = false)
    // {
    //     $builder = $this->db->table('employee');

    //     if ($employee_status_id !== false) {
    //         $builder->where('employee_status_id', $employee_status_id);
    //     }

    //     if ($gender_id !== false) {
    //         $builder->where('gender_id', $gender_id);
    //     }

    //     if ($company_id !== false) {
    //         $builder->where('company_id', $company_id);
    //     }

    //     return $builder->get()->getNumRows();
    // }

    // public function countEmployee2($employee_status_id = false, $gender_id = false)
    // {
    //     if ($employee_status_id == false && $gender_id == false) {
    //         return $this->db->table('employee')->where('division_id', '12')->get()->getNumRows();
    //     } else {
    //         if ($employee_status_id != false) {
    //             return $this->db->table('employee')->where('employee_status_id', $employee_status_id)->where('division_id', '12')->get()->getNumRows();
    //         } else {
    //             return $this->db->table('employee')->where('gender_id', $gender_id)->where('division_id', '12')->get()->getNumRows();
    //         }
    //     }
    // }

    // public function totalAbsentPerTypeMonth($year, $month)
    // {
    //     // Ambil semua absent_type dulu
    //     $absentTypes = $this->db->table('absent_type')->get()->getResultArray();

    //     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //     $series = [];

    //     foreach ($absentTypes as $type) {
    //         $data = [];
    //         for ($day = 1; $day <= $daysInMonth; $day++) {
    //             $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

    //             $count = $this->db->table('absent a')
    //                 ->select('COUNT(*) as total')
    //                 ->where('a.date', $date)
    //                 ->where('a.absent_type_id', $type['id'])
    //                 ->where('a.deleted_at', null)
    //                 ->get()
    //                 ->getRow()
    //                 ->total ?? 0;

    //             $data[] = (int)$count;
    //         }

    //         $series[] = [
    //             'name' => $type['name'],
    //             'data' => $data
    //         ];
    //     }

    //     return $series;
    // }

    // public function countAllEmployee()
    // {
    //     $builder = $this->db->table('employee');
    //     $builder->select('*');
    //     $query = $builder->get();
    //     // echo $this->db->getLastQuery();
    //     return $query->getNumRows();
    // }

    // public function countActivePermanent()
    // {
    //     $builder = $this->db->table('employee');
    //     $builder->select('*');
    //     $builder->where('employee_status_id = 1');
    //     $query = $builder->get();
    //     // echo $this->db->getLastQuery();
    //     return $query->getNumRows();
    // }

    // public function countActiveContract()
    // {
    //     $builder = $this->db->table('employee');
    //     $builder->select('*');
    //     $builder->where('employee_status_id = 2');
    //     $query = $builder->get();
    //     // echo $this->db->getLastQuery();
    //     return $query->getNumRows();
    // }

    // public function countNonActive()
    // {
    //     $builder = $this->db->table('employee');
    //     $builder->select('*');
    //     $builder->where('employee_status_id = 3');
    //     $query = $builder->get();
    //     // echo $this->db->getLastQuery();
    //     return $query->getNumRows();
    // }

    // public function getTotalShiftRange($startDate, $endDate, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('e.plant_id, es.date, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy(['e.plant_id', 'es.date'])
    //         ->get()
    //         ->getResult();
    // }

    // public function getSchedulePerPlantDateRange($startDate, $endDate, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('e.plant_id, es.date, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy(['e.plant_id', 'es.date'])
    //         ->get()
    //         ->getResult();
    // }

    // public function getAttendancePerPlantDateRange($startDate, $endDate)
    // {
    //     return $this->db->table('employee_attendance ea')
    //         ->select('e.plant_id, DATE(ea.created_at) as date, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = ea.employee_id')
    //         ->where('DATE(ea.created_at) >=', $startDate)
    //         ->where('DATE(ea.created_at) <=', $endDate)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy(['e.plant_id', 'date'])
    //         ->get()
    //         ->getResult();
    // }


    // public function testAttendance($today)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date', $today)
    //         ->where('e.plant_id', 1)
    //         ->whereIn('wd.shift_id', [1, 5])
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->countAllResults();
    // }

    //export excel percentage
    // public function getMonthlySchedule($startDate, $endDate, $shiftIds)
    // {
    //     return $this->db->table('employee_schedule es')
    //         ->select('e.plant_id, es.date, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.id = es.employee_id')
    //         ->join('working_days wd', 'wd.id = es.working_days_id')
    //         ->where('es.date >=', $startDate)
    //         ->where('es.date <=', $endDate)
    //         ->whereIn('wd.shift_id', $shiftIds)
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy(['e.plant_id', 'es.date'])
    //         ->get()
    //         ->getResult();
    // }

    // public function getMonthlyAttendance($startDateTime, $endDateTime)
    // {
    //     $subquery = $this->db->table('attendance')
    //         ->select('pin, MIN(datetime) as first_time')
    //         ->where('datetime >=', $startDateTime)
    //         ->where('datetime <=', $endDateTime)
    //         ->groupBy('pin')
    //         ->getCompiledSelect();

    //     return $this->db->table("($subquery) as a")
    //         ->select('e.plant_id, DATE(a.first_time) as date, COUNT(DISTINCT e.id) as total')
    //         ->join('employee e', 'e.employee_pin = a.pin')
    //         ->whereIn('e.employee_status_id', [1, 2])
    //         ->groupBy(['e.plant_id', 'date'])
    //         ->get()
    //         ->getResult();
    // }
}
