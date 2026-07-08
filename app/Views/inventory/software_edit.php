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
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory/software'); ?>">Software</a></li>
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
                    <form class="needs-validation" novalidate action="<?= base_url('inventory/software_update'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <input type="hidden" class="form-contol" name="id" value="<?= $list_data->id; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Kode Asset</label>
                                    <input type="text" class="form-control" value="<?= $list_data->kode_asset; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Software</label>
                                    <input type="text" class="form-control" name="name" value="<?= $list_data->name; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Vendor</label>
                                    <input type="text" class="form-control" name="vendor" value="<?= $list_data->vendor; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Versi</label>
                                    <input type="text" class="form-control" name="versi" value="<?= $list_data->versi; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Lisensi</label>
                                    <input type="text" class="form-control" name="license_type" value="<?= $list_data->license_type; ?>">
                                </div>

                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Lisensi Key</label>
                                    <input type="text" class="form-control" name="license_key" value="<?= $list_data->license_key; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Lisensi</label>
                                    <input type="number" class="form-control" name="jumlah_lisensi" value="<?= $list_data->jumlah_lisensi; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Platform</label>
                                    <input type="text" class="form-control" name="platform" placeholder="Contoh: Windows, Linux" value="<?= $list_data->platform; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Install</label>
                                    <input type="date" name="tgl_instal" class="form-control" value="<?= $list_data->tgl_instal; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Expired</label>
                                    <input type="date" name="tgl_expired" class="form-control" value="<?= $list_data->tgl_expired; ?>">
                                </div>

                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= $list_data->lokasi; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pengguna</label>
                                    <input type="text" name="pengguna" class="form-control" value="<?= $list_data->pengguna; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Aktif" <?= ('Aktif' == $list_data->status) ? 'selected' : null ?>>Aktif</option>
                                        <option value="Kadaluarsa" <?= ('Kadaluarsa' == $list_data->status) ? 'selected' : null ?>>Kadaluarsa</option>
                                        <option value="Nonaktif" <?= ('Nonaktif' == $list_data->status) ? 'selected' : null ?>>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"><?= $list_data->keterangan; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lampiran Baru (Opsional)</label>
                                    <input type="file" name="lampiran" class="form-control">
                                    <?php if ($list_data->lampiran): ?>
                                        <small>Lampiran lama: <a href="<?= base_url('inventory/' . $list_data->lampiran); ?>" target="_blank"><?= $list_data->lampiran; ?></a></small>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>