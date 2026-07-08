<?= $this->extend('layout/index') ?>
<?= $this->section('content') ?>
<style>
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
</style>
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
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1>社員情報 (Shain Jouhou)</h1>
                </div>

                <div class="card-body">

                    <h4>Manajemen Japan</h4>

                    <div class="d-flex flex-nowrap overflow-auto gap-3">

                        <!-- <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-light text-muted rounded">
                                        <i class="ri-group-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['total']; ?></h4>
                                    <small class="text-muted">Data Registrasi</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-danger-lighten text-danger rounded">
                                        <i class="ri-user-fill"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['nonactive']; ?></h4>
                                    <small class="text-muted">Non Active</small>
                                </div>
                            </div>
                        </div> -->

                        <!-- Total Active -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                        <i class="ri-user-heart-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['totalActive']; ?></h4>
                                    <small class="text-muted">Total employee</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-success-lighten text-success rounded">
                                        <i class="ri-user-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['activePermanent']; ?></h4>
                                    <small class="text-muted">Active Permanent</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-info-lighten text-info rounded">
                                        <i class="ri-contacts-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['activeContract']; ?></h4>
                                    <small class="text-muted">Active Contract</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                        <i class="ri-user-2-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['men']; ?></h4>
                                    <small class="text-muted">Men</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-warning-lighten text-warning rounded">
                                        <i class="ri-user-3-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $japan['women']; ?></h4>
                                    <small class="text-muted">Women</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h4>PT Namicoh Indonesia Component</h4>

                    <div class="d-flex flex-nowrap overflow-auto gap-3">

                        <!-- Total -->
                        <!-- <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-light text-muted rounded">
                                        <i class="ri-group-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['total']; ?></h4>
                                    <small class="text-muted">Data Registrasi</small>
                                </div>
                            </div>
                        </div> -->

                        <!-- Non Active -->
                        <!-- <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-danger-lighten text-danger rounded">
                                        <i class="ri-user-fill"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['nonactive']; ?></h4>
                                    <small class="text-muted">Non Active</small>
                                </div>
                            </div>
                        </div> -->

                        <!-- Total Active -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                        <i class="ri-user-heart-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['totalActive']; ?></h4>
                                    <small class="text-muted">Total Employee</small>
                                </div>
                            </div>
                        </div>

                        <!-- Active Permanent -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-success-lighten text-success rounded">
                                        <i class="ri-user-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['activePermanent']; ?></h4>
                                    <small class="text-muted">Active Permanent</small>
                                </div>
                            </div>
                        </div>

                        <!-- Active Contract -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-info-lighten text-info rounded">
                                        <i class="ri-contacts-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['activeContract']; ?></h4>
                                    <small class="text-muted">Active Contract</small>
                                </div>
                            </div>
                        </div>

                        <!-- Men -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-primary-lighten text-primary rounded">
                                        <i class="ri-user-2-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['men']; ?></h4>
                                    <small class="text-muted">Men</small>
                                </div>
                            </div>
                        </div>

                        <!-- Women -->
                        <div class="col-2">
                            <div class="d-flex align-items-center px-3 py-2">
                                <div class="avatar-sm rounded">
                                    <span class="avatar-title bg-warning-lighten text-warning rounded">
                                        <i class="ri-user-3-line"></i>
                                    </span>
                                </div>
                                <div class="ms-2 text-nowrap">
                                    <h4 class="mb-0"><?= $namicoh['women']; ?></h4>
                                    <small class="text-muted">Women</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-12 col-sm-12">
            <!-- Chart -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Employee Active by Division</h4>

                    <div id="division-bar"
                        class="apex-charts"
                        data-labels='<?= json_encode($divisionLabels) ?>'
                        data-series='<?= json_encode($divisionSeries) ?>'>
                    </div>
                </div>
            </div>
            <!-- end Chart -->
        </div>
    </div>

    <div class="row" id="percentage-section">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1>勤怠データ (Kintai)</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <h6>Filter</h6>
                        <div class="col-12 mb-3">
                            <form method="get" action="<?= base_url('') ?>" class="d-flex align-items-end gap-2">
                                <div class="d-flex gap-2">
                                    <div class="col-6">
                                        <input type="date" id="start_date" name="start_date" value="<?= $startDate ?>" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <input type="date" id="end_date" name="end_date" value="<?= $endDate ?>" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <select name="division_id" id="division_id" class="form-control">
                                            <option value="all" <?= ($division_id === 'all' || empty($division_id)) ? 'selected' : '' ?>>
                                                -All-
                                            </option>
                                            <?php foreach ($division as $d) : ?>
                                                <option value="<?= $d['id'] ?>" <?= $d['id'] == $division_id ? 'selected' : '' ?>>
                                                    <?= $d['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary">
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="col-1">
                            <a href="<?= base_url('dashboard/export_percentage?start_date=' . $startDate . '&end_date=' . $endDate); ?>"
                                class="btn btn-success"
                                onclick="showLoading()">
                                Export
                            </a>
                        </div> -->
                    </div>
                    <h3 class="header-title">Percentage Attendance</h3>
                    <div class="row">
                        <div class="col-12">
                            <h6>DayShift <?= $periodDayShift; ?></h6>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Total Employee</th>
                                        <?php foreach ($plants as $p) : ?>
                                            <th style="width: 10%;"><?= $p->name; ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $dayShiftPercent = ($totalDayShift > 0)
                                            ? round(($totalDay / $totalDayShift) * 100, 2)
                                            : 0;
                                        ?>

                                        <!-- TOTAL SUMMARY -->
                                        <td>
                                            <?= $totalDay . ' / ' . $totalDayShift; ?><br>
                                            <?= $dayShiftPercent . ' %'; ?>
                                        </td>

                                        <?php foreach ($plants as $p) : ?>

                                            <?php
                                            $dayHadir  = $attendanceDayMap[$p->id] ?? 0;
                                            $dayJadwal = $dayMap[$p->id] ?? 0;
                                            $dayAbsent = $dayJadwal - $dayHadir;

                                            $plantPercent = ($dayJadwal > 0)
                                                ? round(($dayHadir / $dayJadwal) * 100, 1)
                                                : 0;
                                            ?>

                                            <td>
                                                <?= $dayHadir . ' / ' . $dayJadwal; ?><br>
                                                (<?= $plantPercent; ?>%)

                                                <br class="mb-3"><br>

                                                <?php if ($dayAbsent > 0): ?>
                                                    <a href="<?= base_url('dashboard/absent_employee/' . $startDate . '/' . $endDate . '/day/' . $p->id . '/' . $selectedDivisionId); ?>"
                                                        class="btn btn-dark btn-sm"
                                                        target="_blank">
                                                        Absent (<?= $dayAbsent; ?>)
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>NightShift <?= $periodNightShift; ?></h6>
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Total Employee</th>
                                        <?php foreach ($plants as $p) : ?>
                                            <th style="width: 10%;"><?= $p->name; ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $nightShiftPercent = ($totalNightShift > 0)
                                            ? round(($totalNight / $totalNightShift) * 100, 2)
                                            : 0;
                                        ?>

                                        <!-- TOTAL SUMMARY -->
                                        <td>
                                            <?= $totalNight . ' / ' . $totalNightShift; ?><br>
                                            <?= $nightShiftPercent . ' %'; ?>
                                        </td>

                                        <?php foreach ($plants as $p) : ?>

                                            <?php
                                            $nightHadir  = $attendanceNightMap[$p->id] ?? 0;
                                            $nightJadwal = $nightMap[$p->id] ?? 0;
                                            $nightAbsent = $nightJadwal - $nightHadir;

                                            $plantPercent = ($nightJadwal > 0)
                                                ? round(($nightHadir / $nightJadwal) * 100, 1)
                                                : 0;
                                            ?>

                                            <td>
                                                <?= $nightHadir . ' / ' . $nightJadwal; ?><br>
                                                (<?= $plantPercent; ?>%)

                                                <br class="mb-3"><br>

                                                <?php if ($nightAbsent > 0): ?>
                                                    <a href="<?= base_url('dashboard/absent_employee/' . $startDate . '/' . $endDate . '/night/' . $p->id . '/' . $selectedDivisionId); ?>"
                                                        class="btn btn-dark btn-sm"
                                                        target="_blank">
                                                        Absent (<?= $nightAbsent; ?>)
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- not schedule -->
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-bordered text-center" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Not Schedule (Day)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalNotScheduleDay">
                                                <?= $nonScheduleDay['totalNonSchedule']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-6">
                            <table class="table table-bordered text-center" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Not Schedule (Night)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalNotScheduleNight">
                                                <?= $nonScheduleNight['totalNonSchedule']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal fade" id="modalNotScheduleDay" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Employee Without Schedule (Day)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PIN</th>
                                                <th>Name</th>
                                                <th>Schedule</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($nonScheduleDay['listNonSchedule'] as $row): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $row->employee_id; ?></td>
                                                    <td><?= $row->name; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('employee/schedule_add/' . $row->id); ?>" target="_blank">
                                                            Schedule
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalNotScheduleNight" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Employee Without Schedule (Night)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PIN</th>
                                                <th>Name</th>
                                                <th>Schedule</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php foreach ($nonScheduleNight['listNonSchedule'] as $row): ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $row->employee_id; ?></td>
                                                    <td><?= $row->name; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('employee/schedule_add/' . $row->id); ?>" target="_blank">
                                                            Schedule
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- PERCENTAGE PER DEPARTEMEN -->
                    <h3 class="header-title">Percentage Attendance by Department</h3>
                    <div class="row">

                        <div class="col-12">

                            <h6>
                                DayShift Department <?= $periodDayShift; ?>
                            </h6>

                            <table class="table table-bordered text-center" style="table-layout: fixed;">

                                <!-- ========================= HEADER ========================== -->
                                <thead>
                                    <tr>

                                        <th style="width: 17%;">
                                            Total Employee
                                        </th>

                                        <?php $plantWidth = 83 / count($plants); ?>

                                        <?php foreach ($plants as $p): ?>
                                            <th style="width: <?= $plantWidth; ?>%;">
                                                <?= $p->name; ?>
                                            </th>
                                        <?php endforeach; ?>

                                    </tr>
                                </thead>

                                <!-- ========================= BODY ========================== -->
                                <tbody>
                                    <tr>

                                        <!-- ========================= TOTAL SUMMARY (GLOBAL) ========================== -->
                                        <td class="align-top text-center">

                                            <?php
                                            $totalEmp = $totalDayShift ?? 0;

                                            $totalAtt = $totalDay ?? 0;

                                            $totalAbsent = $totalEmp - $totalAtt;

                                            $totalPercent =
                                                ($totalEmp > 0)
                                                ? round(($totalAtt / $totalEmp) * 100, 1)
                                                : 0;
                                            ?>

                                            <h5 class="mb-1">
                                                <?= $totalAtt . ' / ' . $totalEmp; ?>
                                            </h5>

                                            <strong>
                                                <?= $totalPercent; ?>%
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                Absent: <?= $totalAbsent; ?>
                                            </small>

                                        </td>

                                        <!-- ========================= PLANT LOOP ========================== -->
                                        <?php foreach ($plants as $p): ?>

                                            <?php
                                            // =========================
                                            // PLANT SUMMARY
                                            // =========================
                                            $plantAttendance = $attendanceDayMap[$p->id] ?? 0;

                                            $plantSchedule = $dayMap[$p->id] ?? 0;

                                            $plantAbsent = $plantSchedule - $plantAttendance;

                                            $plantPercent =
                                                ($plantSchedule > 0)
                                                ? round(($plantAttendance / $plantSchedule) * 100, 1)
                                                : 0;

                                            // =========================
                                            // DEPARTMENT DATA
                                            // =========================
                                            $scheduleDepartments =
                                                $dayScheduleDepartmentMap[$p->id] ?? [];

                                            uasort($scheduleDepartments, function ($a, $b) {
                                                return strcmp($a['division_name'], $b['division_name']);
                                            });
                                            ?>

                                            <td class="text-start align-top">

                                                <!-- ========================= PLANT SUMMARY ========================== -->
                                                <div class="mb-3 text-center">

                                                    <h5 class="mb-1">
                                                        <?= $plantAttendance . ' / ' . $plantSchedule; ?>
                                                    </h5>

                                                    <strong>
                                                        <?= $plantPercent; ?>%
                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        <?php if ($plantAbsent > 0): ?>
                                                            <a href="<?= base_url('dashboard/absent_employee/' . $startDate . '/' . $endDate . '/day/' . $p->id . '/' . $selectedDivisionId); ?>"
                                                                target="_blank">
                                                                Absent: (<?= $plantAbsent; ?>)
                                                            </a>
                                                        <?php else: ?>
                                                            <span>&nbsp;</span>
                                                        <?php endif; ?>
                                                    </small>

                                                    <hr>

                                                </div>

                                                <!-- ========================= DEPARTMENT BREAKDOWN ========================== -->

                                                <?php if (!empty($scheduleDepartments)): ?>

                                                    <?php foreach ($scheduleDepartments as $deptId => $schedule): ?>

                                                        <?php
                                                        $attendance =
                                                            $dayAttendanceDepartmentMap[$p->id][$deptId]['total'] ?? 0;

                                                        $totalSchedule =
                                                            $schedule['total'] ?? 0;

                                                        $percent =
                                                            ($totalSchedule > 0)
                                                            ? round(($attendance / $totalSchedule) * 100, 1)
                                                            : 0;
                                                        ?>

                                                        <div class="mb-2">

                                                            <strong>
                                                                <?= $schedule['division_name']; ?>
                                                            </strong>

                                                            <br>

                                                            <?= $attendance . ' / ' . $totalSchedule; ?>
                                                            (<?= $percent; ?>%)

                                                        </div>

                                                    <?php endforeach; ?>

                                                <?php else: ?>

                                                    <span class="text-muted">
                                                        No Data
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                        <?php endforeach; ?>

                                    </tr>
                                </tbody>

                            </table>

                        </div>

                    </div>
                    <div class="row">

                        <div class="col-12">

                            <h6>
                                NightShift Department <?= $periodNightShift; ?>
                            </h6>

                            <table class="table table-bordered text-center" style="table-layout: fixed;">

                                <!-- ========================= HEADER ========================== -->
                                <thead>
                                    <tr>

                                        <th style="width: 17%;">
                                            Total Employee
                                        </th>

                                        <?php $plantWidth = 83 / count($plants); ?>

                                        <?php foreach ($plants as $p): ?>
                                            <th style="width: <?= $plantWidth; ?>%;">
                                                <?= $p->name; ?>
                                            </th>
                                        <?php endforeach; ?>

                                    </tr>
                                </thead>

                                <!-- ========================= BODY ========================== -->
                                <tbody>
                                    <tr>

                                        <!-- ========================= GLOBAL SUMMARY ========================== -->
                                        <td class="align-top text-center">

                                            <?php
                                            $totalEmp =
                                                $totalNightShift ?? 0;

                                            $totalAtt =
                                                $totalNight ?? 0;

                                            $totalAbsent =
                                                $totalEmp - $totalAtt;

                                            $totalPercent =
                                                ($totalEmp > 0)
                                                ? round(($totalAtt / $totalEmp) * 100, 1)
                                                : 0;
                                            ?>

                                            <h5 class="mb-1">
                                                <?= $totalAtt . ' / ' . $totalEmp; ?>
                                            </h5>

                                            <strong>
                                                <?= $totalPercent; ?>%
                                            </strong>

                                            <br>

                                            <small class="text-muted">
                                                Absent: <?= $totalAbsent; ?>
                                            </small>

                                        </td>

                                        <!-- ========================= PLANT LOOP ========================== -->
                                        <?php foreach ($plants as $p): ?>

                                            <?php
                                            // =========================
                                            // PLANT SUMMARY (NIGHT)
                                            // =========================
                                            $plantAttendance =
                                                $attendanceNightMap[$p->id] ?? 0;

                                            $plantSchedule =
                                                $nightMap[$p->id] ?? 0;

                                            $plantAbsent =
                                                $plantSchedule - $plantAttendance;

                                            $plantPercent =
                                                ($plantSchedule > 0)
                                                ? round(($plantAttendance / $plantSchedule) * 100, 1)
                                                : 0;

                                            // =========================
                                            // DEPARTMENT DATA
                                            // =========================
                                            $scheduleDepartments =
                                                $nightScheduleDepartmentMap[$p->id] ?? [];

                                            uasort($scheduleDepartments, function ($a, $b) {
                                                return strcmp($a['division_name'], $b['division_name']);
                                            });
                                            ?>

                                            <td class="text-start align-top">

                                                <!-- ========================= PLANT SUMMARY ========================== -->
                                                <div class="mb-3 text-center">

                                                    <h5 class="mb-1">
                                                        <?= $plantAttendance . ' / ' . $plantSchedule; ?>
                                                    </h5>

                                                    <strong>
                                                        <?= $plantPercent; ?>%
                                                    </strong>

                                                    <br>

                                                    <small class="text-muted">
                                                        <?php if ($plantAbsent > 0): ?>
                                                            <a href="<?= base_url('dashboard/absent_employee/' . $startDate . '/' . $endDate . '/night/' . $p->id . '/' . $selectedDivisionId); ?>"
                                                                target="_blank">
                                                                Absent: (<?= $plantAbsent; ?>)
                                                            </a>
                                                        <?php else: ?>
                                                            <span>&nbsp;</span>
                                                        <?php endif; ?>
                                                    </small>

                                                    <hr>

                                                </div>

                                                <!-- ========================= DEPARTMENT BREAKDOWN ========================== -->

                                                <?php if (!empty($scheduleDepartments)): ?>

                                                    <?php foreach ($scheduleDepartments as $deptId => $schedule): ?>

                                                        <?php
                                                        $attendance =
                                                            $nightAttendanceDepartmentMap[$p->id][$deptId]['total'] ?? 0;

                                                        $totalSchedule =
                                                            $schedule['total'] ?? 0;

                                                        $percent =
                                                            ($totalSchedule > 0)
                                                            ? round(($attendance / $totalSchedule) * 100, 1)
                                                            : 0;
                                                        ?>

                                                        <div class="mb-2">

                                                            <strong>
                                                                <?= $schedule['division_name']; ?>
                                                            </strong>

                                                            <br>

                                                            <?= $attendance . ' / ' . $totalSchedule; ?>
                                                            (<?= $percent; ?>%)

                                                        </div>

                                                    <?php endforeach; ?>

                                                <?php else: ?>

                                                    <span class="text-muted">
                                                        No Data
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                        <?php endforeach; ?>

                                    </tr>
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <h1>Employee Performance Attendance</h1>

                    <div class="text-muted mb-3">
                        Periode :
                        <span id="period_label"></span>
                    </div>

                    <div id="chart_absent"></div>
                </div>



                <div class="card-body">
                    <h3>Employee Performance Attendance by Type</h3>
                    <div class="chart-wrapper row" style="position:relative;">
                        <div id="chart_loading" style="
                            display:none;
                            position:absolute;
                            top:0;
                            left:0;
                            width:100%;
                            height:100%;
                            background:rgba(255,255,255,0.7);
                            z-index:10;
                            align-items:center;
                            justify-content:center;
                            flex-direction:column;
                        ">
                            <div style="
                                width:35px;
                                height:35px;
                                border:4px solid #eee;
                                border-top:4px solid #EF4444;
                                border-radius:50%;
                                animation: spin 1s linear infinite;
                            "></div>
                            <p style="margin-top:10px;color:#666;">Loading charts...</p>
                        </div>

                        <div class="col-md-12">
                            <h1>Employee Performance Attendance - Sakit</h1>
                            <p class="periode_label">Loading...</p>
                            <div id="chart_sakit"></div>
                        </div>

                        <div class="col-md-12">
                            <h1>Employee Performance Attendance - Alpa</h1>
                            <p class="periode_label">Loading...</p>
                            <div id="chart_alpa"></div>
                        </div>

                        <div class="col-md-12">
                            <h1>Employee Performance Attendance - Late Coming</h1>
                            <p class="periode_label">Loading...</p>
                            <div id="chart_late_coming"></div>
                        </div>

                        <div class="col-md-12">
                            <h1>Employee Performance Attendance - Cuti</h1>
                            <p class="periode_label">Loading...</p>
                            <div id="chart_cuti"></div>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <h1>Daily Performance</h1>
                    <p>Periode : <span id="period_label2"></span></p>
                    <div id="chart_monthly_trend"></div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- container -->
<div id="loadingOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    color:#fff;
    font-size:20px;
">
    Export Data from machines, please wait...
</div>
<script>
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        overlay.style.display = 'flex';

        // reset cookie dulu
        document.cookie = "downloadDone=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        // cek tiap 500ms
        const interval = setInterval(() => {
            if (document.cookie.includes('downloadDone=true')) {
                overlay.style.display = 'none';

                // hapus cookie lagi
                document.cookie = "downloadDone=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                clearInterval(interval);
            }
        }, 500);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const chartEl = document.querySelector("#division-bar");
        if (!chartEl) return;

        const labels = JSON.parse(chartEl.dataset.labels);
        const series = JSON.parse(chartEl.dataset.series);

        // 🔥 bikin object gabungan (biar bisa dibaca per division)
        const divisionData = labels.map((label, index) => {
            return {
                division: label,
                total: series[index]
            };
        });

        // 🔥 OPTIONAL: debug lihat hasil
        console.table(divisionData);

        // 🔥 kalau mau pakai lagi di UI / log / export
        divisionData.forEach(item => {
            console.log(`${item.division} = ${item.total}`);
        });

        // chart tetap jalan seperti biasa
        const options = {
            chart: {
                type: 'bar',
                height: 450
            },
            plotOptions: {
                bar: {
                    distributed: true, // Tiap bar akan dianggap item legend yang berbeda
                    borderRadius: 4,
                    columnWidth: '60%',
                }
            },
            series: [{
                name: 'Employee',
                data: series
            }],
            xaxis: {
                categories: labels
            },
            colors: ["#2563EB"],
            legend: {
                show: true,
                showForSingleSeries: true,
                position: 'right',
                horizontalAlign: 'right',
                floating: true,
                offsetY: 20,
                offsetX: 0,
                // INI BAGIAN UNTUK MENAMBAHKAN VALUE
                formatter: function(seriesName, opts) {
                    // Mengambil nilai berdasarkan index data
                    const value = opts.w.globals.series[0][opts.seriesIndex];
                    return seriesName + ": " + "<strong>" + value + "</strong>";
                },
                labels: {
                    useSeriesColors: true
                },
            },
            dataLabels: {
                enabled: true
            }
        };

        new ApexCharts(chartEl, options).render();

    });
