<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
    protected $table            = 'attendance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['attendance_machine_id', 'pin', 'datetime', 'date', 'time', 'verified', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataAttendanceEmployee($date, $shift_id = null, $plant_id = null, $employee_group_id = null, $division_id = null, $status = null)
    {
        /*
    |--------------------------------------------------------------------------
    | QUERY 1 : NORMAL SCHEDULE
    |--------------------------------------------------------------------------
    */
        $builder1 = $this->db->table('employee_schedule es');

        $builder1->select("
        e.id as id,
        e.employee_id as employee_id,
        e.name,
        e.employee_pin,
        es.date as schedule_date,
        es.date as date,
        wd.shift_name,
        d.name as division,
        p.name as position,
        pt.name as plant,
        eg.name as employee_group,
        ems.name as employee_status,
        wh.entry_time,
        wh.clock_out,

        MIN(CASE
            WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in
            THEN a.time END) AS jam_masuk,

        MAX(CASE
            WHEN a.time BETWEEN wh.start_scan_out AND wh.end_scan_out
            THEN a.time END) AS jam_pulang,

        CASE
            WHEN 
                MIN(CASE WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in THEN a.time END) IS NOT NULL
                OR
                MAX(CASE WHEN a.time BETWEEN wh.start_scan_out AND wh.end_scan_out THEN a.time END) IS NOT NULL
            THEN 1 ELSE 0
        END AS hadir_flag
    ");

        $builder1->join('employee e', 'e.id = es.employee_id');
        $builder1->join('division d', 'd.id = e.division_id');
        $builder1->join('position p', 'p.id = e.position_id');
        $builder1->join('plant pt', 'pt.id = e.plant_id');
        $builder1->join('employee_group eg', 'eg.id = e.employee_group_id');
        $builder1->join('employee_status ems', 'ems.id = e.employee_status_id');
        $builder1->join('working_days wd', 'wd.id = es.working_days_id');
        $builder1->join('working_hours wh', 'wh.id = wd.working_hours_id');
        $builder1->join('shift s', 's.id = wd.shift_id');

        $builder1->join(
            'attendance a',
            "a.pin = e.employee_pin AND (
            (a.date = es.date AND a.time BETWEEN wh.start_scan_in AND wh.end_scan_in)
            OR
            (wh.clock_out < wh.entry_time AND a.date = DATE_ADD(`es`.`date`, INTERVAL 1 DAY) AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
            OR
            (wh.clock_out >= wh.entry_time AND a.date = es.date AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
        )",
            'left',
            false
        );

        $builder1->where('es.date', $date);
        $builder1->where('es.deleted_at', null);
        $builder1->whereIn('e.employee_status_id', [1, 2]);

        if (!empty($shift_id)) {
            $builder1->where('s.id', $shift_id);
        }
        if (!empty($plant_id)) {
            $builder1->where('e.plant_id', $plant_id);
        }
        if (!empty($employee_group_id)) {
            $builder1->where('e.employee_group_id', $employee_group_id);
        }
        if (!empty($division_id)) {
            $builder1->where('e.division_id', $division_id);
        }

        $builder1->groupBy('e.id, es.date');

        if ($status == 'hadir') {
            $builder1->having('hadir_flag', 1);
        } elseif ($status == 'tidak_hadir') {
            $builder1->having('hadir_flag', 0);
        }

        $sql1 = $builder1->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | QUERY 2 : OVERTIME (TIDAK ADA SCHEDULE)
    |--------------------------------------------------------------------------
    */
        $builder2 = $this->db->table('attendance a');

        $builder2->select("
        e.id as id,
        e.employee_id as employee_id,
        e.name,
        e.employee_pin,
        NULL as schedule_date,
        a.date as date,
        '-' as shift_name,
        d.name as division,
        p.name as position,
        pt.name as plant,
        eg.name as employee_group,
        ems.name as employee_status,
        NULL as entry_time,
        NULL as clock_out,
        MIN(a.time) as jam_masuk,
        MAX(a.time) as jam_pulang,
        1 as hadir_flag
    ");

        $builder2->join('employee e', 'e.employee_pin = a.pin');
        $builder2->join('division d', 'd.id = e.division_id');
        $builder2->join('position p', 'p.id = e.position_id');
        $builder2->join('plant pt', 'pt.id = e.plant_id');
        $builder2->join('employee_group eg', 'eg.id = e.employee_group_id');
        $builder2->join('employee_status ems', 'ems.id = e.employee_status_id');

        // pastikan tidak punya schedule
        $builder2->join(
            'employee_schedule es',
            "es.employee_id = e.id AND es.date = a.date",
            'left'
        );

        $builder2->where('es.id IS NULL');
        $builder2->where('a.date', $date);
        $builder2->whereIn('e.employee_status_id', [1, 2]);

        if (!empty($plant_id)) {
            $builder2->where('e.plant_id', $plant_id);
        }
        if (!empty($employee_group_id)) {
            $builder2->where('e.employee_group_id', $employee_group_id);
        }
        if (!empty($division_id)) {
            $builder2->where('e.division_id', $division_id);
        }

        $builder2->groupBy('e.id, a.date');

        if ($status == 'hadir') {
            $builder2->having('hadir_flag', 1);
        }

        $sql2 = $builder2->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | UNION BOTH
    |--------------------------------------------------------------------------
    */
        $finalSql = $sql1 . " UNION ALL " . $sql2 . " ORDER BY name ASC";

        return $this->db->query($finalSql)->getResultObject();
    }

    public function summaryAttendance($date)
    {
        $sql = "
    SELECT 
        plant,
        shift_name,
        COUNT(*) as total,
        SUM(hadir_flag) as hadir,
        SUM(CASE WHEN hadir_flag = 0 THEN 1 ELSE 0 END) as tidak_hadir
    FROM (
        SELECT 
            e.id,
            pt.name as plant,
            wd.shift_name,

            CASE
                WHEN 
                    MIN(CASE 
                        WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in 
                        THEN a.time 
                    END) IS NOT NULL
                    OR
                    MAX(CASE 
                        WHEN a.time BETWEEN wh.start_scan_out AND wh.end_scan_out 
                        THEN a.time 
                    END) IS NOT NULL
                    OR
                    MAX(CASE 
                        WHEN ab.absent_type_id = 7 THEN 1 
                    END) = 1
                THEN 1 ELSE 0
            END AS hadir_flag

        FROM employee_schedule es
        JOIN employee e ON e.id = es.employee_id
        JOIN plant pt ON pt.id = e.plant_id
        JOIN working_days wd ON wd.id = es.working_days_id
        JOIN working_hours wh ON wh.id = wd.working_hours_id

        LEFT JOIN attendance a 
            ON a.pin = e.employee_pin
            AND (
                (a.date = es.date AND a.time BETWEEN wh.start_scan_in AND wh.end_scan_in)
                OR
                (wh.clock_out < wh.entry_time 
                    AND a.date = DATE_ADD(es.date, INTERVAL 1 DAY) 
                    AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
                OR
                (wh.clock_out >= wh.entry_time 
                    AND a.date = es.date 
                    AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
            )

        LEFT JOIN absent ab 
            ON ab.employee_id = e.id
            AND ab.date = es.date

        WHERE es.date = ?
        AND es.deleted_at IS NULL
        AND e.employee_status_id IN (1,2)

        GROUP BY e.id, pt.name, wd.shift_name
    ) t

    GROUP BY plant, shift_name
    ORDER BY plant ASC, shift_name ASC
";

        return $this->db->query($sql, [$date])->getResultObject();
    }

    public function dataAttendanceEmployeeUser($employee_id, $start_date, $end_date)
    {
        /*
    |--------------------------------------------------------------------------
    | QUERY 1 : ADA SCHEDULE
    |--------------------------------------------------------------------------
    */
        $builder1 = $this->db->table('employee_schedule es');

        $builder1->select("
        e.id,
        es.date as date,
        e.name,
        e.employee_id,
        e.employee_pin,
        d.name as division,
        p.name as position,
        pt.name as plant,
        eg.name as employee_group,
        s.name as shift_name,
        wh.entry_time,
        wh.clock_out,
        es.date as schedule_date,

        MIN(CASE 
            WHEN a.date = es.date 
            AND a.time BETWEEN wh.start_scan_in AND wh.end_scan_in
            THEN a.time
        END) AS jam_masuk,

        MAX(CASE 
            WHEN 
                (wh.clock_out < wh.entry_time 
                    AND a.date = DATE_ADD(`es`.`date`, INTERVAL 1 DAY) 
                    AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
             OR (wh.clock_out >= wh.entry_time 
                    AND a.date = es.date 
                    AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
            THEN a.time
        END) AS jam_pulang,

        TIMEDIFF(
            MIN(CASE 
                WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in 
                THEN a.time 
            END),
            wh.entry_time
        ) AS durasi_telat
    ");

        $builder1->join('employee e', 'e.id = es.employee_id');
        $builder1->join('division d', 'd.id = e.division_id');
        $builder1->join('position p', 'p.id = e.position_id');
        $builder1->join('plant pt', 'pt.id = e.plant_id');
        $builder1->join('employee_group eg', 'eg.id = e.employee_group_id');
        $builder1->join('working_days wd', 'wd.id = es.working_days_id');
        $builder1->join('working_hours wh', 'wh.id = wd.working_hours_id');
        $builder1->join('shift s', 's.id = wd.shift_id');

        $builder1->join(
            'attendance a',
            'a.pin = e.employee_pin',
            'left'
        );

        $builder1->where('e.id', $employee_id);
        $builder1->where('es.date >=', $start_date);
        $builder1->where('es.date <=', $end_date);

        $builder1->groupBy('es.id');

        $sql1 = $builder1->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | QUERY 2 : OVERTIME (TIDAK ADA SCHEDULE)
    |--------------------------------------------------------------------------
    */
        $builder2 = $this->db->table('attendance a');

        $builder2->select("
        e.id,
        a.date as date,
        e.name,
        e.employee_id,
        e.employee_pin,
        d.name as division,
        p.name as position,
        pt.name as plant,
        eg.name as employee_group,
        '-' as shift_name,
        NULL as entry_time,
        NULL as clock_out,
        NULL as schedule_date,

        MIN(a.time) as jam_masuk,
        MAX(a.time) as jam_pulang,
        NULL as durasi_telat
    ");

        $builder2->join('employee e', 'e.employee_pin = a.pin');
        $builder2->join('division d', 'd.id = e.division_id');
        $builder2->join('position p', 'p.id = e.position_id');
        $builder2->join('plant pt', 'pt.id = e.plant_id');
        $builder2->join('employee_group eg', 'eg.id = e.employee_group_id');

        // pastikan tidak ada schedule di tanggal itu
        $builder2->join(
            'employee_schedule es',
            'es.employee_id = e.id AND es.date = a.date',
            'left'
        );

        $builder2->where('es.id IS NULL');
        $builder2->where('e.id', $employee_id);
        $builder2->where('a.date >=', $start_date);
        $builder2->where('a.date <=', $end_date);

        $builder2->groupBy('a.date');

        $sql2 = $builder2->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | UNION
    |--------------------------------------------------------------------------
    */
        $finalSql = $sql1 . " UNION ALL " . $sql2 . " ORDER BY date ASC";

        return $this->db->query($finalSql)->getResultObject();
    }

    public function getAttendanceByDate($employee_id, $date)
    {
        return $this->db->table('attendance a')
            ->select('MIN(a.time) as jam_masuk, MAX(a.time) as jam_pulang')
            ->join('employee e', 'e.employee_pin = a.pin')
            ->where('e.id', $employee_id)
            ->where('a.date', $date)
            ->get()->getRow();
    }

    public function dataAttendanceEmployeeUserWithAllDates($employee_id, $start_date, $end_date)
    {
        // Ambil data dari query asli
        $attendanceData = $this->dataAttendanceEmployeeUser($employee_id, $start_date, $end_date);


        // Generate semua tanggal
        $allDates = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);

        while ($current <= $end) {
            $allDates[date('Y-m-d', $current)] = null;
            $current = strtotime('+1 day', $current);
        }

        $result = [];
        foreach ($allDates as $date => $_) {
            $found = null;
            foreach ($attendanceData as $row) {
                if ($row->schedule_date == $date) {
                    $found = $row;
                    break;
                }
            }

            if ($found) {
                $result[] = $found;
            } else {
                // bikin object kosong/default
                $jamData = $this->getAttendanceByDate($employee_id, $date);
                $jam_masuk = $jamData->jam_masuk ?? '';
                $jam_pulang = $jamData->jam_pulang ?? '';
                if ($jam_masuk && $jam_pulang != null) {
                    $result[] = (object)[
                        'id' => $employee_id,
                        'date' => $date,
                        'name' => $attendanceData[0]->name ?? '',
                        'employee_id' => $attendanceData[0]->employee_id ?? '',
                        'employee_pin' => $attendanceData[0]->employee_pin ?? '',
                        'division' => $attendanceData[0]->division ?? '',
                        'position' => $attendanceData[0]->position ?? '',
                        'plant' => $attendanceData[0]->plant ?? '',
                        'employee_group' => $attendanceData[0]->employee_group ?? '',
                        'shift_name' => '[OVERTIME]]',
                        'entry_time' => null,
                        'clock_out' => null,
                        'schedule_date' => null,
                        'jam_masuk' => $jam_masuk ?? '',
                        'jam_pulang' => $jam_pulang ?? '',
                        'durasi_telat' => null
                    ];
                }
            }
        }

        return $result;
    }

    public function attendanceDepartment($year, $month, $division_id, $plant_id, $employee_group_id)
    {
        $builder = $this->db->table('employee_schedule es');

        $builder->select("
        e.id,
        e.name,
        e.employee_id,
        e.employee_pin,
        es.date,
        d.name AS division,
        p.name AS plant,
        eg.name AS employee_group,
        s.name AS shift_name,
        wh.entry_time,
        wh.clock_out,

        MIN(CASE 
            WHEN a.date = es.date AND a.time BETWEEN wh.start_scan_in AND wh.end_scan_in
            THEN a.time
        END) AS jam_masuk,

        MAX(CASE 
            WHEN 
                (wh.clock_out < wh.entry_time AND a.date = DATE_ADD(es.date, INTERVAL 1 DAY) AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
             OR (wh.clock_out >= wh.entry_time AND a.date = es.date AND a.time BETWEEN wh.start_scan_out AND wh.end_scan_out)
            THEN a.time
        END) AS jam_pulang,

        CASE 
    WHEN MIN(CASE WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in THEN a.time END) IS NULL
        THEN NULL
    WHEN MIN(CASE WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in THEN a.time END) <= wh.entry_time
        THEN '00:00:00'
    ELSE TIMEDIFF(
        MIN(CASE WHEN a.time BETWEEN wh.start_scan_in AND wh.end_scan_in THEN a.time END),
        wh.entry_time
    )
END AS durasi_telat
    ");

        $builder->join('employee e', 'e.id = es.employee_id');
        $builder->join('division d', 'd.id = e.division_id');
        $builder->join('plant p', 'p.id = e.plant_id');
        $builder->join('employee_group eg', 'eg.id = e.employee_group_id');
        $builder->join('working_days wd', 'wd.id = es.working_days_id');
        $builder->join('working_hours wh', 'wh.id = wd.working_hours_id');
        $builder->join('shift s', 's.id = wd.shift_id');
        $builder->join('attendance a', 'a.pin = e.employee_pin', 'left');

        $builder->where('MONTH(es.date)', $month);
        $builder->where('YEAR(es.date)', $year);
        $builder->where('e.division_id', $division_id);
        $builder->where('e.plant_id', $plant_id);
        $builder->where('e.employee_group_id', $employee_group_id);
        $builder->whereIn('employee_status_id', [1, 2]); // active

        $builder->groupBy('es.id, es.date, e.id, wh.entry_time, wh.clock_out');
        $builder->orderBy('es.date ASC, e.name ASC');

        return $builder->get()->getResultObject();
    }

    public function checkData($attendance_machine_id, $PIN, $Datetime, $Verified, $Status)
    {
        $builder = $this->db->table('attendance');
        $builder->select('*');
        $builder->where('attendance_machine_id', $attendance_machine_id);
        $builder->where('pin', $PIN);
        $builder->where('datetime', $Datetime);
        $builder->where('verified', $Verified);
        $builder->where('status', $Status);
        $query = $builder->get();
        // echo $this->db->getLastQuery();
        return $query->getNumRows();
    }

    public function attendaceEmployee($date, $division_id)
    {
        $builder = $this->db->table('data_attendance');
        $builder->select('*');
        $builder->where('date', $date);
        $builder->where('employee_status_id !=', '3');
        $builder->orderBy('id', 'DESC');
        if (!empty($division_id)) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query;
    }

    public function logAttendance($date, $attendance_machine_id, $division_id)
    {

        $builder = $this->db->table('data_attendance');
        if ($attendance_machine_id != null) {
            $builder->where('attendance_machine_id', $attendance_machine_id);
        }
        $builder->where('date', $date);
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query;
    }

    public function checkAttendance($PIN, $date)
    {
        $builder = $this->db->table('attendance');
        $builder->where('pin', $PIN);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function checkEmployeeLate($PIN, $date)
    {
        $builder = $this->db->table('employee_late');
        $builder->where('employee_pin', $PIN);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function NoAbsen($pin_id)
    {
        $builder = $this->db->table('employee');
        $builder->whereNotIn('employee_pin', $pin_id);
        $query = $builder->get();
        return $query;
    }

    public function dataAbsent($pin_id, $pin_absent, $pin_late, $date, $division_id)
    {
        $builder = $this->db->table('employee');
        $builder->select('employee.id as id, employee.name as name, employee.employee_id, division, position, plant, employee_group, shift_name, entry_time');
        $builder->join('employee_schedule', 'employee_schedule.employee_id = employee.id');
        $builder->join('data_employee', 'data_employee.id = employee.id');
        $builder->join('working_days', 'working_days.id = employee_schedule.working_days_id');
        $builder->join('working_hours', 'working_hours.id = working_days.working_hours_id');
        $builder->where('employee_schedule.date', $date);
        if ($pin_id != null) {
            $builder->whereNotIn('employee.employee_pin', $pin_id);
        }
        if ($pin_absent != null) {
            $builder->whereNotIn('employee.employee_pin', $pin_absent);
        }
        if ($pin_late != null) {
            $builder->whereNotIn('employee.employee_pin', $pin_late);
        }
        if (!empty($division_id)) {
            $builder->where('employee.division_id', $division_id);
        }
        $query = $builder->get();
        // echo $this->db->getLastQuery();
        // die();
        return $query;
    }

    public function saveAbsent($data)
    {
        $this->db->table('absent')->insert($data);
    }

    public function saveLate($data)
    {
        $this->db->table('employee_late')->insert($data);
    }

    public function getAbsent($date)
    {
        $builder = $this->db->table('absent');
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }

    public function getLate($date)
    {
        $builder = $this->db->table('employee_late');
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }

    public function dataEmployee()
    {
        $builder = $this->db->table('data_employee');
        $builder->select('*');

        $builder->where('employee_status_id !=', 3);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataEmployeeUser($employee_id)
    {
        $builder = $this->db->table('data_employee');
        $builder->select('*');
        $builder->where('id', $employee_id);
        $query = $builder->get();
        return $query->getResultObject();
    }


    public function SearchdataEmployee($plant_id, $employee_group_id, $division_id, $date = null, $status = 'all', $shift_id = 'all')
    {
        $builder = $this->db->table('data_employee');
        $builder->select('data_employee.*, attendance.pin as hadir_pin');

        // Join ke attendance (LEFT JOIN supaya yang tidak hadir tetap muncul)
        if ($date !== null) {
            $builder->join('attendance', "attendance.pin = data_employee.employee_pin AND attendance.date = '$date'", 'left');
        }

        // Join ke employee_schedule dan working_days untuk ambil shift_id
        if ($date !== null && $shift_id !== 'all') {
            $builder->join('employee_schedule', "employee_schedule.employee_id = data_employee.id AND employee_schedule.date = '$date'", 'left');
            $builder->join('working_days', 'working_days.id = employee_schedule.working_days_id', 'left');
            $builder->where('working_days.shift_id', $shift_id);
        }

        $builder->where('employee_status_id !=', 3);

        if ($plant_id != 0) {
            $builder->where('plant_id', $plant_id);
        }
        if ($employee_group_id != 0) {
            $builder->where('employee_group_id', $employee_group_id);
        }
        if ($division_id != 0) {
            $builder->where('division_id', $division_id);
        }

        // Filter Hadir/Tidak Hadir
        if ($status == 'hadir') {
            $builder->where('attendance.pin IS NOT NULL');
        } elseif ($status == 'tidak_hadir') {
            $builder->where('attendance.pin IS NULL');
        }

        $query = $builder->get();
        return $query->getResultObject();
    }

    public function AttendanceData($pin, $date)
    {
        $builder = $this->db->table('attendance');
        $builder->where('pin', $pin);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }

    public function ScheduleData($pin, $date)
    {
        $builder = $this->db->table('employee_schedule');
        $builder->join('working_days', 'working_days.id = employee_schedule.working_days_id');
        $builder->join('working_hours', 'working_hours.id = working_days.working_hours_id');
        $builder->where('employee_pin', $pin);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }

    public function checkAbsent($pin, $date)
    {
        $builder = $this->db->table('absent');
        $builder->join('absent_type', 'absent_type.id = absent.absent_type_id');
        $builder->where('employee_pin', $pin);
        $builder->where("'$date' BETWEEN `date` AND `end_date`");
        $query = $builder->get();
        return $query;
    }

    public function Absent($date)
    {
        $builder = $this->db->table('absent');
        $builder->select('*,absent.id as id, data_employee.name as name, absent_type.name as absent_type, absent.created_at, absent.updated_at');
        $builder->join('data_employee', 'data_employee.id = absent.employee_id');
        $builder->join('absent_type', 'absent_type.id = absent.absent_type_id');
        $builder->where('absent.date', $date);
        $query = $builder->get();
        return $query->getResult();
    }

    public function attendanceMonthlyDepartment(
        $start_date,
        $end_date,
        $division_id,
        $plant_id = null,
        $employee_group_id = null
    ) {

        /*
    |--------------------------------------------------------------------------
    | QUERY 1 : ADA SCHEDULE
    |--------------------------------------------------------------------------
    */
        $builder1 = $this->db->table('employee_schedule es');

        $builder1->select("
        e.id AS id,
        e.employee_id,
        e.name,
        d.name AS division,
        p.name AS plant,
        eg.name AS employee_group,
        es.date,

        CASE
            WHEN MIN(a.time) IS NOT NULL THEN 'H'
            ELSE '-'
        END AS status,
        'NORMAL' AS source
    ");

        $builder1->join('employee e', 'e.id = es.employee_id');
        $builder1->join('division d', 'd.id = e.division_id');
        $builder1->join('plant p', 'p.id = e.plant_id');
        $builder1->join('employee_group eg', 'eg.id = e.employee_group_id');

        $builder1->join('attendance a', "
        a.pin = e.employee_pin
        AND (
            a.date = es.date
            OR a.date = DATE_ADD(`es`.`date`, INTERVAL 1 DAY)
        )
    ", 'left', false);

        $builder1->where('es.date >=', $start_date);
        $builder1->where('es.date <=', $end_date);
        $builder1->where('e.division_id', $division_id);
        $builder1->whereIn('e.employee_status_id', [1, 2]);

        if (!empty($plant_id)) {
            $builder1->where('e.plant_id', $plant_id);
        }

        if (!empty($employee_group_id)) {
            $builder1->where('e.employee_group_id', $employee_group_id);
        }

        $builder1->groupBy('e.id, es.date');

        $sql1 = $builder1->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | QUERY 2 : OVERTIME TANPA SCHEDULE
    |--------------------------------------------------------------------------
    */
        $builder2 = $this->db->table('attendance a');

        $builder2->select("
        e.id AS id,
        e.employee_id,
        e.name,
        d.name AS division,
        p.name AS plant,
        eg.name AS employee_group,
        a.date,

        'H' AS status,
        'OVERTIME' AS source
    ");

        $builder2->join('employee e', 'e.employee_pin = a.pin');
        $builder2->join('division d', 'd.id = e.division_id');
        $builder2->join('plant p', 'p.id = e.plant_id');
        $builder2->join('employee_group eg', 'eg.id = e.employee_group_id');

        // pastikan tidak punya schedule di tanggal itu
        $builder2->join(
            'employee_schedule es',
            'es.employee_id = e.id AND es.date = a.date',
            'left'
        );

        $builder2->where('es.id IS NULL');
        $builder2->where('a.date >=', $start_date);
        $builder2->where('a.date <=', $end_date);
        $builder2->where('e.division_id', $division_id);
        $builder2->whereIn('e.employee_status_id', [1, 2]);

        if (!empty($plant_id)) {
            $builder2->where('e.plant_id', $plant_id);
        }

        if (!empty($employee_group_id)) {
            $builder2->where('e.employee_group_id', $employee_group_id);
        }

        $builder2->groupBy('e.id, a.date');

        $sql2 = $builder2->getCompiledSelect();


        /*
    |--------------------------------------------------------------------------
    | FINAL UNION
    |--------------------------------------------------------------------------
    */
        $finalSql = $sql1 . " UNION ALL " . $sql2 . "
                   ORDER BY name ASC, date ASC";

        return $this->db->query($finalSql)->getResultObject();
    }


    public function absentMonthlyDepartment(
        $start_date,
        $end_date,
        $division_id,
        $plant_id = null,
        $employee_group_id = null
    ) {
        $builder = $this->db->table('absent a');

        $builder->select([
            'e.id AS id',
            'a.date',
            'a.end_date',
            'at.slug'
        ]);

        $builder->join('employee e', 'e.id = a.employee_id');
        $builder->join('absent_type at', 'at.id = a.absent_type_id');

        // hanya status yang kita pakai
        $builder->whereIn('at.slug', ['alpa', 'sakit', 'ijin', 'terlambat']);

        // filter range period
        $builder->where('a.date <=', $end_date);
        $builder->where('a.end_date >=', $start_date);

        // filter employee
        $builder->where('e.division_id', $division_id);

        if ($plant_id) {
            $builder->where('e.plant_id', $plant_id);
        }

        if ($employee_group_id) {
            $builder->where('e.employee_group_id', $employee_group_id);
        }

        $builder->whereIn('e.employee_status_id', [1, 2]); // active

        return $builder->get()->getResultObject();
    }

    //baru report departemen
    public function getAttendanceRaw($start_date, $end_date, $division_id, $plant_id = null, $employee_group_id = null)
    {
        $builder = $this->db->table('attendance a');

        $builder->select("
        e.id as id,
        e.employee_id as employee_id,
        e.name,

        a.date,
        a.time,
        a.pin,

        es.working_days_id,
        wd.day,
        wd.shift_name,

        wh.start_scan_in,
        wh.end_scan_in,
        wh.start_scan_out,
        wh.end_scan_out,
        wh.clock_out,

        e.division_id,
        e.plant_id,
        e.employee_group_id,

        d.name as division,
        p.name as plant,
        eg.name as employee_group
    ");

        $builder->join('employee e', 'e.employee_pin = a.pin');

        $builder->join('employee_schedule es', '
        es.employee_id = e.id 
        AND es.date = a.date
    ', 'left');

        $builder->join('working_days wd', 'wd.id = es.working_days_id', 'left');
        $builder->join('working_hours wh', 'wh.id = wd.working_hours_id', 'left');
        $builder->join('division d', 'd.id = e.division_id');
        $builder->join('plant p', 'p.id = e.plant_id');
        $builder->join('employee_group eg', 'eg.id = e.employee_group_id');

        $builder->where('a.date >=', $start_date);
        $builder->where('a.date <=', $end_date);

        $builder->whereIn('e.employee_status_id', [1, 2]);
        $builder->where('e.division_id', $division_id);

        if (!empty($plant_id)) {
            $builder->where('e.plant_id', $plant_id);
        }

        if (!empty($employee_group_id)) {
            $builder->where('e.employee_group_id', $employee_group_id);
        }

        $builder->orderBy('e.id');
        $builder->orderBy('a.date');
        $builder->orderBy('a.time');

        return $builder->get()->getResultObject();
    }
    //end baru

    public function employeeLateToday($today, $division_id = null)
    {
        $builder = $this->db->table('employee_late')
            ->select('
            employee_late.id as id,
            employee.name as name,
            employee.employee_pin,
            division.name AS division_name,
            employee_late.late_hour,
            entry_time,
            information,
            employee_late.date as date,
            employee_late.created_at,
            employee_late.updated_at
        ')
            ->join('employee', 'employee.employee_pin = employee_late.employee_pin', 'left')
            ->join('division', 'division.id = employee.division_id', 'left')
            ->where('employee_late.date', $today);

        // filter divisi kalau ada
        if ($division_id) {
            $builder->where('employee.division_id', $division_id);
        }

        return $builder
            ->orderBy('employee_late.late_hour', 'ASC')
            ->get()
            ->getResultObject();
    }

    public function presentEmployeeToday($today)
    {
        return $this->db->table('attendance a')
            ->select('
            e.id,
            e.name,
            e.employee_id,
            d.name as division,
            p.name as plant,
            eg.name as employee_group,
            e.employee_pin as employee_pin,
            d.name AS division_name,
            a.datetime,
            MIN(a.time) AS time_in
        ')
            ->join('employee e', 'e.employee_pin = a.pin', 'left')
            ->join('division d', 'd.id = e.division_id', 'left')
            ->join('plant p', 'p.id = e.plant_id', 'left')
            ->join('employee_group eg', 'eg.id = e.employee_group_id', 'left')
            ->where('a.date', $today)
            ->where('a.deleted_at', null)
            ->groupBy('a.pin')
            ->orderBy('time_in', 'ASC')
            ->get()
            ->getResultObject();
    }

    public function presentEmployeeAbsent($today, $absent_type_id)
    {
        return $this->db->table('absent a')
            ->select('
            e.id AS employee_id,
            e.id AS employee_pin,
            e.name AS name,
            e.employee_id AS employee_id,
            d.name AS division,
            p.name AS plant,
            eg.name AS employee_group,
            a.absent_type_id,
            a.date as datetime
        ')
            ->join('employee e', 'e.id = a.employee_id', 'left')
            ->join('division d', 'd.id = e.division_id', 'left')
            ->join('plant p', 'p.id = e.plant_id', 'left')
            ->join('employee_group eg', 'eg.id = e.employee_group_id', 'left')
            ->join('absent_type at', 'at.id = a.absent_type_id', 'left')
            ->where('a.date', $today)
            ->where('a.deleted_at', null)
            ->where('a.absent_type_id', $absent_type_id)
            ->orderBy('e.name', 'ASC')
            ->get()
            ->getResultObject();
    }

    public function getAttendanceMonthlyEmployee($month, $year, $employeeId)
    {
        $startDate = date("$year-$month-01");
        $endDate   = date("Y-m-t", strtotime($startDate));

        return $this->table('attendance a')
            ->select('a.*, e.name')
            ->join('employee e', 'e.employee_pin = a.pin')
            ->where('e.id', $employeeId)
            ->where('a.date >=', $startDate)
            ->where('a.date <=', $endDate)
            ->orderBy('a.date', 'ASC')
            ->get()
            ->getResultObject();
    }
}
