<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
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

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <p>Date : <?= $thistoday; ?>
                    <p><strong>Shift:</strong> <?= esc($shift_name) ?></p>
                    <p><strong>Plant:</strong> <?= esc($plant_name) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Employee Absent</h5>
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Employee ID</td>
                                <td>Name</td>
                                <td>Division</td>
                                <td>Plant</td>
                                <td>Group</td>
                                <td>Absent</td>
                                <td>Information</td>
                            </tr>
                        </thead>
                        <?php if (!empty($absentList)) : ?>
                            <?php $no = 1;
                            foreach ($absentList as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->employee_id; ?></td>
                                    <td><?= strtoupper($row->name); ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td>
                                        <?php if (!empty($row->absent_type_id)) : ?>
                                            <span class="badge bg-warning">
                                                <?= $row->absent_type_name; ?>
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">
                                                Absent
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $row->information ?? 'No attendance record'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3">No absent 🎉</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>