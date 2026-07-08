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

                    <form class="needs-validation" novalidate action="<?= base_url('attendance/employee_late_save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="mb-3">
                                <input type="hidden" name="id" class="form-control" value="<?= $list_data->id; ?>">
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <select name="employee_id" class="form-control select2" data-toggle="select2">
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $employee_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?= old('date', $list_data->date); ?>" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Late Hour</label>
                                    <input type="time" name="late_hour" class="form-control" value="<?= old('late_hour', $list_data->late_hour); ?>">
                                    <p class="text-muted">*if employee late</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Information</label>
                                    <textarea name="information" class="form-control" style="height: 130px;" placeholder="keterangan status / keterangan waktu"><?= $list_data->information; ?></textarea>
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>