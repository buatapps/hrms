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
                        <li class="breadcrumb-item"><a href="<?= base_url('working_hours'); ?>">Working Hours</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('working_hours/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom03">Name</label>
                                <input type="text" class="form-control <?= (validation_show_error('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name'); ?>" autofocus required>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('name') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Entry Time</label>
                                <input type="time" class="form-control" name="entry_time" value="<?= old('entry_time'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Clock Out</label>
                                <input type="time" class="form-control" name="clock_out" value="<?= old('clock_out'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Scan IN</label>
                                <input type="time" class="form-control" name="start_scan_in" value="<?= old('start_scan_in'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Scan IN</label>
                                <input type="time" class="form-control" name="end_scan_in" value="<?= old('end_scan_in'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Scan OUT</label>
                                <input type="time" class="form-control" name="start_scan_out" value="<?= old('start_scan_out'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Scan OUT</label>
                                <input type="time" class="form-control" name="end_scan_out" value="<?= old('end_scan_out'); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>