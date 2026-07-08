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
                    <form action="<?= base_url('attendance/search_report_department'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Year</label>
                                    <select name="year" class="form-control select2">
                                        <?php for ($y = date('Y'); $y >= 2022; $y--): ?>
                                            <option value="<?= $y ?>" <?= ($y == $year) ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Month</label>
                                    <select name="month" class="form-control select2">
                                        <?php
                                        $months = [
                                            1 => 'January',
                                            2 => 'February',
                                            3 => 'March',
                                            4 => 'April',
                                            5 => 'May',
                                            6 => 'June',
                                            7 => 'July',
                                            8 => 'August',
                                            9 => 'September',
                                            10 => 'October',
                                            11 => 'November',
                                            12 => 'December'
                                        ];
                                        foreach ($months as $m => $name): ?>
                                            <option value="<?= $m ?>" <?= ($m == $month) ? 'selected' : '' ?>><?= $name ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                    <div class="col-xl-2 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <form action="<?= base_url('attendance/report_department_export') ?>" method="post" target="_blank">
                                <input type="hidden" name="year" value="<?= $year ?>">
                                <input type="hidden" name="month" value="<?= $month ?>">
                                <input type="hidden" name="division_id" value="<?= $division_id ?>">

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">
                                        Export
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    <table id="scroll-horizontal-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Division</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list_data)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($list_data as $key) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $key->date; ?></td>
                                        <td><?= $key->employee_id; ?></td>
                                        <td><?= $key->name; ?></td>
                                        <td><?= $key->division; ?></td>
                                        <td><?= $key->plant; ?></td>
                                        <td><?= $key->employee_group; ?></td>
                                        <td><?= $key->shift_name; ?></td>
                                        <td><?= $key->jam_masuk; ?></td>
                                        <td><?= $key->jam_pulang; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="14" class="text-center">No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>