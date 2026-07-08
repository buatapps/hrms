<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeUploadsModel extends Model
{
    protected $table            = 'employee_uploads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['employee_id', 'category', 'description', 'file_name', 'file_path', 'file_size', 'mime_type', 'uploaded_by'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
