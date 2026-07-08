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
                    <div class="row mb-2">
                        <div class="col-xl-2 col-sm-12">
                            <div class="mt-2">
                                <a href="<?= base_url('overtime/form_add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <?php if (session('success')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (session('error')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-danger" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('error'); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Created By</th>
                                <th>Total Employee</th>
                                <th>Status</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->date)); ?></td>
                                    <td><?= $row->username; ?></td>
                                    <td><?= $row->total_employee; ?></td>
                                    <td>
                                        <select name="status" class="form-control status-select" data-id="<?= $row->id ?>">
                                            <option value="submitted" <?= ($row->status == 'submitted') ? 'selected' : '' ?>>Submitted</option>
                                            <option value="approved" <?= ($row->status == 'approved') ? 'selected' : '' ?>>Approved</option>
                                            <option value="rejected" <?= ($row->status == 'rejected') ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('overtime/form_detail/' . $row->id); ?>" class="action-icon text-dark"> <i class="mdi mdi-eye"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('overtime/form_edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('overtime/form_delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
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

<!-- container -->
<?= $this->endSection() ?>