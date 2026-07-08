<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkingHoursModel extends Model
{
    protected $table            = 'working_hours';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['name', 'slug', 'entry_time', 'clock_out', 'start_scan_in', 'end_scan_in', 'start_scan_out', 'end_scan_out'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
