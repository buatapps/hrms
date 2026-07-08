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
                                <a href="<?= base_url('inventory/software_add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
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
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Software</th>
                                <th>Vendor</th>
                                <th>Versi</th>
                                <th>Lisensi Type</th>
                                <th>Platform</th>
                                <th>Tanggal Install</th>
                                <th>Expired</th>
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
                                    <td><?= esc($row->name); ?></td>
                                    <td><?= esc($row->vendor); ?></td>
                                    <td><?= esc($row->versi); ?></td>
                                    <td><?= esc($row->license_type); ?></td>
                                    <td><?= esc($row->platform); ?></td>
                                    <td><?= $row->tgl_instal ? date('d-m-Y', strtotime($row->tgl_instal)) : '-'; ?></td>
                                    <td><?= $row->tgl_expired ? date('d-m-Y', strtotime($row->tgl_expired)) : '-'; ?></td>
                                    <td><?= esc($row->lokasi); ?></td>
                                    <td><?= esc($row->pengguna); ?></td>
                                    <td>
                                        <span class="badge bg-<?= $row->status == 'Aktif' ? 'success' : 'secondary'; ?>">
                                            <?= esc($row->status); ?>
                                        </span>
                                    </td>
                                    <td><?= esc($row->keterangan); ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row->created_at)); ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row->updated_at)); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('inventory/software_edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('inventory/software_delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
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