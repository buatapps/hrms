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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee'); ?>">Employee</a></li>
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
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <form action="<?= base_url('employee/schedule_save'); ?>" method="post">
                                <div class="mb-0">
                                    <label for="" class="form-label"><?= $employee->name; ?></label>
                                    <input type="hidden" name="id" class="form-control" value="<?= $employee->id; ?>">
                                    <input type="hidden" name="employee_pin" class="form-control" value="<?= $employee->employee_pin; ?>">
                                </div>

                                <div class="col-xl-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-01'); ?>">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-t'); ?>">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Shift</label>
                                        <select name="shift_id" id="" class="form-control">
                                            <?php foreach ($shift as $row): ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <h4>Schedule</h4>
                            <p><?= date('d-M-Y', strtotime($start_date)) . ' - ' . date('d-M-Y', strtotime($end_date)); ?></p>
                            <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Date</td>
                                        <td>Day</td>
                                        <td>Shift</td>
                                        <td>Hours</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($schedule as $row) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= date('d-M-Y', strtotime($row->date)); ?></td>
                                            <td><?= $row->day; ?></td>
                                            <td><?= $row->shift_name; ?></td>
                                            <td><?= $row->working_hours_name; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>