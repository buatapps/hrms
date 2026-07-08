<?php

namespace App\Models;

use CodeIgniter\Model;

class HardwareBrandModel extends Model
{
    protected $table            = 'hardware_brand';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['hardware_category_id', 'name', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBrandWithCategory()
    {
        return $this->db->table('hardware_brand')
            ->select('hardware_brand.*, hardware_category.name as category_name')
            ->join('hardware_category', 'hardware_category.id = hardware_brand.hardware_category_id', 'left')
            ->orderBy('hardware_category.id', 'ASC')
            ->orderBy('hardware_brand.name', 'ASC')
            ->get()
            ->getResultObject();
    }
}
