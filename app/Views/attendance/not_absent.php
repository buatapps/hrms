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
        <div class="card">
            <div class="card-body">
                Date : <?= date('d/m/Y', strtotime($date)); ?>
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
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Divison</th>
                            <th>Position</th>
                            <th>Plant</th>
                            <th>Group</th>
                            <th>Shift</th>
                            <th>Entry Time</th>
                            <th>Form</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($list_data as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row->name; ?></td>
                                <td><?= $row->employee_id; ?></td>
                                <td><?= $row->division; ?></td>
                                <td><?= $row->position; ?></td>
                                <td><?= $row->plant; ?></td>
                                <td><?= $row->employee_group; ?></td>
                                <td><?= $row->shift_name; ?></td>
                                <td><?= $row->entry_time; ?></td>
                                <td>
                                    <a href="<?= base_url('attendance/form_absent/' . $row->id); ?>" class="btn btn-success btn-sm">Create Form</a>
                                </td>
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