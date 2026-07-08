<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryTransactionsInModel extends Model
{
    protected $table            = 'inventory_transactions_in';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['item_id', 'quantity', 'tanggal', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function withItems()
    {
        return $this->select('inventory_transactions_in.*, inventory_items.name as item_name')
            ->join('inventory_items', 'inventory_items.id = inventory_transactions_in.item_id');
    }
}
