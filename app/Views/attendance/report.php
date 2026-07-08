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
                    <form action="<?= base_url('attendance/search_report'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" value="<?= old('date', $date); ?>">
                                </div>
                            </div>
                            <div class="col-xl-1 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select name="plant_id" class="form-control">
                                        <option value="0">-- All --</option>
                                        <?php foreach ($plant as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $plant_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Group</label>
                                    <select name="employee_group_id" class="form-control">
                                        <option value="0">-- All --</option>
                                        <?php foreach ($group as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $employee_group_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select name="division_id" class="form-control">
                                        <?php if (!in_groups('admin')): ?>
                                            <option value="0">-- All --</option>
                                        <?php endif; ?>
                                        <?php foreach ($division as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $division_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Shift</label>
                                    <select name="shift_id" class="form-control">
                                        <option value="0">-- All --</option>
                                        <?php foreach ($shift as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $shift_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="" <?= empty($status) ? 'selected' : '' ?>>-- All --</option>
                                        <option value="hadir" <?= ($status == 'hadir') ? 'selected' : '' ?>>Hadir</option>
                                        <option value="tidak_hadir" <?= ($status == 'tidak_hadir') ? 'selected' : '' ?>>Tidak Hadir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-1 col-sm-12">
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
                            <form action="<?= base_url('attendance/report_export') ?>" method="post" target="_blank">
                                <input type="hidden" name="date" value="<?= $date ?>">
                                <input type="hidden" name="plant_id" value="<?= $plant_id ?>">
                                <input type="hidden" name="employee_group_id" value="<?= $employee_group_id ?>">
                                <input type="hidden" name="division_id" value="<?= $division_id ?>">
                                <input type="hidden" name="shift_id" value="<?= $shift_id ?>">
                                <input type="hidden" name="status" value="<?= $status ?>">

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
                    <div class="row">
                        <?php
                        $data = [];

                        foreach ($result as $row) {
                            $data[$row->plant][$row->shift_name] = [
                                'hadir' => $row->hadir,
                                'tidak_hadir' => $row->tidak_hadir
                            ];
                        }

                        foreach ($data as $plant => $shifts) {
                        ?>
                            <div class="col-md-2 mb-3">
                                <div class="p-3">
                                    <h5><?= $plant ?></h5>

                                    <?php foreach ($shifts as $shift => $val) { ?>
                                        <div style="margin-bottom:8px;">
                                            <strong><?= $shift ?></strong><br>
                                            Hadir: <span class="text-success"><?= $val['hadir'] ?></span>&nbsp;&nbsp;
                                            Tidak Hadir: <span class="text-danger"><?= $val['tidak_hadir'] ?></span>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        <?php } ?>
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
                    <table id="scroll-horizontal-datatable" class="table table-bordered  nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Position</th>
                                <th>Division</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Employee Status</th>
                                <th>Shift</th>
                                <th>Entry Time</th>
                                <th>Clock Out</th>
                                <th>Attendace IN</th>
                                <th>Attendace OUT</th>
                                <th>Information</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        ->select('*, absent.id as id')
                                        ->join('absent_type', 'absent_type.id = absent.absent_type_id')
                                        ->where('employee_pin', $key->employee_pin)
                                        ->where("'$date' BETWEEN `date` AND `end_date`", null, false)
                                        ->get()->getRow();

                                    if ($absent) {
                                        // $info = $absent->name;
                                        $info = '<a href="' . base_url('attendance/absent_edit/' . $absent->id) . '" ">' . $absent->name . '</a>';
                                    } else {
                                        $info = '<a href="' . base_url('attendance/form_absent_report/' . $date . '/' . $key->id) . '" class="btn btn-danger">Form Absent</a>';
                                    }
                                }

                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $key->name; ?></td>
                                    <td><?= $key->employee_id; ?></td>
                                    <td><?= $key->position; ?></td>
                                    <td><?= $key->division; ?></td>
                                    <td><?= $key->plant; ?></td>
                                    <td><?= $key->employee_group; ?></td>
                                    <td><?= $key->employee_status; ?></td>
                                    <td><?= $key->shift_name; ?></td>
                                    <td><?= $key->entry_time; ?></td>
                                    <td><?= $key->clock_out; ?></td>
                                    <td class="<?= $inClass ?>">
                                        <?= $key->jam_masuk ?? '-' ?>
                                    </td>
                                    <td class="<?= $outClass ?>">
                                        <?= $key->jam_pulang ?? '-' ?>
                                    </td>
                                    <td class="text-center"><?= $info; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>