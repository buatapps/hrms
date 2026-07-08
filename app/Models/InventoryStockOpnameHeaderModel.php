<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryStockOpnameHeaderModel extends Model
{
    protected $table            = 'inventory_stock_opname_headers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['year_month', 'created_by', 'created_at', 'updated_at'];


    // Dates
    protected $useTimestamps    = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
