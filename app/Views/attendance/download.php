<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('attendance_machine'); ?>">Attendance Machine</a></li>
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
                        <div class="col-xl-6 col-sm-11">
                            <form class="needs-validation" novalidate action="<?= base_url('attendance/download_log'); ?>" method="post" onsubmit="showLoading()">
                                <?= csrf_field(); ?>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Attendance Machine</label>
                                            <select name="attendance_machine_id" id="attendance_machine_id" class="form-control">
                                                <?php foreach ($attendance_machine as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $attendance_machine_id) ? 'selected' : null ?>><?= $row->name . ' - ' . $row->ip; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-sm-12">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="form-control btn btn-primary">Download</button>
                                        </div>
                                        <div class="col-xl-2 col-sm-12">
                                            <label class="form-label">&nbsp;</label>
                                            <a href="<?= base_url('attendance/download_all') ?>"
                                                class="btn btn-success form-control"
                                                onclick="showLoading()">
                                                Download All
                                            </a>
                                            <script>
                                                function handleDownload(el) {
                                                    el.innerHTML = 'Downloading...';
                                                    el.classList.add('disabled');
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end col-->
                    </div>
                    <?php if (session()->getFlashdata('success_list')): ?>
                        <div class="alert alert-success">
                            <strong>Success:</strong><br>
                            <?php foreach (session()->getFlashdata('success_list') as $s): ?>
                                - <?= $s ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('failed_list')): ?>
                        <div class="alert alert-danger">
                            <strong>Failed:</strong><br>
                            <?php foreach (session()->getFlashdata('failed_list') as $f): ?>
                                - <?= $f ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session('danger')) : ?>
                        <div class=" mt-2">
                            <div class="alert alert-danger" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('danger'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xl-12 col-sm-12">
                        <h4 class="mt-4">Log</h4>
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Attendance Machine</th>
                                    <th>PIN</th>
                                    <th>Name</th>
                                    <th>Employee ID</th>
                                    <th>Plant</th>
                                    <th>datetime</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($list_data as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->attendance_machine; ?></td>
                                        <td><?= $row->pin; ?></td>
                                        <td><?= strtoupper($row->name); ?></td>
                                        <td><?= $row->employee_id; ?></td>
                                        <td><?= $row->plant; ?></td>
                                        <td><?= $row->datetime; ?></td>
                                        <td><?= date('d/m/Y H:i:s', strtotime($row->created_at)); ?></td>
                                        <td><?= date('d/m/Y H:i:s', strtotime($row->updated_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<div id="loadingOverlay" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    color:#fff;
    font-size:20px;
">
    Downloading from machines, please wait...
</div>
<script>
    function showLoading() {
        const overlay = document.getElementById('loadingOverlay');
        overlay.style.display = 'flex';

        // disable semua klik
        document.body.style.pointerEvents = 'none';

        // tapi overlay tetap bisa tampil
        overlay.style.pointerEvents = 'all';
    }
</script>
<?= $this->endSection() ?>