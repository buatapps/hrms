<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryStockOpnameModel extends Model
{
    protected $table            = 'inventory_stock_opname';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'header_id',
        'item_id',
        'final_stock',
        'stock_opname',
        'selisih',
        'keterangan',
        'created_at',
        'updated_at',
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
