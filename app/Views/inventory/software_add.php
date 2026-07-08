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
                    <form class="needs-validation" novalidate action="<?= base_url('inventory/software_save'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Software</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Vendor</label>
                                    <input type="text" class="form-control" name="vendor">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Versi</label>
                                    <input type="text" class="form-control" name="versi">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Lisensi</label>
                                    <input type="text" class="form-control" name="license_type">
                                </div>

                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Lisensi Key</label>
                                    <input type="text" class="form-control" name="license_key">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Lisensi</label>
                                    <input type="number" class="form-control" name="jumlah_lisensi" min="1">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Platform</label>
                                    <input type="text" class="form-control" name="platform" placeholder="Contoh: Windows, Linux">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Install</label>
                                    <input type="date" name="tgl_instal" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Expired</label>
                                    <input type="date" name="tgl_expired" class="form-control">
                                </div>

                            </div>

                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pengguna</label>
                                    <input type="text" name="pengguna" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Aktif">Aktif</option>
                                        <option value="Kadaluarsa">Kadaluarsa</option>
                                        <option value="Nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lampiran</label>
                                    <input type="file" name="lampiran" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>