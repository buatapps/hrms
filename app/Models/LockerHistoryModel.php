<?php

namespace App\Models;

use CodeIgniter\Model;

class LockerHistoryModel extends Model
{
    protected $table      = 'locker_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';

    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'locker_id',
        'employee_id',
        'transaction_date',
        'event',
        'remark',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    public function DataLockerHistory()
    {
        $builder = $this->db->table('locker_history lh');
        $builder->select('
        lh.*,
        l.locker_code,
        l.key_number,
        l.location,
        e.name as employee_name
    ');
        $builder->join('locker l', 'l.id = lh.locker_id');
        $builder->join('employee e', 'e.id = lh.employee_id', 'left');
        $builder->orderBy('lh.id', 'DESC');
        $query = $builder->get();
        return $query->getResultObject();
    }
}
