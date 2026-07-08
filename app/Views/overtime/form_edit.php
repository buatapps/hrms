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
                        <li class="breadcrumb-item"><a href="<?= base_url('overtime/form'); ?>">Form</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('overtime/form_update/' . $header_data->id); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-2 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" value="<?= $header_data->date; ?>">
                            </div>
                        </div>
                        <hr>

                        <div id="detail-container">
                            <div class="row mb-2 detail-row">
                                <?php foreach ($detail_data as $row): ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select name="employee_id[]" class="form-control select2" required>
                                                    <option value="">-- Pilih Karyawan --</option>
                                                    <?php foreach ($employees as $e): ?>
                                                        <option value="<?= $e->id ?>" <?= ($e->id == $row->employee_id) ? 'selected' : '' ?>><?= $e->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="jobdesk[]" class="form-control" value="<?= $row->jobdesk; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <select name="total_hours[]" class="form-control" required>
                                                    <option value="">-- Jam --</option>
                                                    <?php for ($i = 0.5; $i <= 14; $i += 0.5): ?>
                                                        <option value="<?= number_format($i, 1) ?>" <?= $i == $row->total_hours ? 'selected' : '' ?>>
                                                            <?= number_format($i, 1) ?> jam
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-center">
                                            <div class="mb-3">
                                                <a href="<?= base_url('overtime/delete_employee/' . $row->header_id . '/' . $row->id); ?>" class="btn btn-danger btn-sm">&times;</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <select name="employee_id[]" class="form-control select2" required>
                                                <option value="">-- Pilih Karyawan --</option>
                                                <?php foreach ($employees as $e): ?>
                                                    <option value="<?= $e->id ?>"><?= $e->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="jobdesk[]" class="form-control" placeholder="Jobdesk" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <select name="total_hours[]" class="form-control" required>
                                                <option value="">-- Jam --</option>
                                                <?php for ($i = 0.5; $i <= 14; $i += 0.5): ?>
                                                    <option value="<?= number_format($i, 1) ?>" <?= $i == 3.0 ? 'selected' : '' ?>>
                                                        <?= number_format($i, 1) ?> jam
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-row" class="btn btn-secondary btn-sm mb-3">+ Add</button>

                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2(); // Init awal

        document.getElementById('add-row').addEventListener('click', function() {
            const container = document.getElementById('detail-container');

            // Buat elemen baru
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'detail-row');
            newRow.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <select name="employee_id[]" class="form-control select2" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php foreach ($employees as $e): ?>
                                <option value="<?= $e->id ?>"><?= $e->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <input type="text" name="jobdesk[]" class="form-control" placeholder="Jobdesk" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <select name="total_hours[]" class="form-control" required>
                            <option value="">-- Jam --</option>
                            <?php for ($i = 0.5; $i <= 14; $i += 0.5): ?>
                                <option value="<?= number_format($i, 1) ?>" <?= $i == 3.0 ? 'selected' : '' ?>>
                                    <?= number_format($i, 1) ?> jam
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <div class="mb-3">
                        <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                    </div>
                </div>
            </div>
            `;
            container.appendChild(newRow);

            // Re-init Select2
            $(newRow).find('.select2').select2();
        });

        // Hapus row
        document.getElementById('detail-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const rows = document.querySelectorAll('.detail-row');
                if (rows.length > 1) {
                    e.target.closest('.detail-row').remove();
                }
            }
        });
    });
</script>
<!-- container -->
<?= $this->endSection() ?>