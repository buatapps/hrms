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
                <form class="needs-validation" novalidate action="<?= base_url('employee/update/' . $list_data->id); ?>" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <h4 class="header-title">Employee Information</h4>
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <select class="form-select mb-3" name="company_id" required>
                                        <?php foreach ($company as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->company_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Name</label>
                                    <input type="text" class="form-control <?= (validation_show_error('name')) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= old('name', $list_data->name); ?>" autofocus required>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('name') ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Employee ID</label>
                                    <input type="text" class="form-control <?= (validation_show_error('employee_id')) ? 'is-invalid' : ''; ?>" id="employee_id" name="employee_id" value="<?= old('employee_id', $list_data->employee_id); ?>" required>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('employee_id') ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Employee PIN</label>
                                    <input type="text" class="form-control <?= (validation_show_error('employee_pin')) ? 'is-invalid' : ''; ?>" id="employee_pin" name="employee_pin" value="<?= old('employee_pin', $list_data->employee_pin); ?>" required>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('employee_pin') ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select class="form-select mb-3" name="division_id" required>
                                        <?php foreach ($division as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->division_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <select class="form-select mb-3" name="position_id" required>
                                        <?php foreach ($position as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->position_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
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
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->plant_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Employee Group</label>
                                            <select class="form-select mb-3" name="employee_group_id" required>
                                                <?php foreach ($employee_group as $row) : ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->employee_group_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Synchronization</label>
                                    <select class="form-select mb-3" name="product_synchronization" required>
                                        <option value="Direct" <?= ('Direct' == $list_data->product_synchronization) ? 'selected' : '' ?>>Direct</option>
                                        <option value="Indirect" <?= ('Indirect' == $list_data->product_synchronization) ? 'selected' : '' ?>>Indirect</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Entry</label>
                                    <input type="date" class="form-control" id="date_of_entry" name="date_of_entry" value="<?= old('date_of_entry', $list_data->date_of_entry); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Employee Status</label>
                                    <select class="form-select mb-3" name="employee_status_id" required>
                                        <?php foreach ($employee_status as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->employee_status_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Working Days</label>
                                    <input type="number" class="form-control" id="working_days" name="working_days" value="<?= old('working_days', $list_data->working_days); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bank</label>
                                    <select class="form-select mb-3" name="bank_id">
                                        <?php foreach ($bank as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->bank_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number" value="<?= old('account_number', $list_data->account_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Salary</label>
                                    <input type="text" class="form-control" id="salary" name="salary" value="<?= old('salary', $list_data->salary); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NPWP Number</label>
                                    <input type="text" class="form-control" id="npwp_number" name="npwp_number" value="<?= old('npwp_number', $list_data->npwp_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tax Status</label>
                                    <select class="form-select mb-3" name="tax_status_id">
                                        <?php foreach ($tax_status as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->tax_status_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS Ketenagakerjaan Number</label>
                                    <input type="text" class="form-control" id="ketenagakerjaan_number" name="ketenagakerjaan_number" value="<?= old('ketenagakerjaan_number', $list_data->ketenagakerjaan_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">BPJS Kesehatan Number</label>
                                    <input type="text" class="form-control" id="kesehatan_number" name="kesehatan_number" value="<?= old('kesehatan_number', $list_data->kesehatan_number); ?>">
                                </div>

                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Clinic Provider</label>
                                    <input type="text" class="form-control" id="clinic_provider" name="clinic_provider" value="<?= old('clinic_provider', $list_data->clinic_provider); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hospital Provider</label>
                                    <input type="text" class="form-control" id="hospital_provider" name="hospital_provider" value="<?= old('hospital_provider', $list_data->hospital_provider); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Employee</label>
                                    <input type="text" class="form-control" id="insurance_employee" name="insurance_employee" value="<?= old('insurance_employee', $list_data->insurance_employee); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Husband / Wife</label>
                                    <input type="text" class="form-control" id="insurance_couple" name="insurance_couple" value="<?= old('insurance_couple', $list_data->insurance_couple); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Insurance Children</label>
                                    <input type="text" class="form-control" id="insurance_children" name="insurance_children" value="<?= old('insurance_children', $list_data->insurance_children); ?>">
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Uniform Size</label>
                                            <select class="form-select mb-3" name="uniform_size">
                                                <option value="XXS" <?= ('XXS' == $list_data->uniform_size) ? 'selected' : '' ?>>XXS</option>
                                                <option value="XS" <?= ('XS' == $list_data->uniform_size) ? 'selected' : '' ?>>XS</option>
                                                <option value="S" <?= ('S' == $list_data->uniform_size) ? 'selected' : '' ?>>S</option>
                                                <option value="M" <?= ('M' == $list_data->uniform_size) ? 'selected' : '' ?>>M</option>
                                                <option value="L" <?= ('L' == $list_data->uniform_size) ? 'selected' : '' ?>>L</option>
                                                <option value="XL" <?= ('XL' == $list_data->uniform_size) ? 'selected' : '' ?>>XL</option>
                                                <option value="2XL" <?= ('2XL' == $list_data->uniform_size) ? 'selected' : '' ?>>2XL</option>
                                                <option value="3XL" <?= ('3XL' == $list_data->uniform_size) ? 'selected' : '' ?>>3XL</option>
                                                <option value="4XL" <?= ('4XL' == $list_data->uniform_size) ? 'selected' : '' ?>>4XL</option>
                                                <option value="5XL" <?= ('5XL' == $list_data->uniform_size) ? 'selected' : '' ?>>5XL</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Shoes Size</label>
                                            <select class="form-select mb-3" name="shoes_size">
                                                <option value="37" <?= ('37' == $list_data->shoes_size) ? 'selected' : '' ?>>37</option>
                                                <option value="38" <?= ('38' == $list_data->shoes_size) ? 'selected' : '' ?>>38</option>
                                                <option value="39" <?= ('39' == $list_data->shoes_size) ? 'selected' : '' ?>>39</option>
                                                <option value="40" <?= ('40' == $list_data->shoes_size) ? 'selected' : '' ?>>40</option>
                                                <option value="41" <?= ('41' == $list_data->shoes_size) ? 'selected' : '' ?>>41</option>
                                                <option value="42" <?= ('42' == $list_data->shoes_size) ? 'selected' : '' ?>>42</option>
                                                <option value="43" <?= ('43' == $list_data->shoes_size) ? 'selected' : '' ?>>43</option>
                                                <option value="44" <?= ('44' == $list_data->shoes_size) ? 'selected' : '' ?>>44</option>
                                                <option value="45" <?= ('45' == $list_data->shoes_size) ? 'selected' : '' ?>>45</option>
                                                <option value="46" <?= ('46' == $list_data->shoes_size) ? 'selected' : '' ?>>46</option>
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
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->gender_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?= old('place_of_birth', $list_data->place_of_birth); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth', $list_data->date_of_birth); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Blood Type</label>
                                    <select class="form-select mb-3" name="blood_type">
                                        <option value="A" <?= ('A' == $list_data->blood_type) ? 'selected' : '' ?>>A</option>
                                        <option value="B" <?= ('B' == $list_data->blood_type) ? 'selected' : '' ?>>B</option>
                                        <option value="AB" <?= ('AB' == $list_data->blood_type) ? 'selected' : '' ?>>AB</option>
                                        <option value="O" <?= ('O' == $list_data->blood_type) ? 'selected' : '' ?>>O</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= old('phone_number', $list_data->phone_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $list_data->email); ?>">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">&nbsp;</h4>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="address" name="address" class="form-control" style="height: 131px;"><?= $list_data->address; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Identity Number (KTP)</label>
                                    <input type="text" class="form-control" id="identity_number" name="identity_number" value="<?= old('identity_number', $list_data->identity_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Identity Family Number (KK)</label>
                                    <input type="text" class="form-control" id="identity_family_number" name="identity_family_number" value="<?= old('identity_family_number', $list_data->identity_family_number); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Religion</label>
                                    <select class="form-select mb-3" name="religion" required>
                                        <option value="Islam" <?= ('Islam' == $list_data->religion) ? 'selected' : '' ?>>Islam</option>
                                        <option value="Protestan" <?= ('Protestan' == $list_data->religion) ? 'selected' : '' ?>>Protestan</option>
                                        <option value="Katolik" <?= ('Katolik' == $list_data->religion) ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= ('Hindu' == $list_data->religion) ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= ('Buddha' == $list_data->religion) ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= ('Konghucu' == $list_data->religion) ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <select class="form-select mb-3" name="education_id" required>
                                        <?php foreach ($education as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->education_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
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
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->marriage_status_id) ? 'selected' : '' ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mother's Name</label>
                                    <input type="text" class="form-control" id="mothers_name" name="mothers_name" value="<?= old('mothers_name', $list_data->mothers_name); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Number of Children</label>
                                    <input type="number" class="form-control" id="number_of_children" name="number_of_children" value="<?= old('number_of_children', $list_data->number_of_children); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Picture</label>
                                    <input class="form-control" type="file" name="picture" id="sampul" onchange="previewImg()">
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="oldPicture" value="<?= $list_data->picture; ?>">
                                    <img src="<?= base_url('employee_picture/' . $list_data->picture); ?>" height="160" alt="" class="img-preview">
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Identity Information (KTP)</h4>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address_identity" id="" class="form-control" style="height: 131px;"><?= $list_data->address_identity; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">RT</label>
                                            <input type="text" class="form-control" name="rt" value="<?= old('rt', $list_data->rt); ?>">
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">RW</label>
                                            <input type="text" class="form-control" name="rw" value="<?= old('rw', $list_data->rw); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Provincies</label>
                                    <select class="form-control select2" data-toggle="select2" name="provinces_id" onchange="fetchRergenciesData(this.value)">
                                        <option value="">&nbsp;</option>
                                        <?php foreach ($provinces as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->provinces_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Regencies</label>
                                    <select class="form-control select2" data-toggle="select2" name="regencies_id" id="regenciesID" onchange="fetchDistrictsData(this.value)">
                                        <option value="">&nbsp;</option>
                                        <?php foreach ($regencies as $row) : ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->regencies_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Districts</label>
                                            <select class="form-control select2" data-toggle="select2" name="districts_id" id="districtsID" onchange="fetchVillagesData(this.value)">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($districts as $row) : ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->districts_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-12">
                                            <label class="form-label">Villages</label>
                                            <select class="form-control select2" data-toggle="select2" name="villages_id" id="villagesID">
                                                <option value="">&nbsp;</option>
                                                <?php foreach ($villages as $row) : ?>
                                                    <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->villages_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                                <?php endforeach; ?>
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
                                <h4 class="header-title">Family Information</h4>
                                <div class="mb-3">
                                    <label class="form-label">Husband / Wife Name</label>
                                    <input type="text" class="form-control" id="couple" name="couple" value="<?= old('couple', $list_data->couple); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Husband / Wife date of birth</label>
                                    <input type="date" class="form-control" id="couple_date_of_birth" name="couple_date_of_birth" value="<?= old('couple_date_of_birth', $list_data->couple_date_of_birth); ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                <h4 class="header-title">Children's</h4>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">1st child</label>
                                            <input type="text" class="form-control" id="child_1" name="child_1" value="<?= old('child_1', $list_data->child_1); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">gender</label>
                                            <select class="form-control" name="child_1_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki" <?= ('Laki-laki' == $list_data->child_1_gender) ? 'selected' : null ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= ('Perempuan' == $list_data->child_1_gender) ? 'selected' : null ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">birthday</label>
                                            <input type="date" class="form-control" id="child_1_birthday" name="child_1_birthday" value="<?= old('child_1_birthday', $list_data->child_1_birthday); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">2nd child</label>
                                            <input type="text" class="form-control" id="child_2" name="child_2" value="<?= old('child_2', $list_data->child_2); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">gender</label>
                                            <select class="form-control" name="child_2_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki" <?= ('Laki-laki' == $list_data->child_2_gender) ? 'selected' : null ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= ('Perempuan' == $list_data->child_2_gender) ? 'selected' : null ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">birthday</label>
                                            <input type="date" class="form-control" id="child_2_birthday" name="child_2_birthday" value="<?= old('child_2_birthday', $list_data->child_2_birthday); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">3rd child</label>
                                            <input type="text" class="form-control" id="child_3" name="child_3" value="<?= old('child_3', $list_data->child_3); ?>">
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">gender</label>
                                            <select class="form-control" name="child_3_gender">
                                                <option value="">&nbsp;</option>
                                                <option value="Laki-laki" <?= ('Laki-laki' == $list_data->child_3_gender) ? 'selected' : null ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= ('Perempuan' == $list_data->child_3_gender) ? 'selected' : null ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-sm-12">
                                            <label class="form-label">birthday</label>
                                            <input type="date" class="form-control" id="child_3_birthday" name="child_3_birthday" value="<?= old('child_3_birthday', $list_data->child_3_birthday); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-12">
                                <h4 class="header-title">Emergency Calling</h4>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="<?= old('emergency_name', $list_data->emergency_name); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Relathionship</label>
                                    <input type="text" class="form-control" id="emergency_relathionship" name="emergency_relathionship" value="<?= old('emergency_relathionship', $list_data->emergency_relathionship); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?= old('emergency_contact', $list_data->emergency_contact); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>