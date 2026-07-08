<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeScheduleModel extends Model
{
    protected $table            = 'employee_schedule';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'employee_pin', 'date', 'working_days_id', 'day'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getScheduleEmployee($id, $start_date, $end_date)
    {
        $sql = "SELECT * FROM employee_schedule JOIN working_days ON working_days.id = employee_schedule.working_days_id WHERE date >= '" . $start_date . "' AND date <= '" . $end_date . "' AND employee_id = " . $id . " ";
        $query = $this->db->query($sql);
        // echo $this->db->getLastQuery();
        return $query->getResultObject();
    }

    public function employeeSchedule($PIN, $date, $day)
    {
        $builder = $this->db->table('employee_schedule');
        $builder->join('working_days', 'working_days.id = employee_schedule.working_days_id', 'left');
        $builder->join('working_hours', 'working_hours.id = working_days.working_hours_id', 'left');
        $builder->where('employee_pin', $PIN);
        $builder->where('date', $date);
        $builder->where('employee_schedule.day', $day);
        $query = $builder->get();
        return $query;
    }
}
