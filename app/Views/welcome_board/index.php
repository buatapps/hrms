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
                                <a href="<?= base_url('welcome_board/add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
                            </div>
                        </div><!-- end col-->
                        <div class="col-xl-9 col-sm-12"></div>
                        <div class="col-xl-1 col-sm-12">
                            <div class="mt-2">
                                <a href="<?= base_url('welcome_board/view'); ?>" target="_blank" class="btn btn-danger mb-2 me-2 btn-block">VIEW</a>
                            </div>
                        </div>
                    </div>
                    <?php if (session('success')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Guest</th>
                                <th>Topic</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Number of Guest</th>
                                <th class="text-center">Active Status</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->topic; ?></td>
                                    <td><?= $row->start_date; ?></td>
                                    <td><?= $row->end_date; ?></td>
                                    <td><?= $row->start_time; ?></td>
                                    <td><?= $row->end_time; ?></td>
                                    <td class="text-center"><?= $row->number_member; ?></td>
                                    <td class="text-center">
                                        <?php if ($row->active == 1) { ?>
                                            <a href="<?= base_url('welcome_board/non_active/' . $row->id); ?>" class="btn btn-success">ACTIVE</a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('welcome_board/active/' . $row->id); ?>" class="btn btn-danger">NON ACTIVE</a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('guest/edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('guest/delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
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