<?php

namespace App\Models;

use CodeIgniter\Model;

class LogHistoryModel extends Model
{
    protected $table = 'log_plant_group'; // sementara 1 dulu
    protected $allowedFields = [
        'employee_id',
        'old_plant_id',
        'old_group_id',
        'new_plant_id',
        'new_group_id',
        'changed_by',
        'created_at'
    ];

    public function insertLog($data)
    {
        return $this->insert($data);
    }

    public function logplantgroup($start_date, $end_date, $employee_id = null)
    {
        $builder = $this->db->table('log_plant_group');
        $builder->select('
        log_plant_group.*,
        e.name, e.employee_id,
        d.name as division,
        p1.name as old_plant,
        p2.name as new_plant,
        g1.name as old_group,
        g2.name as new_group,
        users.username
    ');

        $builder->join('employee e', 'e.id = log_plant_group.employee_id');
        $builder->join('division d', 'd.id = e.division_id');
        $builder->join('plant p1', 'p1.id = log_plant_group.old_plant_id', 'left');
        $builder->join('plant p2', 'p2.id = log_plant_group.new_plant_id', 'left');
        $builder->join('employee_group g1', 'g1.id = log_plant_group.old_group_id', 'left');
        $builder->join('employee_group g2', 'g2.id = log_plant_group.new_group_id', 'left');
        $builder->join('users', 'users.id = log_plant_group.changed_by');

        // 🔥 filter tanggal (WAJIB ADA)
        $builder->where('DATE(log_plant_group.created_at) >=', $start_date);
        $builder->where('DATE(log_plant_group.created_at) <=', $end_date);

        // 🔥 filter employee (OPTIONAL)
        if (!empty($employee_id)) {
            $builder->where('log_plant_group.employee_id', $employee_id);
        }

        // 🔥 urutan terbaru dulu
        $builder->orderBy('log_plant_group.created_at', 'DESC');

        $query = $builder->get();
        return $query->getResultObject();
    }
}
