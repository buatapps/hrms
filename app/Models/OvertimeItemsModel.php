<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeItemsModel extends Model
{
    protected $table = 'overtime_items';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'overtime_id',
        'employee_id',
        'start_time',
        'end_time',
        'duration_hours',
        'task_description',
        'not_approve'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
