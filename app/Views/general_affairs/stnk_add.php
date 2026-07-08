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
                        <li class="breadcrumb-item"><a href="<?= base_url('general_affairs/stnk'); ?>">STNK</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('general_affairs/stnk_save'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" class="form-select select2" data-toggle="select2" required>
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= strtoupper($row->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama STNK</label>
                                    <input type="text" class="form-control" name="nama_stnk" value="<?= old('nama_stnk'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kendaraan</label>
                                    <select name="kendaraan" class="form-control">
                                        <option value="MOTOR">MOTOR</option>
                                        <option value="MOBIL">MOBIL</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor Plat</label>
                                    <input type="text" class="form-control" name="nomor_plat" value="<?= old('nomor_plat'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand" class="form-control">
                                        <option value="YAMAHA">YAMAHA</option>
                                        <option value="HONDA">HONDA</option>
                                        <option value="KAWASAKI">KAWASAKI</option>
                                        <option value="TVS">TVS</option>
                                        <option value="VESPA">VESPA</option>
                                        <option value="SUZUKI">SUZUKI</option>
                                        <option value="TOYOTA">TOYOTA</option>
                                        <option value="DAIHATSU">DAIHATSU</option>
                                        <option value="MITSUBISHI">MITSUBISHI</option>
                                        <option value="WULING">WULING</option>
                                        <option value="KIA">KIA</option>
                                        <option value="BMW">BMW</option>
                                        <option value="NISSAN">NISSAN</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Kendaraan</label>
                                    <select name="tipe_kendaraan" class="form-control">
                                        <option value="MATIC">MATIC</option>
                                        <option value="BEBEK">BEBEK / UNDERBONE</option>
                                        <option value="SPORT">SPORT</option>
                                        <option value="NAKED">NAKED</option>
                                        <option value="TRIAL">TRIAL / OFF-ROAD</option>
                                        <option value="MANUAL">MANUAL</option>
                                        <option value="HYBRID">HYBRID</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku Pajak Tahunan Kendaraan</label>
                                    <input type="date" class="form-control" name="masa_berlaku_pajak" value="<?= old('masa_berlaku_pajak'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku Pajak Plat Nomor (5 tahunan)</label>
                                    <input type="date" class="form-control" name="masa_berlaku_plat" value="<?= old('masa_berlaku_plat'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">STNK (Surat Tanda Nomor Kendaraan)</label>
                                    <input type="file" class="form-control" name="file_stnk">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">STNK yang memuat pajak tahunan</label>
                                    <input type="file" class="form-control" name="file_stnk_pajak">
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Foto Kendaraan Tampak Depan</label>
                                    <input type="file" class="form-control" name="foto_tampak_depan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Kendaraan Tampak Samping Kanan</label>
                                    <input type="file" class="form-control" name="foto_tampak_samping">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Kendaraan Tampak Belakang</label>
                                    <input type="file" class="form-control" name="foto_tampak_belakang">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>