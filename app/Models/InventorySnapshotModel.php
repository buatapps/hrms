<?php

namespace App\Models;

use CodeIgniter\Model;

class InventorySnapshotModel extends Model
{
    protected $table            = 'inventory_snapshots';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = ['item_id', 'year_month', 'stock_awal', 'stock_in', 'stock_out', 'stock_broken', 'stock_lost', 'stock_akhir', 'stock_opname', 'final_stock', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
