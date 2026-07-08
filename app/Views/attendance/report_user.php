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
                    <form action="<?= base_url('attendance/search_report_user'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= old('date', $start_date); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="end_date" class="form-control" value="<?= old('date', $end_date); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" name="employee_id" class="form-control select2" data-toggle="select2">
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $employee_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
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
                            <form action="<?= base_url('attendance/report_user_export') ?>" method="post" target="_blank">
                                <input type="hidden" name="start_date" value="<?= $start_date ?>">
                                <input type="hidden" name="end_date" value="<?= $end_date ?>">
                                <input type="hidden" name="employee_id" value="<?= $employee_id ?>">

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
                    <table id="scroll-horizontal-datatable" class="table nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Position</th>
                                <th>Division</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Shift</th>
                                <th>Entry Time</th>
                                <th>Clock Out</th>
                                <th>Attendace IN</th>
                                <th>Attendace OUT</th>
                                <th>Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($list_data)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($list_data as $key) { ?>
                                    <?php
                                    $isLate  = false;
                                    $isEarly = false;

                                    if ($key->jam_masuk && $key->entry_time) {
                                        $isLate = strtotime($key->jam_masuk) > strtotime($key->entry_time);
                                    }

                                    if ($key->jam_pulang && $key->clock_out) {
                                        // shift malam aman karena clock_out sudah ikut working_hours
                                        $isEarly = strtotime($key->jam_pulang) < strtotime($key->clock_out);
                                    }

                                    $inClass  = '';
                                    $outClass = '';

                                    if ($isLate)  $inClass  = 'text-danger fw-bold';
                                    else          $inClass  = 'text-success';

                                    if ($isEarly) $outClass = 'text-warning fw-bold';
                                    else          $outClass = 'text-success';

                                    $info = '-';
                                    if ($key->jam_masuk === null && $key->jam_pulang === null) {
                                        $absent = \Config\Database::connect()->table('absent')
                                            ->join('absent_type', 'absent_type.id = absent.absent_type_id')
                                            ->where('employee_pin', $key->employee_pin)
                                            ->where("'$key->date' BETWEEN `date` AND `end_date`", null, false)
                                            ->get()->getRow();

                                        if ($absent) {
                                            $info = $absent->name;
                                        } else {
                                            $info = '<a href="' . base_url('attendance/form_absent_report/' . $key->date . '/' . $key->id) . '" class="btn btn-danger" target="_blank">Form Absent</a>';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $key->date; ?></td>
                                        <td><?= $key->name; ?></td>
                                        <td><?= $key->employee_id; ?></td>
                                        <td><?= $key->position; ?></td>
                                        <td><?= $key->division; ?></td>
                                        <td><?= $key->plant; ?></td>
                                        <td><?= $key->employee_group; ?></td>
                                        <td><?= $key->shift_name; ?></td>
                                        <td><?= $key->entry_time; ?></td>
                                        <td><?= $key->clock_out; ?></td>
                                        <td class="<?= $inClass ?>">
                                            <?= $key->jam_masuk ?? '-' ?>
                                        </td>
                                        <td class="<?= $outClass ?>">
                                            <?= $key->jam_pulang ?? '-' ?>
                                        </td>
                                        <td><?= $info; ?></td>
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