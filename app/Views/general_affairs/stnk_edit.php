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

                    <form class="needs-validation" novalidate action="<?= base_url('general_affairs/stnk_update/' . $list_data->id); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" class="form-select select2" data-toggle="select2" required>
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->employee_id) ? 'selected' : null ?>><?= strtoupper($row->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama STNK</label>
                                    <input type="text" class="form-control" name="nama_stnk" value="<?= old('nama_stnk', $list_data->nama_stnk); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kendaraan</label>
                                    <select name="kendaraan" class="form-control">
                                        <option value="MOTOR" <?= ("MOTOR" ==  $list_data->kendaraan) ? 'selected' : null ?>>MOTOR</option>
                                        <option value="MOBIL" <?= ("MOBIL" ==  $list_data->kendaraan) ? 'selected' : null ?>>MOBIL</option>
                                        <option value="LAINNYA" <?= ("LAINNYA" ==  $list_data->kendaraan) ? 'selected' : null ?>>LAINNYA</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor Plat</label>
                                    <input type="text" class="form-control" name="nomor_plat" value="<?= old('nomor_plat', $list_data->nomor_plat); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand" class="form-control">
                                        <option value="YAMAHA" <?= ("YAMAHA" == $list_data->brand) ? 'selected' : null ?>>YAMAHA</option>
                                        <option value="HONDA" <?= ("HONDA" == $list_data->brand) ? 'selected' : null ?>>HONDA</option>
                                        <option value="KAWASAKI" <?= ("KAWASAKI" == $list_data->brand) ? 'selected' : null ?>>KAWASAKI</option>
                                        <option value="TVS" <?= ("TVS" == $list_data->brand) ? 'selected' : null ?>>TVS</option>
                                        <option value="VESPA" <?= ("VESPA" == $list_data->brand) ? 'selected' : null ?>>VESPA</option>
                                        <option value="SUZUKI" <?= ("SUZUKI" == $list_data->brand) ? 'selected' : null ?>>SUZUKI</option>
                                        <option value="TOYOTA" <?= ("TOYOTA" == $list_data->brand) ? 'selected' : null ?>>TOYOTA</option>
                                        <option value="DAIHATSU" <?= ("DAIHATSU" == $list_data->brand) ? 'selected' : null ?>>DAIHATSU</option>
                                        <option value="MITSUBISHI" <?= ("MITSUBISHI" == $list_data->brand) ? 'selected' : null ?>>MITSUBISHI</option>
                                        <option value="WULING" <?= ("WULING" == $list_data->brand) ? 'selected' : null ?>>WULING</option>
                                        <option value="KIA" <?= ("KIA" == $list_data->brand) ? 'selected' : null ?>>KIA</option>
                                        <option value="BMW" <?= ("BMW" == $list_data->brand) ? 'selected' : null ?>>BMW</option>
                                        <option value="NISSAN" <?= ("NISSAN" == $list_data->brand) ? 'selected' : null ?>>NISSAN</option>
                                        <option value="LAINNYA">LAINNYA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Kendaraan</label>
                                    <select name="tipe_kendaraan" class="form-control">
                                        <option value="MATIC" <?= ("MATIC" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>MATIC</option>
                                        <option value="BEBEK <?= ("BEBEK" == $list_data->tipe_kendaraan) ? 'selected' : null ?>">BEBEK / UNDERBONE</option>
                                        <option value="SPORT" <?= ("SPORT" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>SPORT</option>
                                        <option value="NAKED" <?= ("NAKED" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>NAKED</option>
                                        <option value="TRIAL" <?= ("TRIAL" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>TRIAL / OFF-ROAD</option>
                                        <option value="MANUAL" <?= ("MANUAL" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>MANUAL</option>
                                        <option value="HYBRID" <?= ("HYBRID" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>HYBRID</option>
                                        <option value="LAINNYA" <?= ("LAINNYA" == $list_data->tipe_kendaraan) ? 'selected' : null ?>>LAINNYA</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku Pajak Tahunan Kendaraan</label>
                                    <input type="date" class="form-control" name="masa_berlaku_pajak" value="<?= old('masa_berlaku_pajak', $list_data->masa_berlaku_pajak); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku Pajak Plat Nomor (5 tahunan)</label>
                                    <input type="date" class="form-control" name="masa_berlaku_plat" value="<?= old('masa_berlaku_plat', $list_data->masa_berlaku_plat); ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">STNK (Surat Tanda Nomor Kendaraan)</label>
                                            <input type="file" class="form-control" name="file_stnk">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-2">
                                        <div class="mb-3">
                                            <div class="d-grid">
                                                <input type="hidden" class="form-control" name="old_file_stnk" value="<?= $list_data->file_stnk; ?>">
                                                <label class="form-label">&nbsp;</label>
                                                <a href="<?= base_url('kendaraan/' . $list_data->file_stnk); ?>" target="_blank" class="btn btn-warning"><span class="mdi mdi-image"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">STNK yang memuat pajak tahunan</label>
                                            <input type="file" class="form-control" name="file_stnk_pajak">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-2">
                                        <div class="mb-3 d-grid">
                                            <input type="hidden" class="form-control" name="old_file_stnk_pajak" value="<?= $list_data->file_stnk_pajak; ?>">
                                            <label class="form-label">&nbsp;</label>
                                            <a href="<?= base_url('kendaraan/' . $list_data->file_stnk_pajak); ?>" target="_blank" class="btn btn-warning"><span class="mdi mdi-image"></span></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-10 col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">Foto Kendaraan Tampak Depan</label>
                                            <input type="file" class="form-control" name="foto_tampak_depan">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-2">
                                        <div class="mb-3 d-grid">
                                            <input type="hidden" class="form-control" name="old_foto_tampak_depan" value="<?= $list_data->foto_tampak_depan; ?>">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <a href="<?= base_url('kendaraan/' . $list_data->foto_tampak_depan); ?>" target="_blank" class="btn btn-warning"><span class="mdi mdi-image"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">Foto Kendaraan Tampak Samping Kanan</label>
                                            <input type="file" class="form-control" name="foto_tampak_samping">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-2">
                                        <div class="mb-3 d-grid">
                                            <input type="hidden" class="form-control" name="old_foto_tampak_samping" value="<?= $list_data->foto_tampak_samping; ?>">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <a href="<?= base_url('kendaraan/' . $list_data->foto_tampak_samping); ?>" target="_blank" class="btn btn-warning"><span class="mdi mdi-image"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-sm-10">
                                        <div class="mb-3">
                                            <label class="form-label">Foto Kendaraan Tampak Belakang</label>
                                            <input type="file" class="form-control" name="foto_tampak_belakang">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-2">
                                        <div class="mb-3 d-grid">
                                            <input type="hidden" class="form-control" name="old_foto_tampak_belakang" value="<?= $list_data->foto_tampak_belakang; ?>">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <a href="<?= base_url('kendaraan/' . $list_data->foto_tampak_belakang); ?>" target="_blank" class="btn btn-warning"><span class="mdi mdi-image"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>