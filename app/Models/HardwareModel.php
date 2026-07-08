<?php

namespace App\Models;

use CodeIgniter\Model;

class HardwareModel extends Model
{
    protected $table            = 'hardware';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'kode_asset',
        'name',
        'hardware_category_id',
        'hardware_brand_id',
        'tipe',
        'serial_number',
        'spesifikasi',
        'lokasi',
        'pengguna',
        'status',
        'tgl_perolehan',
        'foto',
        'keterangan',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function dataHardware($hardware_category_id)
    {
        $builder = $this->db->table('hardware');
        $builder->select('*, hardware.id as id, hardware.name as name, hardware_category.name as hardware_category, hardware_brand.name as hardware_brand, hardware.created_at, hardware.updated_at');
        $builder->join('hardware_category', 'hardware_category.id = hardware.hardware_category_id');
        $builder->join('hardware_brand', 'hardware_brand.id = hardware.hardware_brand_id');
        if ($hardware_category_id != 0) {
            $builder->where('hardware.hardware_category_id', $hardware_category_id);
        }
        $builder->where('hardware.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }
}
