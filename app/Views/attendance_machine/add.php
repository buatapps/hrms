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
                        <li class="breadcrumb-item"><a href="<?= base_url('attendance_machine'); ?>">Attendance Machine</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('attendance_machine/save'); ?>" method="post">
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
                                <label class="form-label" for="validationCustom03">IP</label>
                                <input type="text" class="form-control <?= (validation_show_error('ip')) ? 'is-invalid' : ''; ?>" id="ip" name="ip" value="<?= old('ip'); ?>" required>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('ip') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom03">Key</label>
                                <input type="text" class="form-control" id="key" name="key" value="<?= old('key'); ?>" required>
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