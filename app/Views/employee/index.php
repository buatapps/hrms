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
                    <div class="row">
                        <div class="col-xl-12 col-sm-12">
                            <h5>Filter</h5>
                            <form action="<?= base_url('employee/search'); ?>" method="post">
                                <div class="row">
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="gender_id">
                                                <option value="">Gender</option>
                                                <?php foreach ($gender as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="employee_status_id">
                                                <option value="">Employee Status</option>
                                                <?php foreach ($employee_status as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="plant_id">
                                                <option value="">Plant</option>
                                                <?php foreach ($plant as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-1 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="employee_group_id">
                                                <option value="">Group</option>
                                                <?php foreach ($group as $row): ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="division_id">
                                                <?php if (!in_groups('admin')) { ?>
                                                    <option value="">Division</option>
                                                <?php } ?>
                                                <?php foreach ($division as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $division_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="mb-0">
                                            <select class="form-control" name="company_id">
                                                <option value="">Company</option>
                                                <?php foreach ($company as $row): ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $company_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-info"><i class="mdi mdi-magnify"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-2 col-sm-12">
                            <h5>&nbsp;</h5>
                            <form action="<?= base_url('employee/export_excel'); ?>" method="post" id="export-employee-form">
                                <input type="hidden" class="form-control" name="gender_id" value="<?= $gender_id; ?>">
                                <input type="hidden" class="form-control" name="employee_status_id" value="<?= $employee_status_id; ?>">
                                <input type="hidden" class="form-control" name="division_id" value="<?= $division_id; ?>">
                                <input type="hidden" class="form-control" name="plant_id" value="<?= $plant_id; ?>">
                                <input type="hidden" class="form-control" name="employee_group_id" value="<?= $employee_group_id; ?>">
                                <input type="hidden" class="form-control" name="company_id" value="<?= $company_id; ?>">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success" id="btn-export">
                                        <i class="mdi mdi-file-excel"></i> Export
                                    </button>
                                </div>
                            </form>

                        </div><!-- end col-->
                        <?php if (in_groups(['superadmin', 'admin'])) : ?>
                            <div class="col-xl-2 col-sm-12">
                                <h5>&nbsp;</h5>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-warning text-nowrap" data-bs-toggle="modal" data-bs-target="#importEmployeeModal">
                                        <i class="mdi mdi-upload"></i> Import Excel
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-xl-3 col-sm-12 ms-xl-auto">
                            <h5>&nbsp;</h5>
                            <div class="d-grid">
                                <a href="<?= base_url('employee/non-aktif'); ?>" class="btn btn-danger text-nowrap"><i class="mdi mdi-account-off"></i> Employee Non-active</a>
                            </div>
                        </div>
                        <div id="loading" style="display: none; margin-top: 1rem;">
                            <i class="mdi mdi-loading mdi-spin" style="font-size: 24px;"></i>
                            <span style="margin-left: 0.5rem;">Sedang menyiapkan file...</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!in_groups('admin')) { ?>
                <div class="card">
                    <div class="card-body">
                        <h4>Manajemen Japan</h4>

                        <div class="d-flex flex-nowrap overflow-auto gap-3">

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-light text-muted rounded">
                                            <i class="ri-group-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['total']; ?></h4>
                                        <small class="text-muted">Data Registrasi</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-danger-lighten text-danger rounded">
                                            <i class="ri-user-fill"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['nonactive']; ?></h4>
                                        <small class="text-muted">Non Active</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Active -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-primary-lighten text-primary rounded">
                                            <i class="ri-user-heart-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['totalActive']; ?></h4>
                                        <small class="text-muted">Total Employee</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-success-lighten text-success rounded">
                                            <i class="ri-user-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['activePermanent']; ?></h4>
                                        <small class="text-muted">Active Permanent</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-info-lighten text-info rounded">
                                            <i class="ri-contacts-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['activeContract']; ?></h4>
                                        <small class="text-muted">Active Contract</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-primary-lighten text-primary rounded">
                                            <i class="ri-user-2-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['men']; ?></h4>
                                        <small class="text-muted">Men</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-warning-lighten text-warning rounded">
                                            <i class="ri-user-3-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $japan['women']; ?></h4>
                                        <small class="text-muted">Women</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4>PT Namicoh Indonesia Component</h4>

                        <div class="d-flex flex-nowrap overflow-auto gap-3">

                            <!-- Total -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-light text-muted rounded">
                                            <i class="ri-group-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['total']; ?></h4>
                                        <small class="text-muted">Data Registrasi</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Non Active -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-danger-lighten text-danger rounded">
                                            <i class="ri-user-fill"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['nonactive']; ?></h4>
                                        <small class="text-muted">Non Active</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Active -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-primary-lighten text-primary rounded">
                                            <i class="ri-user-heart-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['totalActive']; ?></h4>
                                        <small class="text-muted">Total Employee</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Permanent -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-success-lighten text-success rounded">
                                            <i class="ri-user-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['activePermanent']; ?></h4>
                                        <small class="text-muted">Active Permanent</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Contract -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-info-lighten text-info rounded">
                                            <i class="ri-contacts-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['activeContract']; ?></h4>
                                        <small class="text-muted">Active Contract</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Men -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-primary-lighten text-primary rounded">
                                            <i class="ri-user-2-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['men']; ?></h4>
                                        <small class="text-muted">Men</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Women -->
                            <div class="col-auto">
                                <div class="d-flex align-items-center px-3 py-2">
                                    <div class="avatar-sm rounded">
                                        <span class="avatar-title bg-warning-lighten text-warning rounded">
                                            <i class="ri-user-3-line"></i>
                                        </span>
                                    </div>
                                    <div class="ms-2 text-nowrap">
                                        <h4 class="mb-0"><?= $namicoh['women']; ?></h4>
                                        <small class="text-muted">Women</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            <?php } ?>
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
                    <?php if (session('error')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-danger" role="alert">
                                <i class="ri-close-circle-line me-2"></i>
                                <?= session('error'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (session('warning')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-warning" role="alert">
                                <i class="ri-alert-line me-2"></i>
                                <?= session('warning'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php $importErrors = session()->getFlashdata('error_list'); ?>
                    <?php if (!empty($importErrors)) : ?>
                        <div class="mt-2">
                            <div class="alert alert-danger" role="alert">
                                <i class="ri-close-circle-line me-2"></i>
                                <strong>Import:</strong> <?= count($importErrors); ?> baris gagal diproses.
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($importErrors as $error) : ?>
                                        <li>
                                            <?= esc(($error['row'] ?? 0) > 0 ? 'Baris ' . $error['row'] : 'File') . ': ' . esc($error['message'] ?? ''); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- <table id="scroll-horizontal-datatable" class="table table-striped w-100 nowrap"> -->
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Employee ID</th>
                                <th>Age</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th>Employee Status</th>
                                <th>Product Synchronization</th>
                                <th>Plant</th>
                                <th>Group</th>
                                <th>Start Join</th>
                                <th>Contract</th>
                                <th class="text-center">Card</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row) : ?>
                                <?php
                                $birthdate = new DateTime($row->date_of_birth);
                                $today = new DateTime('now');
                                $age = $today->diff($birthdate);
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->name; ?></td>
                                    <td><?= $row->employee_id; ?></td>
                                    <td><?= $age->y; ?></td>
                                    <td><?= $row->division; ?></td>
                                    <td><?= $row->position; ?></td>
                                    <td><?= $row->employee_status; ?></td>
                                    <td><?= $row->product_synchronization; ?></td>
                                    <td><?= $row->plant; ?></td>
                                    <td><?= $row->employee_group; ?></td>
                                    <td><?= date('d/m/Y', strtotime($row->date_of_entry)); ?></td>
                                    <td><?= esc($row->latest_contract_types_name ?? '') ?></a></td>

                                    <td class="text-center">
                                        <a href="<?= base_url('employee/printCard/' . $row->id); ?>" class="action-icon text-primary" target="_blank"> <i class="mdi mdi-printer"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/details/' . $row->id); ?>" class="action-icon text-dark"> <i class="mdi mdi-eye"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/edit/' . $row->id); ?>" class="action-icon text-info"> <i class="mdi mdi-pencil"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/delete/' . $row->id); ?>" onclick="return confirm('delete?')" class="action-icon text-danger"> <i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (in_groups(['superadmin', 'admin'])) : ?>
    <div class="modal fade" id="importEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="importEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('employee/import_excel'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title" id="importEmployeeModalLabel">Import Excel Employee</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">File Excel</label>
                            <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">Maksimal 5 MB. Kolom ID wajib ada. Sel kosong dilewati, status tidak diubah.</div>
                        </div>
                        <?php
                        $templateParams = array_filter([
                            'gender_id'          => $gender_id,
                            'employee_status_id' => $employee_status_id,
                            'division_id'        => $division_id,
                            'plant_id'           => $plant_id,
                            'employee_group_id'  => $employee_group_id,
                            'company_id'         => $company_id,
                        ], function ($value) {
                            return $value !== null && $value !== '';
                        });

                        if (in_groups('admin')) {
                            unset($templateParams['division_id']);
                        }

                        $templateUrl = base_url('employee/import_template') . ($templateParams ? '?' . http_build_query($templateParams) : '');
                        ?>
                        <a href="<?= $templateUrl; ?>" id="btn-template" class="btn btn-link ps-0 <?= $templateParams ? '' : 'disabled'; ?>" data-no-filter="<?= $templateParams ? '0' : '1'; ?>" title="<?= $templateParams ? 'Download template sesuai filter search.' : 'Pilih minimal satu filter search sebelum download template.'; ?>">
                            <i class="mdi mdi-download"></i> Download template
                        </a>
                        <div class="form-text <?= $templateParams ? '' : 'text-danger'; ?>">Minimal ada 1 filter agar bisa download template.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<script>
    const btnExport = document.getElementById('btn-export');
    const btnTemplate = document.getElementById('btn-template');
    const loadingExport = document.getElementById('loading');
    const exportForm = document.getElementById('export-employee-form');
    let isDownloading = false;

    function defaultFileName(label) {
        return new Date().toISOString().slice(0, 10) + '-' + label + '.xlsx';
    }

    function setBusy(button, busy) {
        button.disabled = busy;
        button.classList.toggle('disabled', busy);

        if (busy) {
            button.setAttribute('aria-disabled', 'true');
        } else {
            button.removeAttribute('aria-disabled');
        }
    }

    async function downloadFile(url, options, fallbackFileName) {
        const response = await fetch(url, options);

        if (!response.ok) {
            let message = 'Download gagal: ' + response.status;

            try {
                const body = await response.json();

                if (body && body.message) {
                    message = body.message;
                }
            } catch (parseError) {
                console.warn(parseError);
            }

            throw new Error(message);
        }

        const disposition = response.headers.get('Content-Disposition') || '';
        const match = disposition.match(/filename\*?=(?:UTF-8'')?["']?([^;"']+)/i);
        const fileName = match ? decodeURIComponent(match[1]) : fallbackFileName;
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = blobUrl;
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        link.remove();
        setTimeout(() => URL.revokeObjectURL(blobUrl), 1000);
    }

    async function withLoading(button, task, fallbackFileName, errorMessage) {
        if (isDownloading) {
            return;
        }

        isDownloading = true;
        loadingExport.style.display = 'block';
        setBusy(button, true);

        try {
            await task(fallbackFileName);
        } catch (error) {
            console.error(error);
            alert(error.message || errorMessage);
        } finally {
            loadingExport.style.display = 'none';
            setBusy(button, false);
            isDownloading = false;
        }
    }

    btnExport.addEventListener('click', function(e) {
        e.preventDefault();

        withLoading(btnExport, async function(fallbackFileName) {
            await downloadFile(exportForm.action, {
                method: 'POST',
                body: new FormData(exportForm),
            }, fallbackFileName);
        }, defaultFileName('Data Employee'), 'Export gagal. Silakan coba lagi.');
    });

    if (btnTemplate) {
        btnTemplate.addEventListener('click', function(e) {
            e.preventDefault();

            if (btnTemplate.dataset.noFilter === '1') {
                alert('Pilih minimal satu filter search sebelum download template.');
                return;
            }

            withLoading(btnTemplate, async function(fallbackFileName) {
                await downloadFile(btnTemplate.href, { method: 'GET' }, fallbackFileName);
            }, defaultFileName('Template Import Employee'), 'Download template gagal. Silakan coba lagi.');
        });
    }
</script>
<!-- container -->
<?= $this->endSection() ?>