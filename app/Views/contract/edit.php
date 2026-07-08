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
                        <li class="breadcrumb-item"><a href="<?= base_url('contract'); ?>">Contract</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('contract/update'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <input type="hidden" name="id" value="<?= $list_data[0]->id; ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Employee</label>
                                <select name="employee_id" class="form-control" disabled>
                                    <?php foreach ($employee as $row): ?>
                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data[0]->employee_id ? 'selected' : '') ?>><?= strtoupper($row->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contract</label>
                                <select name="contract_type_id" class="form-control">
                                    <?php foreach ($contract_type as $row) { ?>
                                        <option value="<?= $row->id ?>" <?= ($row->id == $list_data[0]->id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                    <?php } ?>
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
                                <select name="contract_statuses_id" class="form-control">
                                    <?php foreach ($contract_statuses as $row2) { ?>
                                        <option value="<?= $row2->id; ?>" <?= ($row2->id == $list_data[0]->contract_statuses_id ? 'selected' : ''); ?>><?= $row2->code; ?></option>
                                    <?php } ?>

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