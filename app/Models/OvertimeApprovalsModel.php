<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeApprovalsModel extends Model
{
    protected $table = 'overtime_approvals';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'overtime_id',
        'level',
        'approver_id',
        'status',
        'approved_at',
        'note'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
