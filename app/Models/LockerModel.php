<?php

namespace App\Models;

use CodeIgniter\Model;

class LockerModel extends Model
{
    protected $table            = 'locker';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['locker_code', 'key_number', 'location', 'remark', 'is_active'];

    // Dates
    protected $useTimestamps = false;
}
