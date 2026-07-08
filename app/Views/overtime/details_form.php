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
                        <li class="breadcrumb-item"><a href="<?= base_url('overtime/form'); ?>">Form</a></li>
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
                    <div class="row">
                        <div class="col-xl-1 col-sm-6">
                            <div class="mb-3">
                                <div class="d-grid">
                                    <a href="<?= base_url('overtime/form_edit/' . $header_data->id); ?>" class="btn btn-info">Edit</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-1 col-sm-6">
                            <div class="mb-3">
                                <div class="d-grid">
                                    <a href="<?= base_url('overtime/form_print/' . $header_data->id); ?>" class="btn btn-success" target="_blank">Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="mb-3">
                                <h4>Date : <?= date('d/m/Y', strtotime($header_data->date)); ?></h4>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="mb-3">
                                <h3 class="text-center">OVERTIME FORM</h3>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="mb-3">
                                <h4 class="text-end">Created By : <?= $header_data->username; ?></h4>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead class=" text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Division</th>
                                    <th>Plant</th>
                                    <th>Group</th>
                                    <th>Jobdesk</th>
                                    <th>Overtime Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($detail_data as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->name; ?></td>
                                        <td><?= $row->division; ?></td>
                                        <td><?= $row->plant; ?></td>
                                        <td><?= $row->employee_group; ?></td>
                                        <td><?= $row->jobdesk; ?></td>
                                        <td class="text-end"><?= $row->total_hours; ?></td>
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