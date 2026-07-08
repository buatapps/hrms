<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
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
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-xl-6 col-sm-12">
                            <form class="needs-validation" novalidate action="<?= base_url('count_food/generate'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-12">
                                            <label for="" class="form-label">Date</label>
                                            <input type="date" class="form-control" value="<?= $date; ?>" name="date">
                                        </div>
                                        <div class="col-xl-3 col-sm-12">
                                            <label for="" class="form-label">Status</label>
                                            <select name="status" id="" class="form-control">
                                                <option value="MAKAN" <?= ($status == 'MAKAN') ? 'selected' : null ?>>MAKAN</option>
                                                <option value="TIDAK MAKAN" <?= ($status == 'TIDAK MAKAN') ? 'selected' : null ?>>TIDAK MAKAN</option>
                                                <option value="PUASA" <?= ($status == 'PUASA') ? 'selected' : null ?>>PUASA</option>
                                                <option value="TIDAK PUASA" <?= ($status == 'TIDAK PUASA') ? 'selected' : null ?>>TIDAK PUASA</option>
                                                <option value="DIET" <?= ($status == 'DIET') ? 'selected' : null ?>>DIET</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-1 col-sm-12">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end col-->
                    </div>
                    <?php if (session('success')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-xl-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>TOTAL : <?= $total; ?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>MAKAN : <?= $countmakan; ?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>TIDAK MAKAN : <?= $counttidakmakan; ?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>PUASA : <?= $countpuasa; ?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>TIDAK PUASA : <?= $counttidakpuasa; ?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-sm-3">
                                    <div class="mb-3">
                                        <h5>DIET : <?= $countdiet; ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-sm-12">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($list_data as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->date; ?></td>
                                            <td><?= $row->name; ?></td>
                                            <td>
                                                <form method="post" action="<?= base_url('count_food/update_status'); ?>">
                                                    <input type="hidden" name="id" value="<?= $row->id; ?>">
                                                    <select name="status" id="dropdown" class="form-control" onchange='if(this.value != 0) { this.form.submit(); }'>
                                                        <option value="MAKAN" <?= ($row->status == 'MAKAN') ? "selected" : null ?>>MAKAN</option>
                                                        <option value="TIDAK MAKAN" <?= ($row->status == 'TIDAK MAKAN') ? "selected" : null ?>>TIDAK MAKAN</option>
                                                        <option value="PUASA" <?= ($row->status == 'PUASA') ? "selected" : null ?>>PUASA</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($row->created_at)); ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($row->updated_at)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>