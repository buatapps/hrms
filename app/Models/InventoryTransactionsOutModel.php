<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryTransactionsOutModel extends Model
{
    protected $table            = 'inventory_transactions_out';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['tanggal', 'item_id', 'type_id', 'quantity', 'keterangan'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function withRelations()
    {
        return $this->select('
                inventory_transactions_out.*,
                inventory_items.name as item_name,
                inventory_transaction_out_types.name as type_name
            ')
            ->join('inventory_items', 'inventory_items.id = inventory_transactions_out.item_id')
            ->join('inventory_transaction_out_types', 'inventory_transaction_out_types.id = inventory_transactions_out.type_id');
    }
}
