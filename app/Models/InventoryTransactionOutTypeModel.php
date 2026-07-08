<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryTransactionOutTypeModel extends Model
{
    protected $table            = 'inventory_transaction_out_types';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['code', 'name', 'impact_column'];
    public $timestamps          = false;
}
