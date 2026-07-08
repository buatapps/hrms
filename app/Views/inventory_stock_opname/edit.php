<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory_stock_opname'); ?>">Inventory Stock Opname</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (session('error')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-danger" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('error'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('inventory_stock_opname/save/' . $header->id) ?>" method="post">
                        <table class="table table-bordered">
                            <tr>
                                <th>Code</th>
                                <th>Item</th>
                                <th>Stock Sistem</th>
                                <th>Stock Opname / Stok Fisik</th>
                                <th>Selisih</th>
                                <th>Keterangan</th>
                            </tr>
                            <?php foreach ($items as $item):
                                $op = $opnameByItem[$item->id] ?? null;
                                $snapshot = $snapshots[$item->id] ?? null;
                                $finalStock = $snapshot->stock_akhir ?? $item->stock;
                                $stockOpname = $op->stock_opname ?? $item->stock;
                                $selisih = $stockOpname - $finalStock;
                            ?>
                                <tr>
                                    <td><?= $item->code ?></td>
                                    <td><?= $item->name ?></td>
                                    <td class="text-end"><?= $finalStock ?></td>
                                    <td>
                                        <input type="number"
                                            name="stock_opname[<?= $item->id ?>]"
                                            value="<?= $stockOpname ?>"
                                            data-item-id="<?= $item->id ?>"
                                            data-final-stock="<?= $finalStock ?>"
                                            class="form-control input-opname text-end" />
                                    </td>
                                    <td class="text-end">
                                        <span id="selisih-<?= $item->id ?>"><?= $selisih ?></span>
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="keterangan[<?= $item->id ?>]"><?= $op->keterangan ?? '' ?></textarea>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.input-opname').forEach(input => {
        input.addEventListener('input', () => {
            const itemId = input.dataset.itemId;
            const finalStock = parseInt(input.dataset.finalStock);
            const opnameVal = parseInt(input.value) || 0;
            const selisih = opnameVal - finalStock;
            document.getElementById(`selisih-${itemId}`).innerText = selisih;
        });
    });
</script>
<!-- container -->
<?= $this->endSection() ?>