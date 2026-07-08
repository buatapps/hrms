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
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="<?= base_url('history/log_plant_group_search') ?>">
                                <div class="row align-items-end">

                                    <!-- Start Date -->
                                    <div class="col-md-3">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control"
                                            value="<?= $start_date ?>">
                                    </div>

                                    <!-- End Date -->
                                    <div class="col-md-3">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control"
                                            value="<?= $end_date ?>">
                                    </div>

                                    <!-- Employee -->
                                    <div class="col-md-4">
                                        <label>Employee</label>
                                        <select name="employee_id" class="form-control select2" data-toggle="select2">
                                            <option value="">-- All Employee --</option>
                                            <?php foreach ($employees as $emp): ?>
                                                <option value="<?= $emp->id ?>"
                                                    <?= old('employee_id') == $emp->id ? 'selected' : '' ?>>
                                                    <?= $emp->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Button -->
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Search
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Division</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $log): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= date('d M Y H:i', strtotime($log->created_at)) ?></td>
                                    <td><?= $log->name; ?></td>
                                    <td><?= $log->employee_id; ?></td>
                                    <td><?= $log->division; ?></td>
                                    <td>
                                        <?= $log->old_plant; ?> - <?= $log->old_group; ?>
                                    </td>
                                    <td>
                                        <?= $log->new_plant; ?> - <?= $log->new_group; ?>
                                    </td>
                                    <td><?= $log->username; ?></td>
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