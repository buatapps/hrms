<?php

namespace App\Models;

use CodeIgniter\Model;

class OvertimeCategoriesModel extends Model
{
    protected $table = 'overtime_categories';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'name',
        'description',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
