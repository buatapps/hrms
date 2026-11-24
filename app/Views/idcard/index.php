<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
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
                    <div class="row mb-3">
                        <div class="col-xl-2 col-sm-12">
                            <a href="<?= base_url('employee/idcard/print'); ?>" class="btn btn-primary" target="_blank"><i class="mdi mdi-printer me-1"></i> Print All Card</a>
                        </div>
                    </div>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Division</th>
                                <th class="text-center">Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['employee_id']); ?></td>
                                    <td><?= esc($row['name']); ?></td>
                                    <td><?= esc($row['division']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/idcard/print/' . $row['id']); ?>" class="action-icon text-primary" target="_blank"><i class="mdi mdi-printer"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
