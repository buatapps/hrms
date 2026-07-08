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

                    <form class="needs-validation" novalidate action="<?= base_url('locker_history/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="transaction_date" value="<?= old('transaction_date', date('Y-m-d')); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Locker</label>
                                <select name="locker_id" class="form-control select2" data-toggle="select2">
                                    <?php foreach ($locker as $lock) { ?>
                                        <option value="<?= $lock->id; ?>"><?= $lock->locker_code; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Employee</label>
                                <select name="employee_id" class="form-control select2" data-toggle="select2">
                                    <option value="">&nbsp;</option>
                                    <?php foreach ($employee as $emp) { ?>
                                        <option value="<?= $emp->id; ?>"><?= $emp->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Event</label>
                                <select name="event" class="form-control">
                                    <option value="use">Use</option>
                                    <option value="returned">Returned</option>
                                    <option value="broken">Broken</option>
                                    <option value="lost_key">Lost Key</option>
                                    <option value="replace_key">Replace Key</option>
                                </select>
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