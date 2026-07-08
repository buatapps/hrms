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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee/resign'); ?>">Resign</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('employee/resign_update/' . $list_data->id); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Employee</label>
                                <input type="text" class="form-control" value="<?= $list_data->name; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Resign Date</label>
                                <input type="date" name="resign_date" class="form-control" value="<?= $list_data->resign_date; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason</label>
                                <textarea name="reason" class="form-control"><?= $list_data->reason; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control"><?= $list_data->notes; ?></textarea>
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