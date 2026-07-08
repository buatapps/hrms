<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeModel extends Model
{
    protected $table            = 'overtime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'date', 'jobdesk', 'start_time', 'end_time', 'total_hours'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataOvertime($plant_id, $employee_group_id)
    {
        $builder = $this->db->table('overtime');
        $builder->select('*, overtime.id as id, overtime.created_at, overtime.updated_at');
        $builder->join('data_employee', 'data_employee.id = overtime.employee_id');
        if ($plant_id != 0) {
            $builder->where('plant_id', $plant_id);
        }
        if ($employee_group_id != 0) {
            $builder->where('employee_group_id', $employee_group_id);
        }
        $builder->where('overtime.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function getOvertimeByEmployeeAndDate($employee_id, $date)
    {
        return $this->db->table('overtime')
            ->select('total_hours, jobdesk') // sesuaikan field-nya
            ->where('overtime.employee_id', $employee_id)
            ->where('overtime.date', $date)
            ->get()
            ->getRow(); // hanya satu record per hari
    }
}
