<?php

namespace App\Models;

use CodeIgniter\Model;

class NetworkModel extends Model
{
    protected $table            = 'network';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields = [
        'kode_asset',
        'name',
        'tipe',
        'ip_address',
        'mac_address',
        'lokasi',
        'pengguna',
        'status',
        'keterangan',
        'lampiran',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
