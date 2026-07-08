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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee/details/' . $id); ?>">Details</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('employee/upload_save/' . $list_data->id); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">KTP:</label>
                                <input type="file" class="form-control" name="ktp">
                                <?php if ($list_data->ktp): ?>
                                    <small>KTP lama: <a href="<?= base_url('employee_picture/' . $list_data->ktp); ?>" target="_blank"><?= $list_data->ktp; ?></a></small>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KK:</label>
                                <input type="file" class="form-control" name="kk">
                                <?php if ($list_data->kk): ?>
                                    <small>KK lama: <a href="<?= base_url('employee_picture/' . $list_data->kk); ?>" target="_blank"><?= $list_data->kk; ?></a></small>
                                <?php endif; ?>
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