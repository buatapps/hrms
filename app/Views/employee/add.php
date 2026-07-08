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

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <form class="needs-validation" novalidate action="<?= base_url('employee/save'); ?>" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <h4 class="header-title">Employee Information</h4>
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <select class="form-select mb-3" name="company_id" required>
                                        <?php foreach ($company as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (session('error')) : ?>
                                    <div class="mt-2">
                                        <div class="alert alert-danger" role="alert">
                                            <?= session()->getFlashdata('error') ?>
                                            <?= session('danger'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name'); ?>" autofocus required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id" value="<?= old('employee_id'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employee PIN</label>
                                    <input type="text" class="form-control" id="employee_pin" name="employee_pin" value="<?= old('employee_pin'); ?>" required>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select class="form-select mb-3" name="division_id" required>
                                        <?php foreach ($division as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <select class="form-select mb-3" name="position_id" required>
                                        <?php foreach ($position as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-0">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Plant</label>
                                            <select class="form-select mb-3" name="plant_id" required>
                                                <?php foreach ($plant as $row) : ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Employee Group</label>
                                            <select class="form-select mb-3" name="employee_group_id" required>
                                                <?php foreach ($employee_group as $row) : ?>
                                                    <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Synchronization</label>
                                    <select class="form-select mb-3" name="product_synchronization" required>
                                        <option value="Direct">Direct</option>
                                        <option value="Indirect">Indirect</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Entry</label>
                                    <input type="date" class="form-control" id="date_of_entry" name="date_of_entry" value="<?= old('date_of_entry'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employee Status</label>
                                    <select class="form-select mb-3" name="employee_status_id" required>
                                        <?php foreach ($employee_status as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= $row->id == '2' ? 'selected' : ''; ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Working Days</label>
                                    <input type="number" class="form-control" id="working_days" name="working_days" value="<?= old('working_days'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bank</label>
                                    <select class="form-select mb-3" name="bank_id">
                                        <?php foreach ($bank as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number" value="<?= old('account_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Salary</label>
                                        <input type="text" class="form-control" id="salary" name="salary" value="<?= old('salary'); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NPWP Number</label>
                                    <input type="text" class="form-control" id="npwp_number" name="npwp_number" value="<?= old('npwp_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tax Status</label>
                                    <select class="form-select mb-3" name="tax_status_id">
                                        <?php foreach ($tax_status as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS Ketenagakerjaan Number</label>
                                    <input type="text" class="form-control" id="ketenagakerjaan_number" name="ketenagakerjaan_number" value="<?= old('ketenagakerjaan_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS Kesehatan Number</label>
                                    <input type="text" class="form-control" id="kesehatan_number" name="kesehatan_number" value="<?= old('kesehatan_number'); ?>">
                                </div>


                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Clinic Provider</label>
                                    <input type="text" class="form-control" id="clinic_provider" name="clinic_provider" value="<?= old('clinic_provider'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hospital Provider</label>
                                    <input type="text" class="form-control" id="hospital_provider" name="hospital_provider" value="<?= old('hospital_provider'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Employee</label>
                                    <input type="text" class="form-control" id="insurance_employee" name="insurance_employee" value="<?= old('insurance_employee'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Husband / Wife</label>
                                    <input type="text" class="form-control" id="insurance_couple" name="insurance_couple" value="<?= old('insurance_couple'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Children</label>
                                    <input type="text" class="form-control" id="insurance_children" name="insurance_children" value="<?= old('insurance_children'); ?>">
                                </div>
                                <div class="mb-0">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Uniform Size</label>
                                            <select class="form-select mb-3" name="uniform_size">
                                                <option value="XXS">XXS</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M" selected>M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="2XL">2XL</option>
                                                <option value="3XL">3XL</option>
                                                <option value="4XL">4XL</option>
                                                <option value="5XL">5XL</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Shoes Size</label>
                                            <select class="form-select mb-3" name="shoes_size">
                                                <option value="37">37</option>
                                                <option value="38">38</option>
                                                <option value="39">39</option>
                                                <option value="40">40</option>
                                                <option value="41">41</option>
                                                <option value="42">42</option>
                                                <option value="43">43</option>
                                                <option value="44">44</option>
                                                <option value="45">45</option>
                                                <option value="46">46</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Personal Information</h4>
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select mb-3" name="gender_id" required>
                                        <?php foreach ($gender as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?= old('place_of_birth'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Blood Type</label>
                                    <select class="form-select mb-3" name="blood_type">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= old('phone_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
                                </div>

                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">&nbsp;</h4>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="address" name="address" class="form-control" style="height: 131px;"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Identity Number (KTP)</label>
                                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="<?= old('identity_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Identity Family Number (KK)</label>
                                    <input type="text" class="form-control" id="identity_family_number" name="identity_family_number" value="<?= old('identity_family_number'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Religion</label>
                                    <select class="form-select mb-3" name="religion" required>
                                        <option value="Islam">Islam</option>
                                        <option value="Protestan">Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <select class="form-select mb-3" name="education_id" required>
                                        <?php foreach ($education as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == 3) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">&nbsp;</h4>
                                <div class="mb-3">
                                    <label class="form-label">Marriage Status</label>
                                    <select class="form-select mb-3" name="marriage_status_id" required>
                                        <?php foreach ($marriage_status as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control" id="mothers_name" name="mothers_name" value="<?= old('mothers_name'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of Children</label>
                                    <input type="number" class="form-control" id="number_of_children" name="number_of_children" value="<?= old('number_of_children'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Picture</label>
                                    <input class="form-control" type="file" name="picture" id="sampul" onchange="previewImg()">
                                </div>
                                <div class="mb-3">
                                    <img src="" height="160" alt="" class="img-preview">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Identity Information (KTP)</h4>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address_identity" id="" class="form-control" style="height: 131px;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-12">
                                                <label class="form-label">RT</label>
                                                <input type="text" class="form-control" name="rt" value="<?= old('rt'); ?>">
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <label class="form-label">RW</label>
                                                <input type="text" class="form-control" name="rw" value="<?= old('rw'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Provincies</label>
                                        <select class="form-control select2" data-toggle="select2" name="provinces_id" onchange="fetchRergenciesData(this.value)">
                                            <option value="">&nbsp;</option>
                                            <?php foreach ($provinces as $row) : ?>
                                                <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Regencies</label>
                                        <select class="form-control select2" data-toggle="select2" name="regencies_id" id="regenciesID" onchange="fetchDistrictsData(this.value)">
                                            <option value="">&nbsp;</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-xl-6 col-sm-12">
                                                <label class="form-label">Districts</label>
                                                <select class="form-control select2" data-toggle="select2" name="districts_id" id="districtsID" onchange="fetchVillagesData(this.value)">
                                                    <option value="">&nbsp;</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6 col-sm-12">
                                                <label class="form-label">Villages</label>
                                                <select class="form-control select2" data-toggle="select2" name="villages_id" id="villagesID">
                                                    <option value="">&nbsp;</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Family Information</h4>
                                <div class="mb-3">
                                    <label class="form-label">Husband / Wife Name</label>
                                    <input type="text" class="form-control" id="couple" name="couple" value="<?= old('couple'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Husband / Wife date of birth</label>
                                    <input type="date" class="form-control" id="couple_date_of_birth" name="couple_date_of_birth" value="<?= old('couple_date_of_birth'); ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <h4 class="header-title">Children's</h4>
                                <div class="mb-0">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">1st child</label>
                                            <input type="text" class="form-control" id="child_1" name="child_1" value="<?= old('child_1'); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">1st child gender</label>
                                            <select class="form-select mb-3" name="child_1_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">1st child birthday</label>
                                            <input type="date" class="form-control" id="child_1_birthday" name="child_1_birthday" value="<?= old('child_1_birthday'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">2nd child</label>
                                            <input type="text" class="form-control" id="child_2" name="child_2" value="<?= old('child_2'); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">2nd child gender</label>
                                            <select class="form-select mb-3" name="child_2_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">2nd child birthday</label>
                                            <input type="date" class="form-control" id="child_2_birthday" name="child_2_birthday" value="<?= old('child_2_birthday'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">3rd child</label>
                                            <input type="text" class="form-control" id="child_3" name="child_3" value="<?= old('child_3'); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">3st child gender</label>
                                            <select class="form-select mb-3" name="child_3_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>

                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">3rd child birthday</label>
                                            <input type="date" class="form-control" id="child_3_birthday" name="child_3_birthday" value="<?= old('child_3_birthday'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Emergency Calling</h4>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="<?= old('emergency_name'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Relathionship</label>
                                    <input type="text" class="form-control" id="emergency_relathionship" name="emergency_relathionship" value="<?= old('emergency_relathionship'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?= old('emergency_contact'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-xl-3 col-sm-12">
                            <h4 class="header-title">Contract</h4>
                            <div class="mb-3">
                                <label class="form-label">Contract Type</label>
                                <select name="contract_types_id" id="contract_types_id" class="form-control">
                                    <option value="1">K1 / Kontrak 1</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date_contract" name="start_date_contract" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date_contract" name="end_date_contract" value="<?= date('Y-m-d', strtotime('+1 year')) ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>