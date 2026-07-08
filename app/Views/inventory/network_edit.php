<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory/network'); ?>">Network</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate action="<?= base_url('inventory/network_update'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <input type="hidden" class="form-control" name="id" value="<?= $list_data->id; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Kode Asset</label>
                                    <input type="text" class="form-control" value="<?= $list_data->kode_asset; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" value="<?= $list_data->name; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe</label>
                                    <input type="text" name="tipe" class="form-control" value="<?= $list_data->tipe; ?>">
                                </div>

                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">IP Address</label>
                                    <input type="text" name="ip_address" class="form-control" value="<?= $list_data->ip_address; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">MAC Address</label>
                                    <input type="text" name="mac_address" class="form-control" value="<?= $list_data->mac_address; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= $list_data->lokasi; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pengguna</label>
                                    <input type="text" name="pengguna" class="form-control" value="<?= $list_data->pengguna; ?>">
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Aktif" <?= $list_data->status == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="Nonaktif" <?= $list_data->status == 'Nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                                        <option value="Rusak" <?= $list_data->status == 'Rusak' ? 'selected' : ''; ?>>Rusak</option>
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