<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class InventoryStock extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $yearMonth = $this->request->getPost('year_month') ?? date('Y-m');
        $itemId    = $this->request->getPost('item_id');

        $builderSnapshot = $this->db->table('inventory_snapshots')
            ->select('*')
            ->where('year_month', $yearMonth);

        $subQuery = $builderSnapshot->getCompiledSelect();

        $builder = $this->InventoryItemsModel
            ->select('
        inventory_items.id,
        inventory_items.code,
        inventory_items.name,
        COALESCE(snapshot.stock_in, 0) AS stock_in,
        COALESCE(snapshot.stock_out, 0) AS stock_out,
        COALESCE(snapshot.stock_broken, 0) AS stock_broken,
        COALESCE(snapshot.stock_lost, 0) AS stock_lost,
        COALESCE(snapshot.stock_opname, 0) AS stock_opname,
        COALESCE(snapshot.stock_akhir, 0) AS stock_akhir,
        COALESCE(snapshot.final_stock, 0) AS final_stock
    ')
            ->join("($subQuery) AS snapshot", 'snapshot.item_id = inventory_items.id', 'left', false);

        if ($itemId) {
            $builder->where('inventory_items.id', $itemId);
        }

        $listData = $builder->orderBy('inventory_items.name', 'ASC')->findAll();

        $data = [
            'title'      => 'Inventory Stock',
            'list_data'  => $listData,
            'year_month' => $yearMonth,
            'item_id'    => $itemId,
            'items'      => $this->InventoryItemsModel->orderBy('name')->findAll(),
        ];

        return view('inventory_stock/index', $data);
    }
}
