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
                        <li class="breadcrumb-item"><a href="<?= base_url('attendance'); ?>">Attendance</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('attendance/save_absent'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <input type="hidden" class="form-control" name="employee_id" value="<?= old('id', $employee->id); ?>" required>
                                <input type="hidden" class="form-control" name="employee_pin" value="<?= old('id', $employee->employee_pin); ?>" required>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= old('name', $employee->name); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?= old('date', $date); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" value="<?= old('end_date', $date); ?>" required>
                                </div>


                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Absent Type</label>
                                    <select name="absent_type_id" class="form-control">
                                        <?php foreach ($absent as $row) { ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Late Hour</label>
                                    <input type="time" name="late_hour" class="form-control" value="<?= old('late_hour'); ?>">
                                    <p class="text-muted">*if employee late</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Information</label>
                                    <textarea name="information" class="form-control" style="height: 130px;" placeholder="keterangan status / keterangan waktu"></textarea>
                                </div>

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