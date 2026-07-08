<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeApprovalModel extends Model
{
    protected $table = 'overtime_approval';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'name'
    ];
}
