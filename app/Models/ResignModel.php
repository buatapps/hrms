<?php

namespace App\Models;

use CodeIgniter\Model;

class ResignModel extends Model
{
    protected $table            = 'resign';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'resign_date', 'reason', 'notes'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataResign($division_id)
    {
        $builder = $this->db->table('resign');
        $builder->select('resign.*, data_employee.name, data_employee.division');
        $builder->join('data_employee', 'data_employee.id = resign.employee_id');
        $builder->where('resign.deleted_at', null);
        if (!empty($division_id)) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query->getResultObject();
    }
}
