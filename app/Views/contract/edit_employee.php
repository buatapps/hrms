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
                        <li class="breadcrumb-item"><a href="<?= base_url('contract/employee/' . $list_data[0]->employee_id); ?>">Contract</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title . ' - ' . $list_data[0]->name; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">

                    <form class="needs-validation" novalidate action="<?= base_url('contract/update_employee'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <input type="hidden" name="id" value="<?= $list_data[0]->id; ?>" class="form-control">
                                <input type="hidden" name="employee_id" value="<?= $list_data[0]->employee_id; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contract</label>
                                <select name="contract" class="form-control">
                                    <option value="KONTRAK 1" <?= ($list_data[0]->contract == 'KONTRAK 1') ? 'selected' : ''  ?>>KONTRAK 1</option>
                                    <option value="KONTRAK 2" <?= ($list_data[0]->contract == 'KONTRAK 2') ? 'selected' : ''  ?>>KONTRAK 2</option>
                                    <option value="KONTRAK 3" <?= ($list_data[0]->contract == 'KONTRAK 3') ? 'selected' : ''  ?>>KONTRAK 3</option>
                                    <option value="KONTRAK 4" <?= ($list_data[0]->contract == 'KONTRAK 4') ? 'selected' : ''  ?>>KONTRAK 4</option>
                                    <option value="KONTRAK 5" <?= ($list_data[0]->contract == 'KONTRAK 5') ? 'selected' : ''  ?>>KONTRAK 5</option>
                                    <option value="KONTRAK 6" <?= ($list_data[0]->contract == 'KONTRAK 6') ? 'selected' : ''  ?>>KONTRAK 6</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" value="<?= old('start_date', $list_data[0]->start_date); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" value="<?= old('end_date', $list_data[0]->end_date); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Active" <?= ($list_data[0]->status == 'Active') ? 'selected' : '' ?>>Active</option>
                                    <option value="Non Active" <?= ($list_data[0]->status == 'Non Active') ? 'selected' : '' ?>>Non Active</option>
                                </select>
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