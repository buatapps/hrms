<?php

namespace App\Models;

use CodeIgniter\Model;

class LogHistoryAbsentModel extends Model
{
    protected $table = 'log_absent'; // sementara 1 dulu
    protected $allowedFields = [
        'absent_id',
        'employee_id',
        'date',
        'status_before',
        'status_after',
        'changed_by',
        'created_at'
    ];

    public function insertLog($data)
    {
        return $this->insert($data);
    }

    public function logabsent($start_date, $end_date, $employee_id = null)
    {
        $builder = $this->db->table('log_absent');
        $builder->select('
        log_absent.*,
        e.name, e.employee_id,
        d.name as division,
        p.name as plant,
        g.name as group,
        at1.name as from,
        at2.name as to,
        users.username
    ');

        $builder->join('employee e', 'e.id = log_absent.employee_id');
        $builder->join('division d', 'd.id = e.division_id');
        $builder->join('plant p', 'p.id = e.plant_id');
        $builder->join('employee_group g', 'g.id = e.employee_group_id');
        $builder->join('absent_type at1', 'at1.id = status_before', 'left');
        $builder->join('absent_type at2', 'at2.id = status_after', 'left');
        $builder->join('users', 'users.id = log_absent.changed_by');

        // 🔥 filter tanggal (WAJIB ADA)
        $builder->where('DATE(log_absent.created_at) >=', $start_date);
        $builder->where('DATE(log_absent.created_at) <=', $end_date);

        // 🔥 filter employee (OPTIONAL)
        if (!empty($employee_id)) {
            $builder->where('log_absent.employee_id', $employee_id);
        }

        // 🔥 urutan terbaru dulu
        $builder->orderBy('log_absent.created_at', 'DESC');

        $query = $builder->get();
        return $query->getResultObject();
    }
}
