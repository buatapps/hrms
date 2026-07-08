<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeDetailModel extends Model
{
    protected $table            = 'overtime_detail_form';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['header_id', 'employee_id', 'jobdesk', 'total_hours'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
