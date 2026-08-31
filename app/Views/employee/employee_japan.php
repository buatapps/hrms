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
                    <h1>人事データ (Jinji Deeta)</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-sm-12">
                            <h5>Filter</h5>
                            <form action="<?= base_url('employee/search'); ?>" method="post">
                                <div class="row">
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="gender_id">
                                                <option value="">Gender</option>
                                                <?php foreach ($gender as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="employee_status_id">
                                                <option value="">Employee Status</option>
                                                <?php foreach ($employee_status as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="plant_id">
                                                <option value="">Plant</option>
                                                <?php foreach ($plant as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="employee_group_id">
                                                <option value="">Group</option>
                                                <?php foreach ($group as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="division_id">
                                                <?php if (!in_groups('admin')) { ?>
                                                    <option value="">Division</option>
                                                <?php } ?>
                                                <?php foreach ($division as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $division_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="company_id">
                                                <option value="">Company</option>
                                                <?php foreach ($company as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $company_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-info"><i class="mdi mdi-magnify"></i> Search</button>
                                        </div>
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
                    <!-- <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap"> -->
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Age</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th>Employee Status</th>
                                <th>Product Synchronization</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Start Join</th>
                                <th>Contract</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row) : ?>
                                <?php
                                $birthdate = new DateTime($row->date_of_birth);
                                $today = new DateTime('now');
                                $age = $today->diff($birthdate);
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->employee_id; ?></td>
                                    <td><?= $age->y; ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->position; ?></td>
                                    <td><?= $row->employee_status; ?></td>
                                    <td><?= $row->product_synchronization; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->date_of_entry)); ?></td>
                                    <td><?= esc($row->latest_contract_types_name ?? '') ?></a></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/details/' . $row->id); ?>" target="_blank" class="action-icon text-dark"> <i class="mdi mdi-eye"></i></a>
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
<script>
    document.getElementById('btn-export').addEventListener('click', function(e) {
        e.preventDefault();

        // Tampilkan spinner
        document.getElementById('loading').style.display = 'block';

        // Ambil form terdekat
        const form = this.closest('form');

        // Kasih jeda biar loading kelihatan
        setTimeout(function() {
            form.submit(); // Submit form POST seperti biasa
        }, 500); // 0.5 detik cukup biar loading muncul
    });
</script>
<!-- container -->
<?= $this->endSection() ?>