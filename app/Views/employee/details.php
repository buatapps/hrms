<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<style>
    .table>:not(caption)>*>* {
        padding: .45rem .45rem;
    }
</style>
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
        <div class="col-xl-4 col-sm-12">
            <div class="card  text-center">
                <div class="card-body">
                    <a href="" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                        <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">
                    </a>
                    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel"><?= $list_data['name']; ?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?= base_url('employee_picture/' . $list_data['picture']); ?>" alt="" style="max-width:700px;">
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <h4 class="mb-0 mt-2"><?= $list_data['name']; ?></h4>
                    <p class="text-muted font-14"><?= $list_data['division'] . ' - ' . $list_data['position'] . ' - ' . $list_data['employee_status']; ?></p>

                    <a href="<?= base_url('employee/edit/' . $list_data['id']); ?>" class="btn btn-primary btn-sm mb-0"><span class="mdi mdi-account-edit"></span> Edit</a>

                    <a href="<?= base_url('employee/printCard/' . $list_data['id']); ?>" class="btn btn-info btn-sm mb-0" target="_blank"><span class="mdi mdi-printer"></span> Print</a>

                    <a href="<?= base_url('contract/employee/' . $list_data['id']); ?>" class="btn btn-success btn-sm mb-0"><span class="mdi mdi-file-document-multiple-outline"></span> Contract</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-start mt-3">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted mb-2 font-13" width="50%"><strong>Company</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['company']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Name</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['name']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Employee ID</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['employee_id']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Employee PIN</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['employee_pin']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13" width="50%"><strong>Division</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['division']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Position</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['position']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Plant</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['plant']; ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted mb-2 font-13"><strong>Employee Group</strong></td>
                                <td class="text-muted mb-2 font-13">: <?= $list_data['employee_group']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Product Synchronization</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['product_synchronization']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Date of Entry</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= date('d-M-Y', strtotime($list_data['date_of_entry'])); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Years of Service</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $masa_kerja->y . ' years, ' . $masa_kerja->m . ' months, ' . $masa_kerja->d . ' days'; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Employee Status</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['employee_status']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Working Days</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['working_days'] . ' Days'; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Bank</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['bank']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Account Number</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['account_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Salary</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['salary']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>NPWP Number</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['npwp_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Tax Status</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['tax_status']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Uniform Size</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['uniform_size']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Shoes Size</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['shoes_size']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-12">

            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>BPJS Ketenagakerjaan</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['ketenagakerjaan_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>BPJS Kesehatan</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['kesehatan_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Clinic Provider</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['clinic_provider']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Hospital Provider</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['hospital_provider']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Insurance Employee</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['insurance_employee']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Insurance Husband / Wife</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['insurance_couple']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Insurance Children</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['insurance_children']; ?></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Gender</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['gender']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Place of Birth</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['place_of_birth']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Date of Birth</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= date('d-M-Y', strtotime($list_data['date_of_birth'])); ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Age</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $umur->y . ' years, ' . $umur->m . ' months, ' . $umur->d . ' days'; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Blood Type</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['blood_type']; ?></td>
                        </tr>

                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Phone Number</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['phone_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Email</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['email']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Address</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['address']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Identity Number (KTP)</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['identity_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Identity Family Number</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['identity_family_number']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Religion</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['religion']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Education</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['education']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Marriage Status</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['marriage_status']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Mother's Name</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['mothers_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Number of Children</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['number_of_children']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Address (KTP)</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['address_identity']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>RT</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['rt']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>RW</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['rw']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Provinces</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['provinces']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Regencies</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['regencies']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Districts</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['districts']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Villages</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['villages']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Husband / Wife Name</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['couple']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Husband / Wife date of birth</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= date('d-M-Y', strtotime($list_data['couple_date_of_birth'])); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>Emergency Calling Name</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['emergency_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Relathionship</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['emergency_relathionship']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>Contact Number</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['emergency_contact']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>1st Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_1']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>1st Child birthday</strong></td>
                            <td class="text-muted mb-2 font-13">:
                                <?php
                                if ($list_data['child_1_birthday'] != null && $list_data['child_1_birthday'] != '0000-00-00') {
                                    echo date('d-M-Y', strtotime($list_data['child_1_birthday']));
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>1st Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_1_gender']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>2nd Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_2']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>2nd Child birthday</strong></td>
                            <td class="text-muted mb-2 font-13">:
                                <?php
                                if ($list_data['child_2_birthday'] != null && $list_data['child_2_birthday'] != '0000-00-00') {
                                    echo date('d-M-Y', strtotime($list_data['child_2_birthday']));
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>2nd Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_2_gender']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>3rd Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_3']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>3rd Child birthday</strong></td>
                            <td class="text-muted mb-2 font-13">:
                                <?php
                                if ($list_data['child_3_birthday'] != null && $list_data['child_3_birthday'] != '0000-00-00') {
                                    echo date('d-M-Y', strtotime($list_data['child_3_birthday']));
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%"><strong>3rd Child</strong></td>
                            <td class="text-muted mb-2 font-13">: <?= $list_data['child_3_gender']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-12">
            <div class="card">
                <div class="card-body d-grid">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h6 style="margin: 0;">Supporting files</h6>
                        <a href="<?= base_url('employee/upload/' . $list_data['id']); ?>" class="link-warning text-decoration-underline link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                            Upload
                        </a>
                    </div>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted mb-2 font-13" width="50%">
                                <strong>Identity Document (KTP)</strong>
                            </td>
                            <td>:
                                <?php if (isset($list_data['ktp']) && $list_data['ktp'] != '') : ?>
                                    <a href="<?= base_url('employee_picture/' . $list_data['ktp']); ?>" target="_blank">
                                        File KTP <a href="<?= base_url('employee/delete_file/' . $list_data['id'] . '/ktp'); ?>" class="text-danger"><i class="mdi mdi-delete"></i></a>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-muted mb-2 font-13">
                                <strong>Identity Family Document (KK)</strong>
                            </td>
                            <td>:
                                <?php if (isset($list_data['kk']) && $list_data['kk'] != '') : ?>
                                    <a href="<?= base_url('employee_picture/' . $list_data['kk']); ?>" target="_blank">
                                        File KK <a href="<?= base_url('employee/delete_file/' . $list_data['id'] . '/kk'); ?>" class="text-danger"><i class="mdi mdi-delete"></i></a>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>SIM</strong></td>
                        </tr>
                        <tr>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="50%">Tipe</th>
                                        <th>Expired Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sim as $row): ?>
                                        <tr>
                                            <td><?= $row->tipe_sim; ?></td>
                                            <td><?= date('d-M-Y', strtotime($row->masa_berlaku)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </tr>
                        <tr>
                            <td class="text-muted mb-2 font-13"><strong>STNK</strong></td>
                        </tr>
                        <tr>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="50%">Nomor Plat</th>
                                        <th>Expired Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stnk as $row): ?>
                                        <tr>
                                            <td><?= $row->nomor_plat; ?></td>
                                            <td><?= date('d-M-Y', strtotime($row->masa_berlaku_pajak)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>