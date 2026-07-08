<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimesModel extends Model
{
    protected $table = 'overtimes';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'overtime_number',
        'overtime_date',
        'division_id',
        'sub_leader_id',
        'shift',
        'employee_group_id',
        'overtime_category_id',
        'current_approval_level',
        'final_status',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    public function getOvertimeDetailsWithAttendance($overtimeId)
    {
        // =========================
        // GET OVERTIME HEADER
        // =========================
        $overtime = $this->db->table('overtimes')
            ->where('id', $overtimeId)
            ->get()
            ->getRow();

        if (!$overtime) {
            return null;
        }

        // =========================
        // GET ITEMS (EMPLOYEE LIST)
        // =========================
        $items = $this->db->table('overtime_items oi')
            ->select('
            oi.id as overtime_items_id,
            oi.employee_id,
            oi.start_time,
            oi.end_time,
            oi.duration_hours,
            oi.task_description,
            oi.not_approve,
            e.name as employee_name,
            e.employee_pin,
            es.working_days_id,
            wd.working_hours_id,
            wh.start_scan_in,
            wh.end_scan_in,
            wh.start_scan_out,
            wh.end_scan_out
        ')
            ->join('employee e', 'e.id = oi.employee_id')
            ->join(
                'employee_schedule es',
                'es.employee_id = oi.employee_id
                    AND es.date = "' . $overtime->overtime_date . '"',
                'left'
            )
            ->join('working_days wd', 'wd.id = es.working_days_id', 'left')
            ->join('working_hours wh', 'wh.id = wd.working_hours_id', 'left')
            ->where('oi.overtime_id', $overtimeId)
            ->where('oi.deleted_at IS NULL', null, false)
            ->get()
            ->getResult();

        // =========================
        // BIG WINDOW ATTENDANCE RANGE
        // =========================
        $startTime = date('Y-m-d 05:00:00', strtotime($overtime->overtime_date));
        $endTime   = date('Y-m-d 23:59:59', strtotime($overtime->overtime_date . ' +1 day'));

        // =========================
        // GET ALL ATTENDANCE (BIG WINDOW)
        // =========================
        $attendances = $this->db->table('attendance')
            ->select('pin, datetime')
            ->where('datetime >=', $startTime)
            ->where('datetime <=', $endTime)
            ->get()
            ->getResult();

        // =========================
        // GROUP ATTENDANCE BY PIN
        // =========================
        $attendanceMap = [];

        foreach ($attendances as $att) {
            $attendanceMap[$att->pin][] = $att->datetime;
        }

        // =========================
        // BUILD RESULT
        // =========================
        foreach ($items as &$item) {

            $pin = $item->employee_pin;
            $times = $attendanceMap[$pin] ?? [];

            $actualStart = null;
            $actualEnd   = null;

            if (!empty($times)) {

                // =========================
                // NORMALIZE TIMES
                // =========================
                $normalizedTimes = array_map(function ($t) {
                    return [
                        'raw'  => $t,
                        'time' => date('H:i:s', strtotime($t)),
                        'ts'   => strtotime($t)
                    ];
                }, $times);

                // =========================
                // ACTUAL START (FIRST SCAN IN RANGE)
                // =========================
                $inTimes = array_filter($normalizedTimes, function ($t) use ($item) {
                    return ($t['time'] >= $item->start_scan_in && $t['time'] <= $item->end_scan_in);
                });

                if (!empty($inTimes)) {
                    $actualStart = min(array_column($inTimes, 'ts'));
                }

                // =========================
                // ACTUAL END (LAST SCAN OUT RANGE)
                // =========================
                $outTimes = array_filter($normalizedTimes, function ($t) use ($item) {

                    if ($item->start_scan_out > $item->end_scan_out) {
                        // CROSS MIDNIGHT
                        return ($t['time'] >= $item->start_scan_out || $t['time'] <= $item->end_scan_out);
                    }

                    return ($t['time'] >= $item->start_scan_out && $t['time'] <= $item->end_scan_out);
                });

                if (!empty($outTimes)) {
                    $actualEnd = max(array_column($outTimes, 'ts'));
                }
            }

            // =========================
            // ATTACH RESULT (SAFE NULL)
            // =========================
            $item->actual_start = $actualStart
                ? date('H:i:s', $actualStart)
                : null;

            $item->actual_end = $actualEnd
                ? date('H:i:s', $actualEnd)
                : null;
        }

        return [
            'overtime' => $overtime,
            'items'    => $items
        ];
    }
}
