<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeHeaderModel extends Model
{
    protected $table            = 'overtime_header_form';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['date', 'status', 'created_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function dataForm($division_id)
    {
        $builder = $this->db->table('overtime_header_form');
        $builder->select('*, overtime_header_form.id, overtime_header_form.status, count(overtime_detail_form.id) as total_employee');
        $builder->join('users', 'users.id = overtime_header_form.created_by');
        $builder->join('overtime_detail_form', 'overtime_detail_form.header_id = overtime_header_form.id');
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $builder->groupBy('overtime_header_form.id');
        $query = $builder->get();
        return $query->getResultObject();
    }
}
