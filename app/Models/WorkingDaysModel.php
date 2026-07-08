<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkingDaysModel extends Model
{
    protected $table            = 'working_days';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['shift_id', 'shift_name', 'working_hours_id', 'working_hours_name', 'day'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function WokingDaysData()
    {
        $builder = $this->db->table('working_days');
        $builder->select('*');
        $builder->where('deleted_at', null);
        $builder->groupBy('shift_id, working_hours_id');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function checkData($shift_id, $working_hours_id)
    {
        $builder = $this->db->table('working_days');
        $builder->where('shift_id', $shift_id);
        $builder->where('working_hours_id', $working_hours_id);
        $builder->where('deleted_at', null);
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function checkDays($shift_id, $working_hours_id, $day)
    {
        $builder = $this->db->table('working_days');
        $builder->where('shift_id', $shift_id);
        $builder->where('working_hours_id', $working_hours_id);
        $builder->where('day', $day);
        $builder->where('deleted_at', null);
        $query = $builder->get();
        return $query->getNumRows();
    }
}
