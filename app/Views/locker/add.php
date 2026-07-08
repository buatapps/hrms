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
                        <li class="breadcrumb-item"><a href="<?= base_url('locker'); ?>">Locker</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('locker/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom03">Locker Code</label>
                                <input type="text" class="form-control <?= (validation_show_error('locker_code')) ? 'is-invalid' : ''; ?>" id="locker_code" name="locker_code" value="<?= old('locker_code'); ?>" autofocus required>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('locker_code') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Key Number</label>
                                <input type="text" class="form-control" name="key_number" value="<?= old('key_number'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <textarea name="location" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remark</label>
                                <textarea name="remark" class="form-control"></textarea>
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