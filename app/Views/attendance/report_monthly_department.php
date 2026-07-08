<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<style>
    .filter-scroll {
        overflow-x: auto;
        width: 100%;
    }

    .card-body {
        overflow-x: hidden;
        /* MATIKAN scroll di sini */
    }

    .dt-responsive {
        overflow-x: visible !important;
    }

    table {
        white-space: nowrap;
        width: max-content;
        min-width: 100%;
    }
</style>
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
                    <form action="<?= base_url('attendance/searchreportmonyhlydepartment'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input
                                        type="date"
                                        name="start_date"
                                        class="form-control"
                                        value="<?= esc($start_date) ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input
                                        type="date"
                                        name="end_date"
                                        class="form-control"
                                        value="<?= esc($end_date) ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select name="division_id" class="form-control select2">
                                        <?php foreach ($division as $row): ?>
                                            <option value="<?= $row->id ?>" <?= ($row->id == $division_id) ? 'selected' : '' ?>>
                                                <?= $row->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select name="plant_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php foreach ($plant as $row): ?>
                                            <option value="<?= $row->id ?>" <?= ($row->id == $plant_id) ? 'selected' : '' ?>>
                                                <?= $row->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Group</label>
                                    <select name="employee_group_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php foreach ($group as $row): ?>
                                            <option value="<?= $row->id ?>" <?= ($row->id == $employee_group_id) ? 'selected' : '' ?>>
                                                <?= $row->name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-light py-2 mb-3">
                        <strong>Periode:</strong> <?= esc($periode_label) ?>
                    </div>
                    <form action="<?= base_url('attendance/export_report_monthly_department'); ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="start_date" value="<?= esc($start_date) ?>">
                        <input type="hidden" name="end_date" value="<?= esc($end_date) ?>">
                        <input type="hidden" name="division_id" value="<?= esc($division_id) ?>">
                        <input type="hidden" name="plant_id" value="<?= esc($plant_id) ?>">
                        <input type="hidden" name="employee_group_id" value="<?= esc($employee_group_id) ?>">

                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-file-excel"></i> Export Excel
                        </button>
                    </form>
                    <div class="filter-scroll">
                        <table class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Division</th>
                                    <th>Plant</th>
                                    <th>Group</th>

                                    <?php foreach ($period as $date): ?>
                                        <th colspan="2" class="text-center"><?= $date->format('j M y') ?></th>
                                    <?php endforeach; ?>
                                    <th>Overtime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($employees as $emp): ?>
                                    <?php
                                    $totalOvertimeMinutes = 0;
                                    ?>
                                    <tr>
                                        <td rowspan="2"><?= $no++ ?></td>
                                        <td rowspan="2"><?= $emp->employee_id ?></td>
                                        <td rowspan="2"><?= strtoupper($emp->name) ?></td>
                                        <td rowspan="2"><?= $emp->division ?></td>
                                        <td rowspan="2"><?= $emp->plant ?></td>
                                        <td rowspan="2"><?= $emp->employee_group ?></td>

                                        <?php foreach ($period as $date): ?>
                                            <?php
                                            $tgl = $date->format('Y-m-d');

                                            $in  = $scanMap[$emp->id][$tgl]['in'] ?? '-';
                                            $out = $scanMap[$emp->id][$tgl]['out'] ?? '-';
                                            $ot  = $scanMap[$emp->id][$tgl]['overtime'] ?? '0.00';

                                            if ($ot != '0.00') {

                                                [$jam, $menit] = explode('.', $ot);

                                                $totalOvertimeMinutes +=
                                                    ((int)$jam * 60) + (int)$menit;
                                            }
                                            ?>
                                            <td><?= $in ?></td>
                                            <td><?= $out ?></td>
                                        <?php endforeach; ?>

                                        <?php
                                        $totalJam   = floor($totalOvertimeMinutes / 60);
                                        $totalMenit = $totalOvertimeMinutes % 60;

                                        $totalOT = $totalJam . '.' . str_pad($totalMenit, 2, '0', STR_PAD_LEFT);
                                        ?>
                                        <td rowspan="2"><?= $totalOT ?></td>
                                    </tr>

                                    <tr>
                                        <?php foreach ($period as $date): ?>
                                            <?php
                                            $tgl = $date->format('Y-m-d');
                                            $ot  = $scanMap[$emp->id][$tgl]['overtime'] ?? '0.00';
                                            ?>

                                            <td colspan="2" class="text-center text-danger fw-bold">
                                                <?= $ot != '0.00' ? $ot : '-' ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>