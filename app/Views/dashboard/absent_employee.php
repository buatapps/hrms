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
                    <p>
                        <strong>Period:</strong>
                        <?= formatTanggalIndo($startDate); ?> - <?= formatTanggalIndo($endDate); ?>
                    </p>

                    <p><strong>Shift:</strong> <?= strtoupper($type); ?></p>

                    <?php if (!empty($plantId)) : ?>
                        <p><strong>Plant: </strong> <?= esc($plantId); ?></p>
                    <?php else: ?>
                        <p><strong>Plant:</strong> ALL</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Employee Absent</h5>
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Division</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Information</th>
                            </tr>
                        </thead>

                        <?php if (!empty($listAbsent)) : ?>
                            <?php $no = 1;
                            foreach ($listAbsent as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->employee_id; ?></td>
                                    <td><?= strtoupper($row->name); ?></td>
                                    <td><?= $row->division ?? '-'; ?></td>
                                    <td><?= $row->plant_id; ?></td>
                                    <td><?= $row->employee_group ?? '-'; ?></td>

                                    <!-- 🔥 NEW: DATE COLUMN -->
                                    <td>
                                        <?= formatTanggalIndo($row->absent_date ?? $startDate); ?>
                                    </td>
                                    <?php
                                    $date = date('Y-m-d', strtotime($row->absent_date ?? $startDate));
                                    $absentRecord = $absentMap[$row->id][$date] ?? null;
                                    ?>
                                    <td>
                                        <?php if ($absentRecord) : ?>
                                            <span class="badge bg-success">
                                                <?= esc($absentRecord->type_name); ?>
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $row->information ?? 'No attendance record'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    No Absent 🎉
                                </td>
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