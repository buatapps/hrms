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
                        <li class="breadcrumb-item"><a href="<?= base_url('general_affairs/sim'); ?>">SIM</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('general_affairs/sim_save'); ?>" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label">Tipe SIM</label>
                                    <select name="tipe_sim" class="form-control">
                                        <option value="SIMA">SIM A</option>
                                        <option value="SIMB1">SIM B1</option>
                                        <option value="SIMB2">SIM B2</option>
                                        <option value="SIMC" selected="">SIM C</option>
                                        <option value="SIMC1">SIM C1</option>
                                        <option value="SIMC2">SIM C2</option>
                                        <option value="SIMD">SIM D</option>
                                        <option value="SIMD1">SIM D1</option>
                                        <option value="SIMINTERNASIONAL">SIM INTERNASIONAL</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Masa Berlaku</label>
                                    <input type="date" class="form-control" name="masa_berlaku" value="<?= old('masa_berlaku'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SIM</label>
                                    <input type="file" class="form-control" name="file_sim">
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