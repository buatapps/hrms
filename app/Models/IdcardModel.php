<?php

namespace App\Models;

use CodeIgniter\Model;

class IdcardModel extends Model
{
    protected $table      = 'data_employee';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getEmployees($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, employee_id, name, division');
        $builder->where('employee_status_id !=', 3);

        if ($id !== null) {
            $builder->where('id', $id);
        }

        $builder->orderBy('name', 'ASC');

        return $builder->get()->getResultArray();
    }
}
