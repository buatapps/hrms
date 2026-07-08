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
                    <h5>Employee Absent</h5>
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Division</td>
                                <td>Position</td>
                                <td>Plant</td>
                                <td>Group</td>
                                <td>Absent</td>
                                <td>Information</td>
                            </tr>
                        </thead>
                        <?php foreach ($employee_absent as $row): ?>
                            <tbody>
                                <tr>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->position; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td><?= $row->absent_type; ?></td>
                                    <td><?= $row->information; ?></td>
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