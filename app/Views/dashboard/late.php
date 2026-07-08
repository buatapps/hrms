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
                    <p>Date : <?= date('d/m/Y', strtotime($date)); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Employee is Late</h5>
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <td>PIN</td>
                                <td>Employee</td>
                                <td>Division</td>
                                <td>Position</td>
                                <td>Plant</td>
                                <td>Group</td>
                                <td>Shift</td>
                                <td>Shift Time</td>
                                <td>Time In</td>
                                <td>Late time</td>
                            </tr>
                        </thead>
                        <?php foreach ($employee_late as $row): ?>
                            <tbody>
                                <tr>
                                    <td><?= $row->employee_pin; ?></td>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->position; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td><?= $row->shift_name; ?></td>
                                    <td><?= $row->entry_time; ?></td>
                                    <td><?= $row->late_hour; ?></td>
                                    <td>
                                        <?php
                                        $start  = date_create($row->entry_time);
                                        $end = date_create($row->late_hour); // waktu sekarang
                                        $diff  = date_diff($start, $end);
                                        echo $diff->i . ' menit, ' . $diff->s . ' detik, ';
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>