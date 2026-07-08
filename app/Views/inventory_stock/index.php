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
                    <form method="post" action="<?= base_url('inventory_stock') ?>" class="row mb-3">
                        <?= csrf_field() ?>
                        <div class="col-xl-2">
                            <label class="form-label">Bulan</label>
                            <input type="month" name="year_month" value="<?= esc($year_month) ?>" class="form-control" required>
                        </div>
                        <div class="col-xl-4">
                            <label class="form-label">Item</label>
                            <select name="item_id" class="form-control select2" data-toggle="select2">
                                <option value="">- Semua Item -</option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?= $item->id ?>" <?= $item_id == $item->id ? 'selected' : '' ?>>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-1 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </form>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Item</th>
                                <th>Stock Awal</th>
                                <th>Stock In</th>
                                <th>Stock Out</th>
                                <th>Stock Broken</th>
                                <th>Stock Lost</th>
                                <th>Stock Opname</th>
                                <th>Final Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row->code) ?></td>
                                    <td><?= esc($row->name) ?></td>
                                    <td class="text-end"><?= $row->stock_akhir ?></td>
                                    <td class="text-end"><?= $row->stock_in ?></td>
                                    <td class="text-end"><?= $row->stock_out ?></td>
                                    <td class="text-end"><?= $row->stock_broken ?></td>
                                    <td class="text-end"><?= $row->stock_lost ?></td>
                                    <td class="text-end"><?= $row->stock_opname ?></td>
                                    <td class="text-end"><?= $row->final_stock ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>