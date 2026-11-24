<?php

namespace App\Models;

use CodeIgniter\Model;

class IdcardModel extends Model
{
    protected $table      = 'data_employee';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getEmployees($id = null, array $filters = [])
    {
        $builder = $this->db->table('data_employee de');
        $builder->select('de.id, de.employee_id, de.name, de.division, de.position, emp.picture');
        $builder->join('employee emp', 'emp.id = de.id AND emp.deleted_at IS NULL', 'left');
        $builder->where('de.employee_status_id !=', 3);

        if ($id !== null) {
            $builder->where('de.id', $id);
        }

        if (!empty($filters['division_id'])) {
            $builder->where('de.division_id', $filters['division_id']);
        }

        if (!empty($filters['plant_id'])) {
            $builder->where('de.plant_id', $filters['plant_id']);
        }

        if (!empty($filters['employee_group_id'])) {
            $builder->where('de.employee_group_id', $filters['employee_group_id']);
        }

        $builder->orderBy('de.name', 'ASC');

        return $builder->get()->getResultArray();
    }
}
