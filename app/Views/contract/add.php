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
                        <li class="breadcrumb-item"><a href="<?= base_url('contract'); ?>">Contract</a></li>
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
                    <?php if (session('error')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <?= session('danger'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form class="needs-validation" novalidate action="<?= base_url('contract/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Employee</label>
                                <select name="employee_id" class="form-control select2" data-toggle="select2">
                                    <?php foreach ($employee as $row): ?>
                                        <option value="<?= $row->id; ?>"><?= strtoupper($row->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contract</label>
                                <select name="contract_types_id" class="form-control">
                                    <?php foreach ($contractTypes as $row): ?>
                                        <option value="<?= $row->id ?>">
                                            <?= $row->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Division</label>
                                <select name="division_id" class="form-control">
                                    <?php foreach ($division as $row): ?>
                                        <option value="<?= $row->id ?>">
                                            <?= $row->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="<?= old('start_date', date('Y-m-01')); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="<?= old('end_date', $end_date); ?>">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>