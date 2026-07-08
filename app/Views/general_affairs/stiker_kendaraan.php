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
                        <div class="row">
                            <div class="col-xl-10">
                                <form action="<?= base_url('general_affairs/search_stiker'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label class="form-label">Division</label>
                                            <select name="division_id" class="form-control">
                                                <option value="0">-- All --</option>
                                                <?php foreach ($division as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $division_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-1">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="d-grid">
                                    <label class="form-label">&nbsp;</label>
                                    <a href="<?= base_url('general_affairs/stikerPrintAll/' . $division_id); ?>" class="btn btn-success" target="_blank">PrintAll</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">

                        <div class="col-xl-2 col-sm-12">
                            <div class="d-grid">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" form="print-checked-form" class="btn btn-warning">Print Checked</button>
                            </div>
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

                    <form action="<?= base_url('general_affairs/print_checked'); ?>" method="post" id="print-checked-form" target="_blank">
                        <?= csrf_field(); ?>
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Plat Nomor</th>
                                    <th>Division</th>
                                    <th>Position</th>
                                    <th>Plant</th>
                                    <th>Group</th>
                                    <th class="text-center">Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list_data as $row): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checked_ids[]" value="<?= $row->id; ?>" class="form-check-input row-check">
                                        </td>
                                        <td><?= $no++; ?></td>
                                        <td><?= strtoupper($row->name); ?></td>
                                        <td><?= $row->nomor_plat; ?></td>
                                        <td><?= $row->division; ?></td>
                                        <td><?= $row->position; ?></td>
                                        <td><?= $row->plant; ?></td>
                                        <td><?= $row->employee_group; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('general_affairs/print/' . $row->id); ?>" class="btn btn-success" target="_blank"><span class="mdi mdi-printer"></span></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                    <script>
                        document.getElementById('checkAll').addEventListener('change', function() {
                            document.querySelectorAll('.row-check').forEach(cb => {
                                cb.checked = this.checked;
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>