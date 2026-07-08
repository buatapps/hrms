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
                    <div class="row mb-2">
                        <div class="col-xl-10 col-sm-12">
                            <form action="<?= base_url('attendance/search'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="mb-0">
                                    <div class="row">
                                        <div class="col-xl-2 col-sm-12">
                                            <label for="" class="form-label">Attendance Machine</label>
                                            <select name="attendance_machine_id" class="form-control">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($attendance_machine as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $attendance_machine_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-sm-12">
                                            <label for="" class="form-label">Date</label>
                                            <input type="date" class="form-control" value="<?= $dates; ?>" name="date">
                                        </div>
                                        <div class="col-xl-2 col-sm-12">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary form-control">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end col-->
                        <div class="col-xl-2 col-sm-12">
                            <div class="mb-0">
                                <div class="row">
                                    <div class="col-xl-12 col-sm-12">
                                        <label for="" class="form-label">&nbsp;</label>
                                        <a href="<?= base_url('attendance/not_absent/' . $dates); ?>" class="btn btn-outline-danger form-control"><?= date('d/m/Y', strtotime($dates)); ?> Not Absent</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Attendance Machine</th>
                            <th>PIN</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Division</th>
                            <th>Plant</th>
                            <th>datetime</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($list_data as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row->attendance_machine; ?></td>
                                <td><?= $row->pin; ?></td>
                                <td><?= strtoupper($row->name); ?></td>
                                <td><?= $row->employee_id; ?></td>
                                <td><?= $row->division; ?></td>
                                <td><?= $row->plant; ?></td>
                                <td><?= $row->datetime; ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($row->created_at)); ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($row->updated_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<!-- container -->
<?= $this->endSection() ?>