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
                        <div class="col-xl-10">
                            <form action="<?= base_url('general_affairs/search_stiker'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col-xl-2">
                                        <label class="form-label">Division</label>
                                        <select name="division_id" class="form-control">
                                            <option value="0">-- All --</option>
                                            <?php foreach ($division as $row): ?>
                                                <option value="<?= $row->id; ?>" <?= ($row->id == $division_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-1">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-2 col-sm-12">
                            <div class="d-grid">
                                <label class="form-label">&nbsp;</label>
                                <a href="<?= base_url('general_affairs/stikerPrintAll/' . $division_id); ?>" class="btn btn-success" target="_blank">PrintAll</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-xl-2 col-sm-12">
                            <div class="d-grid">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" form="print-checked-form" class="btn btn-warning">Print Checked</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-12 offset-xl-6">
                            <label class="form-label">Search</label>
                            <input type="text" id="cardSearch" class="form-control" placeholder="Cari nama / NIK / plat / division / kendaraan...">
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

                    <form action="<?= base_url('general_affairs/print_checked'); ?>" method="post" id="print-checked-form" target="_blank">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <?php foreach ($list_data as $row): ?>
                                <div class="col-xl-3 col-md-4 col-sm-6 vehicle-col">
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body pb-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="text-uppercase mb-0"><?= esc($row->name); ?></h5>
                                                    <span class="badge bg-dark mt-1"><?= esc($row->nomor_plat); ?></span>
                                                </div>
                                                <input type="checkbox" name="checked_ids[]" value="<?= $row->id; ?>" class="form-check-input row-check">
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <hr class="my-2">
                                            <div class="row font-13">
                                                <div class="col-6 text-muted">Division</div>
                                                <div class="col-6 text-end"><?= esc($row->division); ?></div>
                                                <div class="col-6 text-muted">Position</div>
                                                <div class="col-6 text-end"><?= esc($row->position); ?></div>
                                                <div class="col-6 text-muted">Plant</div>
                                                <div class="col-6 text-end"><?= esc($row->plant); ?></div>
                                                <div class="col-6 text-muted">Group</div>
                                                <div class="col-6 text-end"><?= esc($row->employee_group); ?></div>
                                                <div class="col-6 text-muted">Kendaraan</div>
                                                <div class="col-6 text-end"><?= esc($row->kendaraan); ?></div>
                                                <div class="col-6 text-muted">Brand</div>
                                                <div class="col-6 text-end"><?= esc($row->brand); ?></div>
                                                <div class="col-6 text-muted">Pajak</div>
                                                <div class="col-6 text-end"><?= esc($row->masa_berlaku_pajak); ?></div>
                                                <div class="col-6 text-muted">Plat Berlaku</div>
                                                <div class="col-6 text-end"><?= esc($row->masa_berlaku_plat); ?></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center bg-light">
                                            <a href="<?= base_url('general_affairs/print/' . $row->id); ?>" target="_blank" class="btn btn-success btn-sm"><span class="mdi mdi-printer me-1"></span>Print</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </form>
                    <script>
                        document.getElementById('checkAll')?.addEventListener('change', function() {
                            document.querySelectorAll('.row-check').forEach(cb => {
                                cb.checked = this.checked;
                            });
                        });

                        document.getElementById('cardSearch').addEventListener('keyup', function() {
                            const q = this.value.toLowerCase();
                            document.querySelectorAll('.vehicle-col').forEach(col => {
                                col.style.display = col.textContent.toLowerCase().includes(q) ? '' : 'none';
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>
