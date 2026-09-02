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

    <?php if (session('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-close-circle-line me-2"></i><?= session('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-line me-2"></i><?= session('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <a href="<?= base_url('digiman/board'); ?>" target="_blank" class="btn btn-primary">
                                <i class="mdi mdi-eye me-1"></i> Show
                            </a>
                        </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#tabIstirahat" data-bs-toggle="tab" aria-expanded="false" class="nav-link <?= (session('tab') == 'video') ? '' : 'active'; ?>" id="tab-istirahat-link">
                                <i class="mdi mdi-clock-outline me-1"></i> Jadwal Istirahat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabVideo" data-bs-toggle="tab" aria-expanded="true" class="nav-link <?= (session('tab') == 'video') ? 'active' : ''; ?>" id="tab-video-link">
                                <i class="mdi mdi-video-outline me-1"></i> Video
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- ===== TAB JADWAL ISTIRAHAT ===== -->
                        <div class="tab-pane <?= (session('tab') == 'video') ? '' : 'active'; ?>" id="tabIstirahat">
                            <div class="row mb-2">
                                <div class="col-xl-3 col-sm-12">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addIstirahat"><i class="mdi mdi-plus me-1"></i> Tambah Jam Istirahat</button>
                                    </div>
                                </div>
                            </div>
                            <table id="datatable-istirahat" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jam Istirahat</th>
                                        <th>Hari</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($istirahat as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->jam_istirahat; ?></td>
                                            <td><?= $row->hari_istirahat; ?></td>
                                            <td class="text-center">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editIstirahat<?= $row->id; ?>" class="action-icon text-info"><i class="mdi mdi-pencil"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('digiman/delete_istirahat/' . $row->id); ?>" onclick="event.preventDefault(); confirmDelete('Jadwal istirahat ini akan dihapus!', '<?= base_url('digiman/delete_istirahat/' . $row->id); ?>')" class="action-icon text-danger"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ===== END TAB JADWAL ISTIRAHAT ===== -->

                        <!-- ===== TAB VIDEO ===== -->
                        <div class="tab-pane <?= (session('tab') == 'video') ? 'active' : ''; ?>" id="tabVideo">
                            <div class="row mb-2">
                                <div class="col-xl-3 col-sm-12">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addVideo"><i class="mdi mdi-plus me-1"></i> Tambah Video</button>
                                    </div>
                                </div>
                            </div>
                            <table id="datatable-video" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Video</th>
                                        <th>Status</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($videos as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->video; ?></td>
                                            <td>
                                                <?php if ($row->status == 'aktif') : ?>
                                                    <span class="badge bg-success">Aktif</span>
                                                <?php else : ?>
                                                    <span class="badge bg-secondary">Non-Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editVideo<?= $row->id; ?>" class="action-icon text-info"><i class="mdi mdi-pencil"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('digiman/delete_video/' . $row->id); ?>" onclick="event.preventDefault(); confirmDelete('Video ini akan dihapus!', '<?= base_url('digiman/delete_video/' . $row->id); ?>')" class="action-icon text-danger"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ===== END TAB VIDEO ===== -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->

<!-- Modal Add Istirahat -->
<div class="modal fade" id="addIstirahat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('digiman/save_istirahat'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Jam Istirahat</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Jam Istirahat</label>
                                <input type="time" class="form-control <?= (validation_show_error('jam_istirahat')) ? 'is-invalid' : ''; ?>" name="jam_istirahat" value="<?= old('jam_istirahat'); ?>" required>
                                <div class="invalid-feedback"><?= validation_show_error('jam_istirahat'); ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Hari</label>
                                <select class="form-select <?= (validation_show_error('hari_istirahat')) ? 'is-invalid' : ''; ?>" name="hari_istirahat" required>
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin" <?= (old('hari_istirahat') == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                                    <option value="Selasa" <?= (old('hari_istirahat') == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                                    <option value="Rabu" <?= (old('hari_istirahat') == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                                    <option value="Kamis" <?= (old('hari_istirahat') == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                                    <option value="Jumat" <?= (old('hari_istirahat') == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                                    <option value="Sabtu" <?= (old('hari_istirahat') == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                                    <option value="Minggu" <?= (old('hari_istirahat') == 'Minggu') ? 'selected' : ''; ?>>Minggu</option>
                                </select>
                                <div class="invalid-feedback"><?= validation_show_error('hari_istirahat'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Istirahat -->
<?php foreach ($istirahat as $row) : ?>
    <div class="modal fade" id="editIstirahat<?= $row->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('digiman/save_istirahat'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $row->id; ?>">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Jam Istirahat</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Jam Istirahat</label>
                                    <input type="time" class="form-control" name="jam_istirahat" value="<?= $row->jam_istirahat; ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    <select class="form-select" name="hari_istirahat" required>
                                        <option value="Senin" <?= ($row->hari_istirahat == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                                        <option value="Selasa" <?= ($row->hari_istirahat == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                                        <option value="Rabu" <?= ($row->hari_istirahat == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                                        <option value="Kamis" <?= ($row->hari_istirahat == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                                        <option value="Jumat" <?= ($row->hari_istirahat == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                                        <option value="Sabtu" <?= ($row->hari_istirahat == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                                        <option value="Minggu" <?= ($row->hari_istirahat == 'Minggu') ? 'selected' : ''; ?>>Minggu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Add Video -->
<div class="modal fade" id="addVideo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('digiman/save_video'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Video</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Video</label>
                        <input type="file" class="form-control" name="video_file" accept="video/*" required>
                        <div class="mt-2 form-text">Video akan disimpan di folder <code>assets/video/</code></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif">Aktif</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Video -->
<?php foreach ($videos as $row) : ?>
    <div class="modal fade" id="editVideo<?= $row->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('digiman/save_video'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= $row->id; ?>">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Video</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">File Video</label>
                            <input type="file" class="form-control" name="video_file" accept="video/*">
                            <div class="mt-1 form-text">Kosongkan jika tidak ingin mengganti file. File saat ini: <code><?= $row->video; ?></code></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="aktif" <?= ($row->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="non-aktif" <?= ($row->status == 'non-aktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('#datatable-istirahat').DataTable({
            language: {
                paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" }
            },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            }
        });
        $('#datatable-video').DataTable({
            language: {
                paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" }
            },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            }
        });

        var activeTab = <?= json_encode(session('tab')); ?>;
        if (activeTab == 'video') {
            $('#tab-video-link').tab('show');
        }
    });

    function confirmDelete(message, url) {
        Swal.fire({
            title: 'Yakin?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
<?= $this->endSection() ?>
