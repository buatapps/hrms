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
                                                        <div class="mb-3">
                                                            <label class="form-label">Company</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['company']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employee ID</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['employee_id']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employee PIN</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['employee_pin']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Date of Entry</label>
                                                            <p class="p-underline"><?= strtoupper(date('d F Y', strtotime($list_data['date_of_entry']))); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Division</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['division']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Position</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['position']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Plant</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['plant']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employee Group</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['employee_group']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Product Synchronization</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['product_synchronization']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Year of Services</label>
                                                            <p class="p-underline"><?= strtoupper($masa_kerja->y . ' years, ' . $masa_kerja->m . ' months, ' . $masa_kerja->d . ' days'); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Employee Status</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['employee_status']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Working Days</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['working_days']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="personal_data">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Name</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['name']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Gender</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['gender']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Place of Birthday</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['place_of_birth']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Date of Birth</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['date_of_birth']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Age</label>
                                                            <p class="p-underline"><?= strtoupper($umur->y . ' years, ' . $umur->m . ' months, ' . $umur->d . ' days'); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Blood Type</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['blood_type']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Religion</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['religion']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Phone Number</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['phone_number']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Email</label>
                                                            <p class="p-underline"><?= $list_data['email']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Identity Number (KTP)</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['identity_number']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['address']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Address (KTP)</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['address_identity']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">RT/RW</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['rt'] . '/' . $list_data['rw']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Provinces</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['provinces']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Regencies</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['regencies']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Districts</label>
                                                            <p class="p-underline"><?= strtoupper($list_data['districts']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Villages</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['villages']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="family_info">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Identity Family Number (KK)</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['identity_family_number']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Marriage Status</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['marriage_status']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Husband / Wife Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['couple']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Mother's Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['mothers_name']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Number of Children</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['number_of_children']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Husband / Wife date of birth</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['couple_date_of_birth']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Emergency Calling Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['emergency_name']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Emergency Calling Relathionship</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['emergency_relathionship']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Emergency Calling Contact Number</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['emergency_contact']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <p>Children</p>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">1st Child Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_1']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">1st Gender</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_1_gender']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">1st Child Birthday</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_1_birthday']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">2nd Child Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_2']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">2nd Gender</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_2_gender']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">2nd Child Birthday</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_2_birthday']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">3rd Child Name</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_3']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">3rd Gender</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_3_gender']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">3rd Child Birthday</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['child_3_birthday']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="education_info">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Education</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['education']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="additional">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Clinic Provider</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['clinic_provider']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Hospital Provider</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['hospital_provider']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Uniform Size</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['uniform_size']); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Shoes Size</label>
                                                            <p class="p-underline">&nbsp;<?= strtoupper($list_data['shoes_size']); ?></p>
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
                                                <?php $salary = $list_data['salary']; ?>
                                                <p class="p-underline" style="font-size:28px;">&nbsp;<?= number_format(is_numeric($salary) ? $salary : 0, 0, ',', '.'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Bank</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['bank']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Account Number</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['account_number']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Tax Status</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['tax_status']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">NPWP Number</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['npwp_number']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Number BPJS Ketenagakerjaan</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['ketenagakerjaan_number']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Number BPJS Kesehatan</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['kesehatan_number']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Insurance Employee</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['insurance_employee']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Insurance Husband / Wife</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['insurance_couple']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Insurance Children</label>
                                                <p class="p-underline">&nbsp;<?= strtoupper($list_data['insurance_children']); ?></p>
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
                                    <h3 class="fst-italic mb-3">History data</h3>
                                    <div class="tab-content">

                                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                            <li class="nav-item">
                                                <a href="#history_contract" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                    <i class="mdi mdi-file-document d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">CONTRACT</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#history_sertifikat" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                    <i class="mdi mdi-certificate d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">SERTIFIKAT</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#history_absent" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                    <i class="mdi mdi-history d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">HISTORY ABSENT</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#history_locker" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                    <i class="mdi mdi-lock d-md-none d-block"></i>
                                                    <span class="d-none d-md-block">HISTORY LOCKER</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="history_contract">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Contract Type</th>
                                                                    <th>Division</th>
                                                                    <th>Salary</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Status</th>
                                                                    <th>Created At</th>
                                                                    <th class="text-center">Print</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($contracts)) : ?>
                                                                    <?php $no = 1; ?>
                                                                    <?php foreach ($contracts as $c) : ?>
                                                                        <tr>
                                                                            <td><?= $no++; ?></td>
                                                                            <td><?= $c->contract_type_name; ?></td>
                                                                            <td><?= $c->division_name; ?></td>
                                                                            <td><?= 'Rp ' . number_format($c->salary, 0, ',', '.'); ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($c->start_date)); ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($c->end_date)); ?></td>
                                                                            <td><span class="text-<?= $c->status_class; ?>"><?= $c->status_name; ?></span></td>
                                                                            <td><?= date('d/m/Y H:i:s', strtotime($c->created_at)); ?></td>
                                                                            <td class="text-center">
                                                                                <a href="<?= base_url('contract/print/' . $c->id); ?>" class="action-icon text-primary" target="_blank"><i class="mdi mdi-printer"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="9" class="text-center">No contract data available</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="history_sertifikat">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Tipe Sertifikat</th>
                                                                    <th>Masa Berlaku</th>
                                                                    <th>File</th>
                                                                    <th>Created At</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if (!empty($sertifikat)) : ?>
                                                                    <?php $no = 1; ?>
                                                                    <?php foreach ($sertifikat as $s) : ?>
                                                                        <tr>
                                                                            <td><?= $no++; ?></td>
                                                                            <td><?= $s->tipe_sertifikat; ?></td>
                                                                            <td><?= date('d/m/Y', strtotime($s->masa_berlaku)); ?></td>
                                                                            <td>
                                                                                <?php if ($s->file): ?>
                                                                                    <a href="<?= base_url('sertifikat/' . $s->file); ?>" target="_blank" class="btn btn-warning btn-sm"><span class="mdi mdi-file"></span></a>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td><?= date('d/m/Y H:i:s', strtotime($s->created_at)); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">No sertifikat data available</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="history_absent">
                                                <div class="mb-3">
                                                    <div class="row g-2">
                                                        <!-- Absent Type -->
                                                        <div class="col-md-3">
                                                            <select id="filter_absent_type" class="form-control">
                                                                <option value="all">All Type</option>
                                                                <?php foreach ($absent_type as $type): ?>
                                                                    <option value="<?= $type->id ?>">
                                                                        <?= $type->name ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Period -->
                                                        <div class="col-md-3">
                                                            <select id="filter_period" class="form-control">
                                                                <option value="this_month">This Month</option>
                                                                <option value="last_3_month">Last 3 Months</option>
                                                                <option value="last_6_month">Last 6 Months</option>
                                                                <option value="this_year">This Year</option>
                                                                <option value="custom">Custom</option>
                                                            </select>
                                                        </div>

                                                        <!-- Start Date -->
                                                        <div class="col-md-3" id="box_start_date" style="display:none;">
                                                            <input type="date" id="start_date" class="form-control">
                                                        </div>

                                                        <!-- End Date -->
                                                        <div class="col-md-3" id="box_end_date" style="display:none;">
                                                            <input type="date" id="end_date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row gx-0">
                                                    <div id="history_period_label" class="mb-2 fw-bold"></div>
                                                    <div id="history_rows" class="row"></div>
                                                    <hr>
                                                    <div id="history_summary"></div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="history_locker">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Locker</th>
                                                                    <th>Key Number</th>
                                                                    <th>Event</th>
                                                                    <th>Remark</th>
                                                                    <th>Created At</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($locker_history as $lh) { ?>
                                                                    <tr>
                                                                        <td><?= $lh->transaction_date; ?></td>
                                                                        <td><?= $lh->locker_code; ?></td>
                                                                        <td><?= $lh->key_number; ?></td>
                                                                        <td><?= $lh->event; ?></td>
                                                                        <td><?= $lh->remark; ?></td>
                                                                        <td><?= $lh->created_at; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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

    /* input.form-control {
        margin-top: 7px;
    } */

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

    .p-underline {
        border-bottom: 1px solid #dee2e6;
        padding-top: 10px;
        padding-bottom: 2px;
        margin: 0;
        /* biar nggak ada spacing default <p> */
        font-weight: 500;
        /* optional, biar mirip form-control */
    }

    .history-row {
        display: grid;
        grid-template-columns: 160px 1fr;
        padding: 6px 0;
    }

    .col-date {
        color: #6b7280;
    }

    .col-type {
        font-weight: 500;
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
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const period = document.getElementById("filter_period");
        const startBox = document.getElementById("box_start_date");
        const endBox = document.getElementById("box_end_date");

        function toggleCustomDate() {
            if (period.value === "custom") {
                startBox.style.display = "block";
                endBox.style.display = "block";
            } else {
                startBox.style.display = "none";
                endBox.style.display = "none";
            }
        }

        period.addEventListener("change", toggleCustomDate);

        toggleCustomDate();

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const employeeId = "<?= $list_data['id'] ?>";

        const typeEl = document.getElementById("filter_absent_type");
        const periodEl = document.getElementById("filter_period");
        const startEl = document.getElementById("start_date");
        const endEl = document.getElementById("end_date");

        const rowsEl = document.getElementById("history_rows");
        const summaryEl = document.getElementById("history_summary");
        const labelEl = document.getElementById("history_period_label");

        // =========================
        // RENDER FUNCTION
        // =========================
        function loadHistory() {

            let type = typeEl.value;
            let period = periodEl.value;
            let start = startEl.value;
            let end = endEl.value;

            let url = `<?= base_url('employee/employeeAbsentHistoryAjax') ?>` +
                `?employee_id=${employeeId}` +
                `&absent_type=${type}` +
                `&period=${period}` +
                `&start_date=${start}` +
                `&end_date=${end}`;

            fetch(url)
                .then(res => res.json())
                .then(res => {

                    // =========================
                    // PERIOD LABEL
                    // =========================
                    labelEl.innerText = res.period_label;

                    // =========================
                    // RENDER ROWS (2 COLUMN GRID)
                    // =========================
                    rowsEl.innerHTML = "";

                    if (res.rows.length === 0) {
                        rowsEl.innerHTML = `<div class="text-muted">No Data</div>`;
                        summaryEl.innerHTML = "";
                        return;
                    }

                    res.rows.forEach((item, index) => {

                        let html = `
                        <div class="history-row">
                            <div class="col-date">${item.date}</div>
                            <div class="col-type">${item.type_name}</div>
                        </div>
                    `;

                        rowsEl.innerHTML += html;
                    });

                    // =========================
                    // RENDER SUMMARY
                    // =========================
                    summaryEl.innerHTML = "";

                    if (res.summary.length > 0) {

                        let summaryHtml = `<div><strong>Total</strong></div>`;

                        res.summary.forEach(s => {
                            summaryHtml += `
                            <div>${s.name} : ${s.total}</div>
                        `;
                        });

                        summaryEl.innerHTML = summaryHtml;
                    }

                })
                .catch(err => {
                    console.log(err);
                });
        }

        // =========================
        // EVENT LISTENER
        // =========================
        typeEl.addEventListener("change", loadHistory);
        periodEl.addEventListener("change", function() {

            if (this.value === "custom") {
                startEl.style.display = "block";
                endEl.style.display = "block";
            } else {
                startEl.style.display = "none";
                endEl.style.display = "none";
            }

            loadHistory();
        });

        startEl.addEventListener("change", loadHistory);
        endEl.addEventListener("change", loadHistory);

        // =========================
        // FIRST LOAD
        // =========================
        loadHistory();

    });
</script>
<?= $this->endSection() ?>