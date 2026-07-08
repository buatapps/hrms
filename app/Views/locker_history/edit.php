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
                        <li class="breadcrumb-item"><a href="<?= base_url('locker_history'); ?>">Locker History</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('locker_history/update/' . $list_data->id); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="transaction_date" value="<?= old('transaction_date', $list_data->transaction_date); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Locker</label>
                                <select name="locker_id" class="form-control select2" data-toggle="select2">
                                    <?php foreach ($locker as $lock) { ?>
                                        <option value="<?= $lock->id; ?>" <?= ($list_data->locker_id == $lock->id) ? 'selected' : '' ?>><?= $lock->locker_code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Employee</label>
                                <select name="locker_id" class="form-control select2" data-toggle="select2">
                                    <?php foreach ($employee as $emp) { ?>
                                        <option value="<?= $emp->id; ?>" <?= ($list_data->employee_id == $emp->id) ? 'selected' : '' ?>><?= $emp->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Event</label>
                                <select name="event" class="form-control">
                                    <option value="use" <?= ($list_data->event == 'use') ? 'selected' : '' ?>>Use</option>
                                    <option value="returned" <?= ($list_data->event == 'returned') ? 'selected' : '' ?>>Returned</option>
                                    <option value="broken" <?= ($list_data->event == 'broken') ? 'selected' : '' ?>>Broken</option>
                                    <option value="lost_key" <?= ($list_data->event == 'lost_key') ? 'selected' : '' ?>>Lost Key</option>
                                    <option value="replace_key" <?= ($list_data->event == 'replace_key') ? 'selected' : '' ?>>Replace Key</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remark</label>
                                <textarea name="remark" class="form-control"><?= $list_data->remark; ?></textarea>
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