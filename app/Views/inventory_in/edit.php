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
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory_in'); ?>">Inventory Transactions In</a></li>
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
                    <form class="needs-validation" novalidate action="<?= base_url('inventory_in/update'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-4">
                            <input type="hidden" class="form-control" name="id" value="<?= $list_data->id; ?>">

                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $list_data->tanggal; ?>" autofocus required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Items</label>
                                <select name="item_id" class="form-control">
                                    <?php foreach ($items as $row): ?>
                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->item_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="<?= $list_data->quantity; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="keterangan" class="form-control"><?= $list_data->keterangan; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>