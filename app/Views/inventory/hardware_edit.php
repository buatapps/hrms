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
                        <li class="breadcrumb-item"><a href="<?= base_url('inventory/hardware'); ?>">Hardware</a></li>
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
                    <form class="needs-validation" novalidate action="<?= base_url('inventory/hardware_update'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <input type="hidden" class="form-control" name="id" value="<?= $list_data->id; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Kode Asset</label>
                                    <input type="text" class="form-control" value="<?= $list_data->kode_asset; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $list_data->name; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="hardware_category_id" id="categorySelect" class="form-control">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($category as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->hardware_category_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="hardware_brand_id" id="brandSelect" class="form-control">
                                        <option value="">-- Pilih Brand --</option>
                                        <?php foreach ($brand as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->hardware_brand_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe</label>
                                    <input type="text" class="form-control" name="tipe" value="<?= $list_data->tipe; ?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Serial Number</label>
                                    <input type="text" class="form-control" name="serial_number" value="<?= $list_data->serial_number; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Spesifikasi</label>
                                    <textarea name="spesifikasi" class="form-control"><?= $list_data->spesifikasi; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control " value="<?= $list_data->lokasi; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pengguna</label>
                                    <input type="text" name="pengguna" class="form-control " value="<?= $list_data->pengguna; ?>">
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Perolehan</label>
                                    <input type="date" name="tgl_perolehan" class="form-control " value="<?= $list_data->tgl_perolehan; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control"><?= $list_data->keterangan; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Aktif" <?= ('Aktif' == $list_data->status) ? 'selected' : '' ?>>Aktif</option>
                                        <option value="Rusak" <?= ('Rusak' == $list_data->status) ? 'selected' : '' ?>>Rusak</option>
                                        <option value="Dipinjam" <?= ('Dipinjam' == $list_data->status) ? 'selected' : '' ?>>Dipinjam</option>
                                        <option value="Nonaktif" <?= ('Nonaktif' == $list_data->status) ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lampiran Baru (Opsional)</label>
                                    <input type="file" name="foto" class="form-control">
                                    <?php if ($list_data->foto): ?>
                                        <small>Foto lama: <a href="<?= base_url('inventory/' . $list_data->foto); ?>" target="_blank"><?= $list_data->foto; ?></a></small>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $('#categorySelect').on('change', function() {
                                        var categoryId = $(this).val();

                                        if (categoryId) {
                                            $.ajax({
                                                url: '<?= base_url('inventory/brand-by-category/') ?>' + categoryId,
                                                method: 'GET',
                                                dataType: 'json',
                                                success: function(response) {
                                                    $('#brandSelect').empty().append('<option value="">-- Pilih Brand --</option>');
                                                    $.each(response, function(i, item) {
                                                        $('#brandSelect').append(`<option value="${item.id}">${item.name}</option>`);
                                                    });
                                                },
                                                error: function() {
                                                    alert('Gagal memuat brand');
                                                }
                                            });
                                        } else {
                                            $('#brandSelect').empty().append('<option value="">-- Pilih Brand --</option>');
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- container -->
<?= $this->endSection() ?>