<?php

namespace App\Models;

use CodeIgniter\Model;

class SoftwareModel extends Model
{
    protected $table            = 'software';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'kode_asset',
        'name',
        'license_type',
        'platform',
        'versi',
        'vendor',
        'tgl_instal',
        'tgl_expired',
        'license_key',
        'jumlah_lisensi',
        'lokasi',
        'pengguna',
        'keterangan',
        'status',
        'lampiran',
    ];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