</script>

<!-- Chart Employee Performance Attendance -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let chartInstance = null;

        const colors = [
            "#1E3A8A", // Cuti Monday
            "#2563EB", // Cuti Friday
            "#EF4444", // Sakit
            "#F59E0B", // Izin
            "#64748B", // Alpha
            "#10B981", // lainnya
            "#8B5CF6",
            "#F97316"
        ];

        function renderChart(data) {

            let el = document.querySelector("#chart_absent");

            if (!data || !data.series) {
                el.innerHTML = "<div style='text-align:center;color:#999;'>No Data</div>";
                return;
            }

            el.innerHTML = "";

            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new ApexCharts(el, {
                series: data.series,
                chart: {
                    type: 'bar',
                    height: 400,
                    stacked: false,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: data.categories,
                    labels: {
                        rotate: -45,
                        trim: true,
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                legend: {
                    position: 'top'
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                colors: colors
            });

            chartInstance.render();
        }

        function loadEmployeePerformance() {

            let startDate = document.getElementById("start_date")?.value;
            let endDate = document.getElementById("end_date")?.value;
            let division = document.getElementById("division_id")?.value;

            // fallback safety
            if (!startDate || !endDate) {
                console.warn("Missing global date filter");
                return;
            }

            let url = `<?= base_url('dashboard/chartDivision') ?>` +
                `?start_date=${startDate}` +
                `&end_date=${endDate}` +
                `&division_id=${division || ''}`;

            fetch(url, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(res => res.json())
                .then(data => {

                    // optional label
                    if (document.getElementById("period_label")) {
                        document.getElementById("period_label").innerText = data.period ?? '';
                    }

                    renderChart(data);
                })
                .catch(err => console.log(err));
        }

        // GLOBAL FILTER LISTENER
        document.querySelectorAll("#start_date, #end_date, #division_id")
            .forEach(el => {
                el.addEventListener("change", loadEmployeePerformance);
            });

        // initial load
        loadEmployeePerformance();

    });
</script>

<!-- Chart Bar Absent Type Employee  -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let charts = {};

        function renderChart(id, data, color) {

            let el = document.querySelector(id);

            if (!data || !data.length) {
                el.innerHTML = `<div style="text-align:center;color:#999;">No Data</div>`;
                return;
            }

            el.innerHTML = "";

            // 🔥 GROUP BY EMPLOYEE (FIX UTAMA)
            let grouped = {};

            data.forEach(x => {
                if (!grouped[x.employee_name]) {
                    grouped[x.employee_name] = 0;
                }
                grouped[x.employee_name] += parseInt(x.total);
            });

            let categories = Object.keys(grouped);
            let seriesData = Object.values(grouped);

            const dataCount = categories.length;

            let calculatedWidth;
            if (dataCount <= 3) {
                calculatedWidth = '10%';
            } else if (dataCount <= 10) {
                calculatedWidth = '30%';
            } else {
                calculatedWidth = '80%';
            }

            new ApexCharts(el, {
                series: [{
                    name: "Total",
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        columnWidth: calculatedWidth,
                        borderRadius: 4,
                        distributed: dataCount <= 10 ? true : false
                    }
                },
                xaxis: {
                    categories: categories
                },
                colors: [color],
                dataLabels: {
                    enabled: true
                }
            }).render();
        }

        function renderAllCharts() {
            renderChart("#chart_sakit", charts.sakit, "#EF4444");
            renderChart("#chart_alpa", charts.alpa, "#3B82F6");
            renderChart("#chart_late_coming", charts.late_coming, "#F59E0B");
            renderChart("#chart_cuti", charts.cuti, "#10B981");
        }

        function showLoading() {
            document.getElementById("chart_loading").style.display = "flex";
        }

        function hideLoading() {
            document.getElementById("chart_loading").style.display = "none";
        }

        function loadCharts() {

            let division_id = document.getElementById("division_id").value || null;
            let start_date = document.getElementById("start_date").value;
            let end_date = document.getElementById("end_date").value;
            console.log(start_date, end_date);
            showLoading();

            fetch(`<?= base_url('dashboard/chartEmployeePerformance') ?>
            ?division_id=${division_id}
            &start_date=${start_date}
            &end_date=${end_date}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log("FULL RESPONSE:", data);

                    console.log("SAKIT:", data.charts.sakit);
                    console.log("ALPA:", data.charts.alpa);

                    charts = data.charts;

                    renderAllCharts();

                    const labels = document.querySelectorAll(".periode_label");
                    labels.forEach(el => {
                        el.innerText = data.period ?? '';
                    });

                    hideLoading();
                })
                .catch(err => {
                    console.log(err);
                    hideLoading();
                });
        }

        // FILTER EVENT
        document.querySelectorAll("#division_id, #start_date, #end_date")
            .forEach(el => {
                el.addEventListener("change", loadCharts);
            });

        // INITIAL LOAD
        loadCharts();

    });
</script>

<!-- Daily Performance Chart -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const colorMap = {
            "Sakit": "#EF4444",
            "Alpa": "#3B82F6",
            "LC-Late Coming": "#F59E0B",
            "Cuti": "#10B981",
            "H-Work From Home": "#6366F1",
            "EG- Early Going": "#A855F7",
            "Absen Manual- Lupa Finger": "#1cbad6",
            "O1-Overlap Pagi": "#A855F7",
            "O-Overlap Malam": "#2f0853",
            "Alpha-Tanpa keterangan": "#A855F7",
            "C2-Cuti Haid": "#10B981",
            "C1-Cuti Khusus": "#10B981",
            "Dispensasi": "#9b2fe4",
            "i -ijin": "#214224",
        };

        // =========================
        // RENDER CHART
        // =========================
        window.renderAbsentTrend = function(id, data) {

            let el = document.querySelector(id);
            if (!el) {
                console.error("Chart container not found:", id);
                return;
            }

            if (window.absentTrendChart) {
                window.absentTrendChart.destroy();
            }

            if (!data || !data.series || !data.categories) {
                el.innerHTML = "No Data";
                return;
            }

            el.innerHTML = "";

            window.absentTrendChart = new ApexCharts(el, {
                series: data.series,
                colors: data.series.map(s => colorMap[s.name] || "#999999"),
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true
                },
                xaxis: {
                    categories: data.categories,
                    labels: {
                        rotate: -45
                    }
                },
                legend: {
                    show: true,
                    position: 'top'
                },
                dataLabels: {
                    enabled: false
                }
            });

            window.absentTrendChart.render();
        };

        // =========================
        // LOAD DATA (GLOBAL FILTER)
        // =========================
        function loadAbsentTrend() {

            const startEl = document.getElementById("start_date");
            const endEl = document.getElementById("end_date");
            const divEl = document.getElementById("division_id");

            // SAFE CHECK (biar gak crash diam-diam)
            if (!startEl || !endEl) {
                console.error("START/END DATE NOT FOUND");
                return;
            }

            let startDate = startEl.value;
            let endDate = endEl.value;
            let division = divEl ? divEl.value : null;

            console.log("LOAD ABSENT TREND:", {
                startDate,
                endDate,
                division
            });

            let url = `<?= base_url('dashboard/chartAbsentTrend') ?>?start_date=${startDate}&end_date=${endDate}&division_id=${division || ''}`;

            console.log("FETCH URL:", url);

            fetch(url)
                .then(res => res.json())
                .then(data => {

                    console.log("ABSENT TREND RESPONSE:", data);

                    document.getElementById("period_label2").innerText = data.period;

                    renderAbsentTrend("#chart_monthly_trend", data.charts);

                })
                .catch(err => console.error("FETCH ERROR:", err));
        }

        // =========================
        // EVENT LISTENER
        // =========================
        const startEl = document.getElementById("start_date");
        const endEl = document.getElementById("end_date");
        const divEl = document.getElementById("division_id");

        if (startEl) startEl.addEventListener("change", loadAbsentTrend);
        if (endEl) endEl.addEventListener("change", loadAbsentTrend);
        if (divEl) divEl.addEventListener("change", loadAbsentTrend);

        // =========================
        // INITIAL LOAD
        // =========================
        loadAbsentTrend();

    });
</script>


<script>
    window.onload = function() {
        const params = new URLSearchParams(window.location.search);
        const hasDate = params.has('date');

        if (hasDate) {
            const el = document.getElementById('percentage-section');
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    }
</script>

<?= $this->endSection() ?>