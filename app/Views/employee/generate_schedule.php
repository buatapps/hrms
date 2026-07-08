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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee/schedule'); ?>">Schedule</a></li>
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
                    <?php if (session('success')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form class="needs-validation" novalidate action="<?= base_url('employee/save_generate_schedule'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" value="<?= old('start_date', $start_date); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" value="<?= old('end_date', $end_date); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select name="plant_id" class="form-control">
                                        <option value="">-- All --</option>
                                        <?php foreach ($plant as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Group</label>
                                    <select name="employee_group_id" class="form-control">
                                        <option value="">-- All --</option>
                                        <?php foreach ($group as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Shift</label>
                                    <select name="shift_id" class="form-control">
                                        <?php foreach ($shift as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success"> Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>