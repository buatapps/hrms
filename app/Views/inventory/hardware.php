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
                                <a href="<?= base_url('inventory/hardware_add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
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
                    <form class="needs-validation" novalidate action="<?= base_url('inventory/hardware_search'); ?>" method="post">
                        <?php csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="hardware_category_id" class="form-control">
                                        <option value="0">-- All --</option>
                                        <?php foreach ($category as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $hardware_category_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-sm btn-info">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Asset</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Tipe</th>
                                <th>Lokasi</th>
                                <th>Pengguna</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->kode_asset; ?></td>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->hardware_category; ?></td>
                                    <td><?= $row->hardware_brand; ?></td>
                                    <td><?= $row->tipe; ?></td>
                                    <td><?= $row->lokasi; ?></td>
                                    <td><?= $row->pengguna; ?></td>
                                    <td>
                                        <span class="badge bg-<?= $row->status == 'Aktif' ? 'success' : ($row->status == 'Rusak' ? 'danger' : 'secondary'); ?>">
                                            <?= esc($row->status); ?>
                                        </span>
                                    </td>
                                    <td><?= $row->keterangan; ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row->created_at)); ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row->updated_at)); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('inventory/hardware_edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('inventory/hardware_delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
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