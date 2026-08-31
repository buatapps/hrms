<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('employee'); ?>">Employee</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title mb-0">Data Employee Non-active</h4>
                <a href="<?= base_url('employee'); ?>" class="btn btn-secondary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Employee Active
                </a>
            </div>
            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Division</th>
                        <th>Position</th>
                        <th>Employee Status</th>
                        <th>Resign Date</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_data as $no => $row) : ?>
                        <tr>
                            <td><?= $no + 1; ?></td>
                            <td><?= esc($row->name); ?></td>
                            <td><?= esc($row->employee_id); ?></td>
                            <td><?= esc($row->division ?? ''); ?></td>
                            <td><?= esc($row->position ?? ''); ?></td>
                            <td><?= esc($row->employee_status ?? ''); ?></td>
                            <td><?= !empty($row->resign_date) ? date('d/m/Y', strtotime($row->resign_date)) : ''; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('employee/details/' . $row->id); ?>" class="action-icon text-dark">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('employee/edit/' . $row->id); ?>" class="action-icon text-info">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
