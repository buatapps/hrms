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
                        <li class="breadcrumb-item"><a href="<?= base_url('contract/employee/' . $employee_id); ?>">Contract</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title . ' - ' . $employee->name; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">

                    <form class="needs-validation" novalidate action="<?= base_url('contract/save_employee'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <input type="hidden" name="employee_id" value="<?= $employee_id; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contract</label>
                                <select name="contract" class="form-control">
                                    <option value="KONTRAK 1">KONTRAK 1</option>
                                    <option value="KONTRAK 2">KONTRAK 2</option>
                                    <option value="KONTRAK 3">KONTRAK 3</option>
                                    <option value="KONTRAK 4">KONTRAK 4</option>
                                    <option value="KONTRAK 5">KONTRAK 5</option>
                                    <option value="KONTRAK 6">KONTRAK 6</option>
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