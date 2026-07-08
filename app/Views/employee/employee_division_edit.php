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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee'); ?>">Employee</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <?php if (session('success')) : ?>
        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                        <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" class="rounded-circle avatar-lg img-thumbnail"
                                            alt="profile-image">
                                    </a>
                                </div>
                                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel"><?= $list_data['name']; ?></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" alt="" style="display:block; max-width:700px; margin:0 auto;">
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white"><?= $list_data['name']; ?></h4>
                                        <p class="font-13 text-white-50 fst-italic"> <?= $list_data['division']; ?><br><?= $list_data['position']; ?></p>
                                        <p class="font-13 text-white-50 fst-italic"> </p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate action="<?= base_url('employee/employee_division_update'); ?>" method="post" enctype="multipart/form-data" id="form-update-employee">
                        <div class="row">
                            <div class="col-3" hidden>
                                <div class="mb-3">
                                    <label class="form-label">ID</label>
                                    <input type="text" name="id" class="form-control underline form-control-sm" value="<?= $list_data['id']; ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Employee ID</label>
                                    <p class="p-underline"><?= strtoupper($list_data['employee_id']); ?></p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <p class="p-underline"><?= strtoupper($list_data['division']); ?></p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <p class="p-underline"><?= strtoupper($list_data['position']); ?></p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Employee Status</label>
                                    <p class="p-underline"><?= strtoupper($list_data['employee_status']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="plant_id">
                                        <?php foreach ($plant as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['plant_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">Employee Group</label>
                                    <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="employee_group_id">
                                        <?php foreach ($employee_group as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['employee_group_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

</div>
<!-- container -->
<?= $this->endSection() ?>