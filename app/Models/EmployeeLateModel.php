<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeLateModel extends Model
{
    protected $table            = 'employee_late';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_pin', 'date', 'entry_time', 'late_hour', 'information'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function EmployeeLate($date)
    {
        $builder = $this->db->table('employee_late');
        $builder->select('*, employee_late.id as id, employee_late.created_at, employee_late.updated_at');
        $builder->join('data_employee', 'data_employee.employee_pin = employee_late.employee_pin');
        $builder->where('date', $date);
        $builder->where('employee_late.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function EmployeeLateData($date, $plant_id, $employee_group_id, $division_id)
    {
        $builder = $this->db->table('employee_late');
        $builder->select('*, employee_late.id as id, employee_late.created_at, employee_late.updated_at');
        $builder->join('data_employee', 'data_employee.employee_pin = employee_late.employee_pin');
        $builder->where('date', $date);
        // Hanya ambil karyawan yang aktif (status ID bukan 3 = non-aktif)
        $builder->where('data_employee.employee_status_id !=', 3);
        if ($plant_id != null) {
            $builder->where('data_employee.plant_id', $plant_id);
        }
        if ($employee_group_id != null) {
            $builder->where('data_employee.employee_group_id', $employee_group_id);
        }
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $builder->where('employee_late.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function checkData($date, $employee_pin)
    {
        $builder = $this->db->table('employee_late');
        $builder->where('employee_pin', $employee_pin);
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }
}
