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
                        <li class="breadcrumb-item"><a href="<?= base_url('contract'); ?>">Contract</a></li>
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
                                <a href="<?= base_url('contract/add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
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
                    <form class="needs-validation" novalidate
                        action="<?= base_url('contract/search'); ?>"
                        method="post">

                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-xl-2 col-sm-6 mb-3">
                                <label class="form-label">Date Type</label>
                                <select name="date_type" class="form-select">
                                    <option value="start_date"
                                        <?= (old('date_type') == 'start_date' || !old('date_type')) ? 'selected' : '' ?>>
                                        Start Date
                                    </option>
                                    <option value="end_date"
                                        <?= (old('date_type') == 'end_date') ? 'selected' : '' ?>>
                                        End Date
                                    </option>
                                </select>
                            </div>

                            <!-- Month -->
                            <div class="col-xl-2 col-sm-6 mb-3">
                                <label class="form-label">Month</label>
                                <select name="month" class="form-select">
                                    <option value="">-- All Month --</option>
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?= $m ?>"
                                            <?= (old('month') == $m || (!old('month') && date('n') == $m)) ? 'selected' : '' ?>>
                                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Year -->
                            <div class="col-xl-2 col-sm-6 mb-3">
                                <label class="form-label">Year</label>
                                <select name="year" class="form-select">
                                    <option value="">-- All Year --</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($y = $currentYear; $y >= $currentYear - 5; $y--):
                                    ?>
                                        <option value="<?= $y ?>"
                                            <?= (old('year') == $y || (!old('year') && date('Y') == $y)) ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Division -->
                            <div class="col-xl-2 col-sm-6 mb-3">
                                <label class="form-label">Division</label>
                                <select name="division_id" class="form-select">
                                    <option value="">-- All Division --</option>
                                    <?php foreach ($divisions as $div): ?>
                                        <option value="<?= $div->id ?>"
                                            <?= (old('division_id') == $div->id) ? 'selected' : '' ?>>
                                            <?= $div->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-xl-2 col-sm-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="contract_statuses_id" class="form-select">
                                    <option value="">-- All Status --</option>
                                    <?php
                                    foreach ($statuses as $status):
                                    ?>
                                        <option value="<?= $status->id ?>"
                                            <?= (old('contract_statuses_id') == $status->id) ? 'selected' : '' ?>>
                                            <?= $status->code ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Button -->
                            <div class="col-xl-2 col-sm-12 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    🔍 Search
                                </button>
                            </div>

                        </div>
                    </form>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Division</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Contract</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-center">Print</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row) : ?>
                                <?php
                                $now = strtotime(date('Y-m-t')); // awal bulan sekarang
                                $end = strtotime($row->end_date);
                                $isExpiredActive =
                                    $row->contract_statuses_id == 2 && $end <= $now;
                                ?>
                                <tr class="<?= $isExpiredActive ? 'table-expired' : '' ?>">
                                    <td><?= $no++; ?></td>
                                    <td><?= strtoupper($row->name); ?></td>
                                    <td><?= $row->position; ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td><?= $row->contract_types; ?></td>
                                    <td><?= date('d-M-Y', strtotime($row->start_date)); ?></td>
                                    <td><?= date('d-M-Y', strtotime($row->end_date)); ?></td>
                                    <td class="<?= 'text-' . $row->class; ?>"><?= $row->contract_statuses; ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row->created_at)); ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row->updated_at)); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('contract/print/' . $row->id); ?>" class="action-icon text-primary" target="_blank"> <i class="mdi mdi-printer"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('contract/edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('contract/delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
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