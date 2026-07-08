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
                        <li class="breadcrumb-item"><a href="<?= base_url('employee'); ?>">Employee</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <?php if (session('success')) : ?>
        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                        <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" class="rounded-circle avatar-lg img-thumbnail"
                                            alt="profile-image">
                                    </a>
                                </div>
                                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel"><?= $list_data['name']; ?></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" alt="" style="display:block; max-width:700px; margin:0 auto;">
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white"><?= $list_data['name']; ?></h4>
                                        <p class="font-13 text-white-50 fst-italic"> <?= $list_data['division']; ?><br><?= $list_data['position']; ?></p>
                                        <p class="font-13 text-white-50 fst-italic"> </p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active">
                            <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#general_info" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                        <span class="d-none d-md-block">GENERAL INFO</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#payroll" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">PAYROLL</span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                        <i class="mdi mdi-settings-outline d-md-none d-block me-1"></i>
                                        <span class="d-none d-md-block">TIME MANAGEMENT</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="tab" href="#schedule">
                                                Schedule
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" data-bs-toggle="tab" href="#attendance">
                                                Attendance
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#finance" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">FINANCE</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#history" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">HISTORY</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#files" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">FILES</span>
                                    </a>
                                </li>
                            </ul>
                            <form class="needs-validation" novalidate action="<?= base_url('employee/update_live/'); ?>" method="post" enctype="multipart/form-data" id="form-update-employee">
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="general_info">
                                        <h3 class="fst-italic mb-3">Employee data</h3>
                                        <div class="tab-content">

                                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                                <li class="nav-item">
                                                    <a href="#employment_data" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">EMPLOYMENT DATA</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#personal_data" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">PERSONAL DATA</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#family_info" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">FAMILY INFO</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#education_info" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">EDUCATION INFO</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#additional" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                                        <span class="d-none d-md-block">ADDITIONAL</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="employment_data">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3" hidden>
                                                                <label class="form-label">ID</label>
                                                                <input type="text" name="id" class="form-control underline form-control-sm" value="<?= $list_data['id']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Company</label>
                                                                <select class="form-control form-control-sm form-select underline mb-3 select2" data-toggle="select2" name="company_id">
                                                                    <?php foreach ($company as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['company_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee ID</label>
                                                                <input type="text" name="employee_id" class="form-control underline form-control-sm" value="<?= $list_data['employee_id']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee PIN</label>
                                                                <input type="text" name="employee_pin" class="form-control underline form-control-sm" value="<?= $list_data['employee_pin']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date of Entry</label>
                                                                <input type="text" name="date_of_entry" class="form-control underline form-control-sm" value="<?= $list_data['date_of_entry']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Division</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="division_id">
                                                                    <?php foreach ($division as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['division_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Position</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="position_id">
                                                                    <?php foreach ($position as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['position_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Plant</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="plant_id">
                                                                    <?php foreach ($plant as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['plant_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Group</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="employee_group_id">
                                                                    <?php foreach ($employee_group as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['employee_group_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Product Synchronization</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="product_synchronization">
                                                                    <option value="Direct" <?= ('Direct' == $list_data['product_synchronization']) ? 'selected' : '' ?>>Direct</option>
                                                                    <option value="Indirect" <?= ('Indirect' == $list_data['product_synchronization']) ? 'selected' : '' ?>>Indirect</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Year of Services</label>
                                                                <input type="text" class="form-control underline form-control-sm" value="<?= $masa_kerja->y . ' years, ' . $masa_kerja->m . ' months, ' . $masa_kerja->d . ' days'; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Status</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="employee_status_id">
                                                                    <?php foreach ($employee_status as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['employee_status_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Working Days</label>
                                                                <input type="number" name="working_days" class="form-control underline form-control-sm" value="<?= $list_data['working_days']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="personal_data">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" name="name" class="form-control underline form-control-sm" value="<?= $list_data['name']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Gender</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="gender_id">
                                                                    <?php foreach ($gender as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['gender_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Place of Birthday</label>
                                                                <input type="text" name="place_of_birth" class="form-control underline form-control-sm" value="<?= $list_data['place_of_birth']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input type="date" name="date_of_birth" class="form-control underline form-control-sm" value="<?= $list_data['date_of_birth']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Age</label>
                                                                <input type="text" class="form-control underline form-control-sm" value="<?= $umur->y . ' years, ' . $umur->m . ' months, ' . $umur->d . ' days'; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Blood Type</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="blood_type">
                                                                    <option value="A" <?= ('A' == $list_data['blood_type']) ? 'selected' : '' ?>>A</option>
                                                                    <option value="B" <?= ('B' == $list_data['blood_type']) ? 'selected' : '' ?>>B</option>
                                                                    <option value="AB" <?= ('AB' == $list_data['blood_type']) ? 'selected' : '' ?>>AB</option>
                                                                    <option value="O" <?= ('O' == $list_data['blood_type']) ? 'selected' : '' ?>>O</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Religion</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="religion">
                                                                    <option value="Islam" <?= ('Islam' == $list_data['religion']) ? 'selected' : '' ?>>Islam</option>
                                                                    <option value="Protestan" <?= ('Protestan' == $list_data['religion']) ? 'selected' : '' ?>>Protestan</option>
                                                                    <option value="Katolik" <?= ('Katolik' == $list_data['religion']) ? 'selected' : '' ?>>Katolik</option>
                                                                    <option value="Hindu" <?= ('Hindu' == $list_data['religion']) ? 'selected' : '' ?>>Hindu</option>
                                                                    <option value="Buddha" <?= ('Buddha' == $list_data['religion']) ? 'selected' : '' ?>>Buddha</option>
                                                                    <option value="Konghucu" <?= ('Konghucu' == $list_data['religion']) ? 'selected' : '' ?>>Konghucu</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Phone Number</label>
                                                                <input type="number" name="phone_number" class="form-control underline form-control-sm" value="<?= $list_data['phone_number']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="text" name="email" class="form-control underline form-control-sm" value="<?= $list_data['email']; ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Identity Number (KTP)</label>
                                                                <input type="text" name="identity_number" class="form-control underline form-control-sm" value="<?= $list_data['identity_number']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Address</label>
                                                                <input type="text" name="address" class="form-control underline form-control-sm" value="<?= $list_data['address']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Address (KTP)</label>
                                                                <input type="text" name="address_identity" class="form-control underline form-control-sm" value="<?= $list_data['address_identity']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">RT</label>
                                                                        <input type="text" name="rt" class="form-control underline form-control-sm" value="<?= $list_data['rt']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">RW</label>
                                                                        <input type="text" name="rw" class="form-control underline form-control-sm" value="<?= $list_data['rw']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Provinces</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="provinces_id" onchange="fetchRergenciesData(this.value)">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($provinces as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['provinces_id']) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Regencies</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="regencies_id" id="regenciesID" onchange="fetchDistrictsData(this.value)">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($regencies as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['regencies_id']) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Districts</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="districts_id" id="districtsID" onchange="fetchVillagesData(this.value)">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($districts as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['districts_id']) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Villages</label>
                                                                <select class="form-control form-control-sm form-select mb-3 underline select2" data-toggle="select2" name="villages_id" id="villagesID">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($villages as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['villages_id']) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="family_info">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Identity Family Number (KK)</label>
                                                                <input type="text" name="identity_family_number" class="form-control underline form-control-sm" value="<?= $list_data['identity_family_number']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Marriage Status</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="marriage_status_id">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($marriage_status as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['marriage_status_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Husband / Wife Name</label>
                                                                <input type="text" name="couple" class="form-control underline form-control-sm" value="<?= $list_data['couple']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Mother's Name</label>
                                                                <input type="text" name="mothers_name" class="form-control underline form-control-sm" value="<?= $list_data['mothers_name']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Number of Children</label>
                                                                <input type="number" name="number_of_children" class="form-control underline form-control-sm" value="<?= $list_data['number_of_children']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Husband / Wife date of birth</label>
                                                                <input type="date" name="couple_date_of_birth" class="form-control underline form-control-sm" value="<?= $list_data['couple_date_of_birth']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Emergency Calling Name</label>
                                                                <input type="text" name="emergency_name" class="form-control underline form-control-sm" value="<?= $list_data['emergency_name']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Emergency Calling Relathionship</label>
                                                                <input type="text" name="emergency_relathionship" class="form-control underline form-control-sm" value="<?= $list_data['emergency_relathionship']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Emergency Calling Contact Number</label>
                                                                <input type="text" name="emergency_contact" class="form-control underline form-control-sm" value="<?= $list_data['emergency_contact']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <p>Children</p>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">1st Child Name</label>
                                                                <input type="text" name="child_1" class="form-control underline form-control-sm" value="<?= $list_data['child_1']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">1st Gender</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="child_1_gender">
                                                                    <option value="Laki-laki" <?= ('Laki-laki' == $list_data['child_1_gender']) ? 'selected' : null ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?= ('Perempuan' == $list_data['child_1_gender']) ? 'selected' : null ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">1st Child Birthday</label>
                                                                <input type="date" name="child_1_birthday" class="form-control underline form-control-sm" value="<?= $list_data['child_1_birthday']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">2nd Child Name</label>
                                                                <input type="text" name="child_2" class="form-control underline form-control-sm" value="<?= $list_data['child_2']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">2nd Gender</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="child_2_gender">
                                                                    <option value="">&nbsp;</option>
                                                                    <option value="Laki-laki" <?= ('Laki-laki' == $list_data['child_2_gender']) ? 'selected' : null ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?= ('Perempuan' == $list_data['child_2_gender']) ? 'selected' : null ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">2nd Child Birthday</label>
                                                                <input type="date" name="child_2_birthday" class="form-control underline form-control-sm" value="<?= $list_data['child_2_birthday']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">3rd Child Name</label>
                                                                <input type="text" name="child_3" class="form-control underline form-control-sm" value="<?= $list_data['child_3']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">3rd Gender</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="child_3_gender">
                                                                    <option value="">&nbsp;</option>
                                                                    <option value="Laki-laki" <?= ('Laki-laki' == $list_data['child_3_gender']) ? 'selected' : null ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?= ('Perempuan' == $list_data['child_3_gender']) ? 'selected' : null ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">3rd Child Birthday</label>
                                                                <input type="date" name="child_3_birthday" class="form-control underline form-control-sm" value="<?= $list_data['child_3_birthday']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="education_info">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Education</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="education_id">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($education as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['education_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="additional">
                                                    <div class="row">

                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Clinic Provider</label>
                                                                <input type="text" name="clinic_provider" class="form-control underline form-control-sm" value="<?= $list_data['clinic_provider']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Hospital Provider</label>
                                                                <input type="text" name="hospital_provider" class="form-control underline form-control-sm" value="<?= $list_data['hospital_provider']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Uniform Size</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="uniform_size">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($uniform as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->name == $list_data['uniform_size']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-4">
                                                            <div class="mb-3">
                                                                <label class="form-label">Shoes Size</label>
                                                                <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="shoes_size">
                                                                    <option value="">&nbsp;</option>
                                                                    <?php foreach ($shoes as $row) : ?>
                                                                        <option value="<?= $row->id; ?>" <?= ($row->name == $list_data['shoes_size']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end tab-content-->
                                    </div>
                                    <div class="tab-pane" id="payroll">
                                        <h3 class="fst-italic mb-3">Payroll Info</h3>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Basic Salary</label>
                                                    <input type="text" name="salary" id="salary_display" class="form-control underline salary-big" value="<?= $list_data['salary']; ?>">
                                                    <input type="hidden" name="salary" id="salary">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Bank</label>
                                                    <select class="form-control form-control-sm form-select underline select2" data-toggle="select2" name="bank_id">
                                                        <option value="">&nbsp;</option>
                                                        <?php foreach ($bank as $row) : ?>
                                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data['bank_id']) ? 'selected' : '' ?>><?= strtoupper($row->name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Account Number</label>
                                                    <input type="text" name="account_number" class="form-control underline form-control-sm" value="<?= $list_data['account_number']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Tax Status</label>
                                                    <input type="text" name="tax_status" class="form-control underline form-control-sm" value="<?= $list_data['tax_status']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">NPWP Number</label>
                                                    <input type="text" name="npwp_number" class="form-control underline form-control-sm" value="<?= $list_data['npwp_number']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Number BPJS Ketenagakerjaan</label>
                                                    <input type="text" name="ketenagakerjaan_number" class="form-control underline form-control-sm" value="<?= $list_data['ketenagakerjaan_number']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Number BPJS Kesehatan</label>
                                                    <input type="text" name="kesehatan_number" class="form-control underline form-control-sm" value="<?= $list_data['kesehatan_number']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Insurance Employee</label>
                                                    <input type="text" name="insurance_employee" class="form-control underline form-control-sm" value="<?= $list_data['insurance_employee']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Insurance Husband / Wife</label>
                                                    <input type="text" name="insurance_couple" class="form-control underline form-control-sm" value="<?= $list_data['insurance_couple']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Insurance Children</label>
                                                    <input type="text" name="insurance_children" class="form-control underline form-control-sm" value="<?= $list_data['insurance_children']; ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- <div class="tab-pane" id="time_management">

                                    </div> -->
                                    <div class="tab-pane fade" id="schedule">
                                        <h3 class="fst-italic">Schedule Info</h3>
                                        <h5 class=" mb-3"><?= $currentMonthName; ?> <?= $currentYear; ?></h5>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <a href="<?= base_url('employee/schedule_add/' . $list_data['id']); ?>" class="btn btn-primary" target="_blank">Management Schedule</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table id="fixed-header-datatable" class="table dt-responsive nowrap table-striped w-100">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Date</td>
                                                        <td>Day</td>
                                                        <td>Shift</td>
                                                        <td>Hours</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $daysInMonth = date('t', strtotime($currentYear . '-' . $currentMonth . '-01'));

                                                    // Ubah schedule jadi array by date biar gampang dicari
                                                    $scheduleByDate = [];
                                                    foreach ($schedule as $row) {
                                                        $scheduleByDate[$row->date] = $row;
                                                    }

                                                    for ($d = 1; $d <= $daysInMonth; $d++) {

                                                        $date = sprintf('%04d-%02d-%02d', $currentYear, $currentMonth, $d);
                                                        $dayNumber = date('w', strtotime($date));
                                                        $isWeekend = ($dayNumber == 0 || $dayNumber == 6);

                                                        $row = $scheduleByDate[$date] ?? null;
                                                    ?>
                                                        <tr class="<?= $isWeekend ? 'table-danger' : ''; ?>">
                                                            <td><?= $no++; ?></td>
                                                            <td><?= date('d-M-Y', strtotime($date)); ?></td>
                                                            <td><?= date('l', strtotime($date)); ?></td>
                                                            <td><?= $row->shift_name ?? '-'; ?></td>
                                                            <td><?= $row->working_hours_name ?? '-'; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="attendance">

                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="fst-italic">Attendance</h3>
                                                <h5 class=" mb-3"><?= $currentMonthName; ?> <?= $currentYear; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table id="fixed-header-datatable" class="table dt-responsive nowrap table-striped w-100">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Date</td>
                                                        <td>Name</td>
                                                        <td>Employee ID</td>
                                                        <td>Position</td>
                                                        <td>Division</td>
                                                        <td>Plant</td>
                                                        <td>Group</td>
                                                        <td>Shift</td>
                                                        <td>In</td>
                                                        <td>Out</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($attendance as $key) { ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $key->date; ?></td>
                                                            <td><?= $key->name; ?></td>
                                                            <td><?= $key->employee_id; ?></td>
                                                            <td><?= $key->position; ?></td>
                                                            <td><?= $key->division; ?></td>
                                                            <td><?= $key->plant; ?></td>
                                                            <td><?= $key->employee_group; ?></td>
                                                            <td><?= $key->shift_name; ?></td>
                                                            <td><?= $key->jam_masuk ?? '-' ?></td>
                                                            <td><?= $key->jam_pulang ?? '-' ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="finance">
                                        Finance ( Coming Soon )
                                        Reimbursement/Cash Advance/Loan
                                    </div>
                                    <div class="tab-pane" id="history">
                                        History ( Coming Soon )
                                        Adjustment History/Transfer History/
                                    </div>
                                    <div class="tab-pane" id="files">
                                        <h3 class="fst-italic mb-3">My Files</h3>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <a href="<?= base_url('employee/uploads/' . $list_data['id']); ?>" class="btn btn-primary">Add New</a>
                                            </div>
                                        </div>
                                        <table id="fixed-header-datatable" class="table dt-responsive nowrap table-striped w-100">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Description</th>
                                                    <th>File</th>
                                                    <th>Size</th>
                                                    <th>Created At</th>
                                                    <th>Download</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($files as $key) { ?>
                                                    <tr>
                                                        <td><?= $key->category; ?></td>
                                                        <td><?= $key->description; ?></td>
                                                        <td><?= $key->file_name; ?></td>
                                                        <td><?= humanFileSize($key->file_size); ?></td>
                                                        <td><?= $key->created_at; ?></td>
                                                        <td>
                                                            <a href="<?= base_url('employee/download_file/' . $key->id) ?>"
                                                                class="btn btn-sm btn-primary">
                                                                <span class="mdi mdi-download"></span> Download
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('employee/deleted_file/' . $key->employee_id . '/' . $key->id); ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this file?');"><span class="mdi mdi-delete"></span></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

</div>
<!-- container -->
<style>
    .salary-big {
        height: 50px;
        font-size: 32px;
    }

    input.form-control {
        margin-top: 7px;
    }

    .form-select.underline,
    .form-control.underline {
        border: none;
        border-bottom: 2px solid #dee2e6;
        border-radius: 0;
        padding-left: 0;
        padding-right: 0;
        background-color: transparent;
        box-shadow: none;
    }

    .form-select.underline:focus,
    .form-control.underline:focus {
        box-shadow: none;
        border-bottom-color: #0d6efd;
        /* primary */
    }

    .form-control.underline:focus {
        border-bottom-color: #0d6efd;
        /* warna primary */
        box-shadow: none;
        background-color: transparent;
    }

    .form-select.underline option {
        text-indent: 12px;
    }

    /* sembunyikan select asli */
    /*select.select2 {
        display: none;
    }


    /* container */
    .select2-container .select2-selection {
        border: none !important;
        border-bottom: 2px solid #dee2e6 !important;
        border-radius: 0 !important;
        background: transparent !important;
        min-height: 34px;
    }

    /* text */
    .select2-container .select2-selection__rendered {
        padding-left: 0 !important;
        line-height: 32px;
    }

    /* arrow */
    /*.select2-container .select2-selection__arrow {
        right: 0;
    }

    /* focus */
    .select2-container--focus .select2-selection,
    .select2-container--open .select2-selection {
        border-bottom-color: #0d6efd !important;
        box-shadow: none !important;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const display = document.getElementById("salary_display");
        const hidden = document.getElementById("salary");

        const formatter = new Intl.NumberFormat("id-ID");

        function cleanNumber(value) {
            return value.replace(/\D/g, "");
        }

        function formatNumber(value) {
            let number = cleanNumber(value);
            return number ? formatter.format(number) : "";
        }

        // Saat load (nilai awal dari database)
        display.value = formatNumber(display.value);
        hidden.value = cleanNumber(display.value);

        // Saat user mengetik
        display.addEventListener("input", function() {
            display.value = formatNumber(display.value);
            hidden.value = cleanNumber(display.value);
        });

    });
</script>
<?= $this->endSection() ?>