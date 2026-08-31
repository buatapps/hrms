<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Employee extends BaseController
{
    public function nonAktif()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));

        return view('employee/non-aktif', [
            'title' => 'Employee Non-active',
            'list_data' => $this->EmployeeModel->dataEmployeeNonActive($division_id)
        ]);
    }

    public function index()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $gender_id = null;
        $plant_id = null;
        $employee_group_id = null;
        $employee_status_id = null;
        $company_id = null;
        $gender = $this->GenderModel->findAll();
        $employee_status = $this->EmployeeStatusModel->findAll();
        $plant = $this->PlantModel->findAll();
        $group = $this->EmployeeGroupModel->findAll();
        // Ambil daftar division untuk select option
        if (in_groups('admin')) {
            $division = $this->DivisionModel->where('id', user()->division_id)->findAll(); // cuma divisi admin
        } else {
            $division = $this->DivisionModel->findAll(); // semua divisi
        }

        $namicoh = [
            'total'           => $this->DashboardModel->countEmployee(null, null, 1, 12),
            'nonactive'       => $this->DashboardModel->countEmployee(3, null, 1, 12),
            'activePermanent' => $this->DashboardModel->countEmployee(1, null, 1, 12),
            'activeContract'  => $this->DashboardModel->countEmployee(2, null, 1, 12),
            'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, 1, 12),
            'men'             => $this->DashboardModel->countEmployee([1, 2], 1, 1, 12),
            'women'           => $this->DashboardModel->countEmployee([1, 2], 2, 1, 12),
        ];

        $japan = [
            'total'           => $this->DashboardModel->countEmployee(null, null, null, null, 12),
            'nonactive'       => $this->DashboardModel->countEmployee(3, null, null, null, 12),
            'activePermanent' => $this->DashboardModel->countEmployee(1, null, null, null, 12),
            'activeContract'  => $this->DashboardModel->countEmployee(2, null, null, null, 12),
            'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, null, null, 12),
            'men'             => $this->DashboardModel->countEmployee(null, 1, null, null, 12),
            'women'           => $this->DashboardModel->countEmployee(null, 2, null, null, 12),
        ];

        $data = [
            'title'     => 'Employee Data',
            'list_data' => $this->EmployeeModel->dataEmployeeIndex($division_id),
            'gender'    => $gender,
            'employee_status' => $employee_status,
            'gender_id' => $gender_id,
            'plant'     => $plant,
            'plant_id'  => $plant_id,
            'group'     => $group,
            'division'     => $division,
            'division_id'     => $division_id,
            'employee_group_id' => $employee_group_id,
            'employee_status_id' => $employee_status_id,
            'company'   => $this->CompanyModel->findAll(),
            'company_id' => $company_id,
            'namicoh' => $namicoh,
            'japan' => $japan
        ];

        if (in_groups('Japan')) {
            return view('employee/employee_japan', $data);
        } else {
            return view('employee/index', $data);
        }
    }

    public function search()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $gender_id = $this->request->getVar('gender_id');
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');
        $employee_status_id = $this->request->getVar('employee_status_id');
        $company_id = $this->request->getVar('company_id');
        $gender = $this->GenderModel->findAll();
        $employee_status = $this->EmployeeStatusModel->findAll();
        $plant = $this->PlantModel->findAll();
        $group = $this->EmployeeGroupModel->findAll();
        if (in_groups('admin')) {
            $division = $this->DivisionModel->where('id', user()->division_id)->findAll(); // cuma divisi admin
        } else {
            $division = $this->DivisionModel->findAll(); // semua divisi
        }

        $namicoh = [
            'total'           => $this->DashboardModel->countEmployee(null, null, 1, 12),
            'nonactive'       => $this->DashboardModel->countEmployee(3, null, 1, 12),
            'activePermanent' => $this->DashboardModel->countEmployee(1, null, 1, 12),
            'activeContract'  => $this->DashboardModel->countEmployee(2, null, 1, 12),
            'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, 1, 12),
            'men'             => $this->DashboardModel->countEmployee(null, 1, 1, 12),
            'women'           => $this->DashboardModel->countEmployee(null, 2, 1, 12),
        ];

        $japan = [
            'total'           => $this->DashboardModel->countEmployee(null, null, null, null, 12),
            'nonactive'       => $this->DashboardModel->countEmployee(3, null, null, null, 12),
            'activePermanent' => $this->DashboardModel->countEmployee(1, null, null, null, 12),
            'activeContract'  => $this->DashboardModel->countEmployee(2, null, null, null, 12),
            'totalActive'     => $this->DashboardModel->countEmployee([1, 2], null, null, null, 12),
            'men'             => $this->DashboardModel->countEmployee(null, 1, null, null, 12),
            'women'           => $this->DashboardModel->countEmployee(null, 2, null, null, 12),
        ];

        $list_data = $this->EmployeeModel->employeeDetailsSearch($gender_id, $employee_status_id, $plant_id, $employee_group_id, $division_id, $company_id);

        $data = [
            'title'     => 'Employee Data',
            'list_data' => $list_data,
            'gender'    => $gender,
            'employee_status' => $employee_status,
            'gender_id' => $gender_id,
            'plant'     => $plant,
            'plant_id'  => $plant_id,
            'group'     => $group,
            'division'     => $division,
            'division_id'     => $division_id,
            'employee_group_id' => $employee_group_id,
            'employee_status_id' => $employee_status_id,
            'company'   => $this->CompanyModel->findAll(),
            'company_id' => $company_id,
            'namicoh' => $namicoh,
            'japan' => $japan
        ];

        if (in_groups('Japan')) {
            return view('employee/employee_japan', $data);
        } else {
            return view('employee/index', $data);
        }
    }

    public function add()
    {
        $company = $this->CompanyModel->findAll();
        $division = $this->DivisionModel->findAll();
        $position = $this->PositionModel->findAll();
        $education = $this->EducationModel->findAll();
        $employee_status = $this->EmployeeStatusModel->findAll();
        $bank = $this->BankModel->findAll();
        $gender = $this->GenderModel->findAll();
        $marriage_status = $this->MarriageStatusModel->findAll();
        $plant = $this->PlantModel->findAll();
        $employee_group = $this->EmployeeGroupModel->findAll();
        $tax_status = $this->TaxStatusModel->findAll();

        $provinces = $this->DependentModel->selectData("provinces");

        $validation = \Config\Services::validation();

        $data = [
            'title'     => 'Add Employee',
            'company'   => $company,
            'division'   => $division,
            'position'   => $position,
            'plant'   => $plant,
            'employee_group'   => $employee_group,
            'tax_status'   => $tax_status,
            'education'   => $education,
            'employee_status'   => $employee_status,
            'bank'   => $bank,
            'gender'   => $gender,
            'marriage_status'   => $marriage_status,
            'validation'    => $validation,
            'provinces'     => $provinces
        ];

        return view('employee/add', $data);
    }

    public function getRegencies()
    {
        $provinces_id = $this->request->getVar('cProvinces_id');
        $regencies = $this->DependentModel->selectData("regencies", array('province_id' => $provinces_id));
        echo json_encode($regencies);
    }

    public function getDistricts()
    {
        $regencies_id = $this->request->getVar('cRegencies_id');
        $districts = $this->DependentModel->selectData("districts", array('regency_id' => $regencies_id));
        echo json_encode($districts);
    }

    public function getVillages()
    {
        $districts_id = $this->request->getVar('cDistricts_id');
        $villages = $this->DependentModel->selectData("villages", array('district_id' => $districts_id));
        echo json_encode($villages);
    }

    public function save()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $picture = $this->request->getFile('picture');
        if (! $picture->isValid()) {
            $pictureName = 'user-1.jpg';
        } else {
            $pictureName = $picture->getRandomName();
            $picture->move('employee_picture', $pictureName);
        }

        $data = [
            'company_id'         => $this->request->getVar('company_id'),
            'name'               => $this->request->getVar('name'),
            'employee_id'        => $this->request->getVar('employee_id'),
            'employee_pin'       => $this->request->getVar('employee_pin'),
            'division_id'        => $this->request->getVar('division_id'),
            'position_id'        => $this->request->getVar('position_id'),
            'plant_id'           => $this->request->getVar('plant_id'),
            'employee_group_id'  => $this->request->getVar('employee_group_id'),
            'education_id'       => $this->request->getVar('education_id'),
            'product_synchronization' => $this->request->getVar('product_synchronization'),
            'date_of_entry'      => $this->request->getVar('date_of_entry'),
            'employee_status_id' => $this->request->getVar('employee_status_id'),
            'working_days'       => $this->request->getVar('working_days'),
            'bank_id'            => $this->request->getVar('bank_id'),
            'account_number'     => $this->request->getVar('account_number'),
            'salary'             => $this->request->getVar('salary'),
            'npwp_number'        => $this->request->getVar('npwp_number'),
            'tax_status_id'      => $this->request->getVar('tax_status_id'),
            'ketenagakerjaan_number' => $this->request->getVar('ketenagakerjaan_number'),
            'kesehatan_number'   => $this->request->getVar('kesehatan_number'),
            'clinic_provider'    => $this->request->getVar('clinic_provider'),
            'hospital_provider'  => $this->request->getVar('hospital_provider'),
            'insurance_employee'  => $this->request->getVar('insurance_employee'),
            'insurance_couple'  => $this->request->getVar('insurance_couple'),
            'insurance_children'  => $this->request->getVar('insurance_children'),
            'blood_type'      => $this->request->getVar('blood_type'),
            'uniform_size'    => $this->request->getVar('uniform_size'),
            'shoes_size'      => $this->request->getVar('shoes_size'),
            'gender_id'          => $this->request->getVar('gender_id'),
            'place_of_birth'     => $this->request->getVar('place_of_birth'),
            'date_of_birth'      => $this->request->getVar('date_of_birth'),
            'address'            => $this->request->getVar('address'),
            'address_identity'   => $this->request->getVar('address_identity'),
            'rt'                 => $this->request->getVar('rt'),
            'rw'                 => $this->request->getVar('rw'),
            'villages_id'        => $this->request->getVar('villages_id'),
            'districts_id'       => $this->request->getVar('districts_id'),
            'regencies_id'       => $this->request->getVar('regencies_id'),
            'provinces_id'       => $this->request->getVar('provinces_id'),
            'phone_number'       => $this->request->getVar('phone_number'),
            'email'              => $this->request->getVar('email'),
            'identity_number'    => $this->request->getVar('identity_number'),
            'identity_family_number' => $this->request->getVar('identity_family_number'),
            'religion'        => $this->request->getVar('religion'),
            'marriage_status_id' => $this->request->getVar('marriage_status_id'),
            'mothers_name'       => $this->request->getVar('mothers_name'),
            'number_of_children' => $this->request->getVar('number_of_children'),
            'couple'             => $this->request->getVar('couple'),
            'couple_date_of_birth' => $this->request->getVar('couple_date_of_birth'),
            'emergency_name'  => $this->request->getVar('emergency_name'),
            'emergency_relathionship'  => $this->request->getVar('emergency_relathionship'),
            'emergency_contact'  => $this->request->getVar('emergency_contact'),
            'child_1'            => $this->request->getVar('child_1'),
            'child_1_birthday'   => $this->request->getVar('child_1_birthday'),
            'child_1_gender'   => $this->request->getVar('child_1_gender'),
            'child_2'            => $this->request->getVar('child_2'),
            'child_2_birthday'   => $this->request->getVar('child_2_birthday'),
            'child_2_gender'   => $this->request->getVar('child_2_gender'),
            'child_3'            => $this->request->getVar('child_3'),
            'child_3_gender'   => $this->request->getVar('child_3_gender'),
            'picture'            => $pictureName
        ];

        if (! $this->EmployeeModel->insert($data)) {
            return redirect()
                ->to(base_url('employee/add'))
                ->withInput()
                ->with('error', 'Data employee gagal, mohon diulang');
        }

        $employeeId = $this->EmployeeModel->getInsertID();

        //get data contract dan simpan contract disini
        $contractData = [
            'employee_id'     => $employeeId,
            'contract_types_id'     => $this->request->getVar('contract_types_id'),
            'division_id'        => $this->request->getVar('division_id'),
            'salary'     => $this->request->getVar('salary'),
            'start_date'     => $this->request->getVar('start_date_contract'),
            'end_date'     => $this->request->getVar('end_date_contract'),
            'contract_statuses_id'     => 2, //active
        ];

        // print_r($contractData);
        // die();

        if (! $this->ContractModel->insert($contractData)) {
            $db = \Config\Database::connect();
            $error = $db->error(); // array with 'code' and 'message'
            dd($error);
            return redirect()
                ->to(base_url('employee/add'))
                ->withInput()
                ->with('error', 'Contract harus diisi');
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()
                ->to(base_url('employee/add'))
                ->withInput()
                ->with('error', 'Gagal simpan, tolong diulangi');
        }

        return redirect()->to(base_url('employee'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $list_data = $this->EmployeeModel->where(['id' => $id])->first();

        if ($list_data === null) {
            return redirect()->to(base_url('employee'))->with('error', 'Data employee tidak ditemukan');
        }

        $company = $this->CompanyModel->findAll();
        $division = $this->DivisionModel->findAll();
        $position = $this->PositionModel->findAll();
        $education = $this->EducationModel->findAll();
        $employee_status = $this->EmployeeStatusModel->findAll();
        $bank = $this->BankModel->findAll();
        $gender = $this->GenderModel->findAll();
        $marriage_status = $this->MarriageStatusModel->findAll();
        $plant = $this->PlantModel->findAll();
        $employee_group = $this->EmployeeGroupModel->findAll();
        $tax_status = $this->TaxStatusModel->findAll();
        $provinces = $this->DependentModel->selectData("provinces");
        $regencies = $this->DependentModel->selectData("regencies", array('province_id' => $list_data->provinces_id));
        $districts = $this->DependentModel->selectData("districts", array('regency_id' => $list_data->regencies_id));
        $villages = $this->DependentModel->selectData("villages", array('district_id' => $list_data->districts_id));

        $data = [
            'title'     => 'Edit Employee',
            'list_data' => $list_data,
            'company'   => $company,
            'division'   => $division,
            'position'   => $position,
            'plant'   => $plant,
            'employee_group'   => $employee_group,
            'tax_status'   => $tax_status,
            'education'   => $education,
            'employee_status'   => $employee_status,
            'bank'   => $bank,
            'gender'   => $gender,
            'marriage_status'   => $marriage_status,
            'provinces'   => $provinces,
            'regencies'   => $regencies,
            'districts'   => $districts,
            'villages'   => $villages,
            'validation'    => \Config\Services::validation()
        ];

        return view('employee/edit', $data);
    }

    public function update($id)
    {
        $picture = $this->request->getFile('picture');
        if (! $picture->isValid()) {
            $pictureName = $this->request->getVar('oldPicture');
        } else {
            $pictureName = $picture->getRandomName();
            $picture->move('employee_picture', $pictureName);
        }

        $data = [
            'id'        => $id,
            'company_id'         => $this->request->getVar('company_id'),
            'name'               => $this->request->getVar('name'),
            'employee_id'        => $this->request->getVar('employee_id'),
            'employee_pin'       => $this->request->getVar('employee_pin'),
            'division_id'        => $this->request->getVar('division_id'),
            'position_id'        => $this->request->getVar('position_id'),
            'plant_id'           => $this->request->getVar('plant_id'),
            'employee_group_id'  => $this->request->getVar('employee_group_id'),
            'education_id'       => $this->request->getVar('education_id'),
            'product_synchronization' => $this->request->getVar('product_synchronization'),
            'date_of_entry'      => $this->request->getVar('date_of_entry'),
            'employee_status_id' => $this->request->getVar('employee_status_id'),
            'working_days'       => $this->request->getVar('working_days'),
            'bank_id'            => $this->request->getVar('bank_id'),
            'account_number'     => $this->request->getVar('account_number'),
            'salary'             => $this->request->getVar('salary'),
            'npwp_number'        => $this->request->getVar('npwp_number'),
            'tax_status_id'      => $this->request->getVar('tax_status_id'),
            'ketenagakerjaan_number' => $this->request->getVar('ketenagakerjaan_number'),
            'kesehatan_number'   => $this->request->getVar('kesehatan_number'),
            'clinic_provider'    => $this->request->getVar('clinic_provider'),
            'hospital_provider'  => $this->request->getVar('hospital_provider'),
            'insurance_employee' => $this->request->getVar('insurance_employee'),
            'insurance_couple'   => $this->request->getVar('insurance_couple'),
            'insurance_children' => $this->request->getVar('insurance_children'),
            'blood_type'      => $this->request->getVar('blood_type'),
            'uniform_size'    => $this->request->getVar('uniform_size'),
            'shoes_size'      => $this->request->getVar('shoes_size'),
            'gender_id'          => $this->request->getVar('gender_id'),
            'place_of_birth'     => $this->request->getVar('place_of_birth'),
            'date_of_birth'      => $this->request->getVar('date_of_birth'),
            'address'            => $this->request->getVar('address'),
            'address_identity'   => $this->request->getVar('address_identity'),
            'rt'                 => $this->request->getVar('rt'),
            'rw'                 => $this->request->getVar('rw'),
            'villages_id'        => $this->request->getVar('villages_id'),
            'districts_id'       => $this->request->getVar('districts_id'),
            'regencies_id'       => $this->request->getVar('regencies_id'),
            'provinces_id'       => $this->request->getVar('provinces_id'),
            'phone_number'       => $this->request->getVar('phone_number'),
            'email'              => $this->request->getVar('email'),
            'identity_number'    => $this->request->getVar('identity_number'),
            'identity_family_number' => $this->request->getVar('identity_family_number'),
            'religion'        => $this->request->getVar('religion'),
            'marriage_status_id' => $this->request->getVar('marriage_status_id'),
            'mothers_name'       => $this->request->getVar('mothers_name'),
            'number_of_children' => $this->request->getVar('number_of_children'),
            'couple'             => $this->request->getVar('couple'),
            'couple_date_of_birth' => $this->request->getVar('couple_date_of_birth'),
            'emergency_name'     => $this->request->getVar('emergency_name'),
            'emergency_relathionship'  => $this->request->getVar('emergency_relathionship'),
            'emergency_contact'  => $this->request->getVar('emergency_contact'),
            'child_1'            => $this->request->getVar('child_1'),
            'child_1_birthday'   => $this->request->getVar('child_1_birthday'),
            'child_1_gender'   => $this->request->getVar('child_1_gender'),
            'child_2'            => $this->request->getVar('child_2'),
            'child_2_birthday'   => $this->request->getVar('child_2_birthday'),
            'child_2_gender'   => $this->request->getVar('child_2_gender'),
            'child_3'            => $this->request->getVar('child_3'),
            'child_3_gender'   => $this->request->getVar('child_3_gender'),
            'picture'            => $pictureName
        ];

        //simpan log history plant group
        $employee_id = $id;
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');
        $oldData = $this->EmployeeModel->asArray()->find($employee_id);

        $newData = [
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id
        ];

        // 🔥 simpan log dulu
        $this->logPlantGroup($employee_id, $oldData, $newData);
        //end simpan log history plant group

        $this->EmployeeModel->save($data);

        return redirect()->to(base_url('employee/details/' . $id))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->EmployeeModel->delete($id);
        return redirect()->to(base_url('employee'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function details($id)
    {
        $list_data = $this->EmployeeModel->employeeDetails($id);
        $tgl_masuk = $list_data['date_of_entry'];
        $tgl_lahir = $list_data['date_of_birth'];

        //menghitung masa kerja
        $tanggal_masuk = new Time($tgl_masuk);
        $tanggal_lahir = new Time($tgl_lahir);
        $sekarang = new Time('now');
        $masa_kerja = $sekarang->diff($tanggal_masuk);
        $umur = $sekarang->diff($tanggal_lahir);

        //load file
        $stnk = $this->StnkModel->stnkEmployee($id);
        $sim = $this->SimModel->simEmployee($id);

        //data cuti
        // $data_cuti = $this->EmployeeModel->dataCutiEmployee($id);

        //master data
        $company = $this->CompanyModel->findAll();
        $division = $this->DivisionModel->findAll();
        $position = $this->PositionModel->findAll();
        $education = $this->EducationModel->findAll();
        $employee_status = $this->EmployeeStatusModel->findAll();
        $bank = $this->BankModel->findAll();
        $gender = $this->GenderModel->findAll();
        $marriage_status = $this->MarriageStatusModel->findAll();
        $plant = $this->PlantModel->findAll();
        $employee_group = $this->EmployeeGroupModel->findAll();
        $tax_status = $this->TaxStatusModel->findAll();
        $provinces = $this->DependentModel->selectData("provinces");
        $regencies = $this->DependentModel->selectData("regencies", array('province_id' => $list_data['provinces_id']));
        $districts = $this->DependentModel->selectData("districts", array('regency_id' => $list_data['regencies_id']));
        $villages = $this->DependentModel->selectData("villages", array('district_id' => $list_data['districts_id']));
        $uniform = $this->UniformSizeModel->findAll();
        $shoes = $this->ShoesSizeModel->findAll();

        $currentMonth = date('m');
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $currentMonthName = $bulanIndo[date('n')];
        $currentYear  = date('Y');

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $schedule = $this->EmployeeScheduleModel->getScheduleEmployee($id, $start_date, $end_date);

        $attendance = $this->AttendanceModel->dataAttendanceEmployeeUserWithAllDates($id, $start_date, $end_date);
        $files = $this->EmployeeUploadsModel->where('employee_id', $id)->orderBy('created_at', 'DESC')->findAll();

        //History
        $absent_type = $this->AbsentTypeModel->findAll();
        $locker_history = $this->LockerHistoryModel->DataLockerHistory();
        $contracts = $this->ContractModel->getContractsByEmployee($id);
        $sertifikat = $this->SertifikatModel->db->table('sertifikat')
            ->select('sertifikat.*, tipe_sertifikat.tipe_sertifikat')
            ->join('tipe_sertifikat', 'tipe_sertifikat.id = sertifikat.tipe_sertifikat_id')
            ->where('sertifikat.employee_id', $id)
            ->where('sertifikat.deleted_at', null)
            ->orderBy('sertifikat.id', 'DESC')
            ->get()->getResultObject();

        $data = [
            'title'     => 'Details Employee',
            'list_data' => $list_data,
            'masa_kerja' => $masa_kerja,
            'umur' => $umur,
            'stnk' => $stnk,
            'sim' => $sim,
            // 'data_cuti' => $data_cuti,
            'company' => $company,
            'division' => $division,
            'position' => $position,
            'education' => $education,
            'employee_status' => $employee_status,
            'bank' => $bank,
            'gender' => $gender,
            'marriage_status' => $marriage_status,
            'plant' => $plant,
            'employee_group' => $employee_group,
            'tax_status' => $tax_status,
            'provinces' => $provinces,
            'regencies' => $regencies,
            'districts' => $districts,
            'villages' => $villages,
            'uniform' => $uniform,
            'shoes' => $shoes,
            'currentMonth' => $currentMonth,
            'currentMonthName' => $currentMonthName,
            'currentYear' => $currentYear,
            'schedule' => $schedule,
            'attendance' => $attendance,
            'files' => $files,
            'absent_type' => $absent_type,
            'locker_history' => $locker_history,
            'contracts' => $contracts,
            'sertifikat' => $sertifikat
        ];

        return view('employee/details_japan', $data);
    }

    public function employeeAbsentHistoryAjax()
    {
        $employeeId = $this->request->getGet('employee_id');
        $type       = $this->request->getGet('absent_type') ?? 'all';
        $period     = $this->request->getGet('period');

        $startDate = null;
        $endDate   = null;

        // =========================
        // 1. RESOLVE PERIOD
        // =========================
        switch ($period) {

            case 'this_month':
                $startDate = date('Y-m-01');
                $endDate   = date('Y-m-t');
                break;

            case 'last_3_month':
                $startDate = date('Y-m-01', strtotime('-2 month'));
                $endDate   = date('Y-m-t');
                break;

            case 'last_6_month':
                $startDate = date('Y-m-01', strtotime('-5 month'));
                $endDate   = date('Y-m-t');
                break;

            case 'this_year':
                $startDate = date('Y-01-01');
                $endDate   = date('Y-12-31');
                break;

            case 'custom':
                $startDate = $this->request->getGet('start_date');
                $endDate   = $this->request->getGet('end_date');
                break;

            default:
                $startDate = date('Y-m-01');
                $endDate   = date('Y-m-t');
                break;
        }

        // =========================
        // 2. GET DATA FROM MODEL
        // =========================
        $rows = $this->EmployeeModel->getAbsentHistory(
            $employeeId,
            $startDate,
            $endDate,
            $type
        );

        // =========================
        // 3. BUILD SUMMARY
        // =========================
        $summary = [];

        foreach ($rows as $r) {
            $typeName = $r['type_name'];
            $summary[$typeName] = ($summary[$typeName] ?? 0) + 1;
        }

        $summaryFormatted = [];

        foreach ($summary as $name => $total) {
            $summaryFormatted[] = [
                'name'  => $name,
                'total' => $total
            ];
        }

        $formattedRows = [];

        foreach ($rows as $r) {

            $formattedRows[] = [
                'date' => date('j M Y', strtotime($r['date'])),
                'type_name' => $r['type_name']
            ];
        }

        // =========================
        // 4. PERIOD LABEL
        // =========================
        $periodLabel = date('d M Y', strtotime($startDate)) .
            ' - ' .
            date('d M Y', strtotime($endDate));


        // =========================
        // 5. RETURN JSON
        // =========================
        return $this->response->setJSON([
            'period_label' => $periodLabel,
            'rows'         => $formattedRows,
            'summary'      => $summaryFormatted
        ]);
    }


    public function export_excel()
    {
        $gender_id = $this->request->getVar('gender_id');
        $employee_status_id = $this->request->getVar('employee_status_id');
        $division_id = $this->request->getVar('division_id');
        $company_id = $this->request->getVar('company_id');

        // $list_data = $this->EmployeeModel->employeeDetails();
        $list_data = $this->EmployeeModel->employeeExport($gender_id, $employee_status_id, $division_id, $company_id);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Company')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Employee ID')
            ->setCellValue('D1', 'Employee PIN')
            ->setCellValue('E1', 'Division')
            ->setCellValue('F1', 'Position')
            ->setCellValue('G1', 'Plant')
            ->setCellValue('H1', 'Group')
            ->setCellValue('I1', 'Product Synch')
            ->setCellValue('J1', 'Date of Entry')
            ->setCellValue('K1', 'Year of service')
            ->setCellValue('L1', 'Employee Status')
            ->setCellValue('M1', 'Working Days')
            ->setCellValue('N1', 'Bank')
            ->setCellValue('O1', 'Account Number')
            ->setCellValue('P1', 'Salary')
            ->setCellValue('Q1', 'NPWP')
            ->setCellValue('R1', 'Tax Status')
            ->setCellValue('S1', 'BPJS Ketenagakerjaan')
            ->setCellValue('T1', 'BPJS Kesehatan')
            ->setCellValue('U1', 'Clinic Provider')
            ->setCellValue('V1', 'Hospital Provider')
            ->setCellValue('W1', 'Insurance Employee')
            ->setCellValue('X1', 'Insurance Husband / Wife')
            ->setCellValue('Y1', 'Insurance Children')
            ->setCellValue('Z1', 'Uniform Size')
            ->setCellValue('AA1', 'Shoes Size')
            ->setCellValue('AB1', 'Gender')
            ->setCellValue('AC1', 'Place of birth')
            ->setCellValue('AD1', 'Date of birth')
            ->setCellValue('AE1', 'Age')
            ->setCellValue('AF1', 'Blood type')
            ->setCellValue('AG1', 'Address')
            ->setCellValue('AH1', 'Phone Number')
            ->setCellValue('AI1', 'Email')
            ->setCellValue('AJ1', 'Identity Number (KTP)')
            ->setCellValue('AK1', 'Identity Family Number (KK)')
            ->setCellValue('AL1', 'Religion')
            ->setCellValue('AM1', 'Education')
            ->setCellValue('AN1', 'Marriage Status')
            ->setCellValue('AO1', 'Mothers Name')
            ->setCellValue('AP1', 'Number of Children')
            ->setCellValue('AQ1', 'Address (KTP)')
            ->setCellValue('AR1', 'RT')
            ->setCellValue('AS1', 'RW')
            ->setCellValue('AT1', 'Provinces')
            ->setCellValue('AU1', 'Regencies')
            ->setCellValue('AV1', 'Districts')
            ->setCellValue('AW1', 'Villages')
            ->setCellValue('AX1', 'Husband / Wife Name')
            ->setCellValue('AY1', 'Husband / Wife date of birth')
            ->setCellValue('AZ1', '1st Child Name')
            ->setCellValue('BA1', '1st Child birthday')
            ->setCellValue('BB1', '1st Child gender')
            ->setCellValue('BC1', '2nd Child Name')
            ->setCellValue('BD1', '2nd Child birthday')
            ->setCellValue('BE1', '2nd Child gender')
            ->setCellValue('BF1', '3rd Child Name')
            ->setCellValue('BG1', '3rd Child birthday')
            ->setCellValue('BH1', '3rd Child gender')
            ->setCellValue('BI1', 'Emregency Calling Name')
            ->setCellValue('BJ1', 'Relathionship')
            ->setCellValue('BK1', 'Contact Number');
        $column = 2;

        foreach ($list_data as $row) {

            $tgl_masuk = $row->date_of_entry;
            $tgl_lahir = $row->date_of_birth;

            //menghitung masa kerja
            $tanggal_masuk = new Time($tgl_masuk);
            $tanggal_lahir = new Time($tgl_lahir);
            $sekarang = new Time('now');
            $masa_kerja = $sekarang->diff($tanggal_masuk);
            $umur = $sekarang->diff($tanggal_lahir);

            $masa_kerja_ = $masa_kerja->y . ' Tahun';
            $umur_ = $umur->y . ' Tahun';

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $row->company)
                ->setCellValue('B' . $column, $row->name)
                ->setCellValue('C' . $column, $row->employee_id)
                ->setCellValue('D' . $column, $row->employee_pin)
                ->setCellValue('E' . $column, $row->division)
                ->setCellValue('F' . $column, $row->position)
                ->setCellValue('G' . $column, $row->plant)
                ->setCellValue('H' . $column, $row->employee_group)
                ->setCellValue('I' . $column, $row->product_synchronization)
                ->setCellValue('J' . $column, $row->date_of_entry)
                ->setCellValue('K' . $column, $umur_)
                ->setCellValue('L' . $column, $row->employee_status)
                ->setCellValue('M' . $column, $row->working_days)
                ->setCellValue('N' . $column, $row->bank)
                ->setCellValue('O' . $column, "'" . $row->account_number)
                ->setCellValue('P' . $column, $row->salary)
                ->setCellValue('Q' . $column, "'" . $row->npwp_number)
                ->setCellValue('R' . $column, $row->tax_status)
                ->setCellValue('S' . $column, "'" . $row->ketenagakerjaan_number)
                ->setCellValue('T' . $column, "'" . $row->kesehatan_number)
                ->setCellValue('U' . $column, $row->clinic_provider)
                ->setCellValue('V' . $column, $row->hospital_provider)
                ->setCellValue('W' . $column, "'" . $row->insurance_employee)
                ->setCellValue('X' . $column, "'" . $row->insurance_couple)
                ->setCellValue('Y' . $column, "'" . $row->insurance_children)
                ->setCellValue('Z' . $column, $row->uniform_size)
                ->setCellValue('AA' . $column, $row->shoes_size)
                ->setCellValue('AB' . $column, $row->gender)
                ->setCellValue('AC' . $column, $row->place_of_birth)
                ->setCellValue('AD' . $column, $row->date_of_birth)
                ->setCellValue('AE' . $column, $masa_kerja_)
                ->setCellValue('AF' . $column, $row->blood_type)
                ->setCellValue('AG' . $column, $row->address)
                ->setCellValue('AH' . $column, $row->phone_number)
                ->setCellValue('AI' . $column, $row->email)
                ->setCellValue('AJ' . $column, "'" . $row->identity_number)
                ->setCellValue('AK' . $column, "'" . $row->identity_family_number)
                ->setCellValue('AL' . $column, $row->religion)
                ->setCellValue('AM' . $column, $row->education)
                ->setCellValue('AN' . $column, $row->marriage_status)
                ->setCellValue('AO' . $column, $row->mothers_name)
                ->setCellValue('AP' . $column, $row->number_of_children)
                ->setCellValue('AQ' . $column, $row->address_identity)
                ->setCellValue('AR' . $column, $row->rt)
                ->setCellValue('AS' . $column, $row->rw)
                ->setCellValue('AT' . $column, $row->provinces)
                ->setCellValue('AU' . $column, $row->regencies)
                ->setCellValue('AV' . $column, $row->districts)
                ->setCellValue('AW' . $column, $row->villages)
                ->setCellValue('AX' . $column, $row->couple)
                ->setCellValue('AY' . $column, $row->couple_date_of_birth)
                ->setCellValue('AX' . $column, $row->child_1)
                ->setCellValue('BA' . $column, $row->child_1_birthday)
                ->setCellValue('BB' . $column, $row->child_1_gender)
                ->setCellValue('BC' . $column, $row->child_2)
                ->setCellValue('BD' . $column, $row->child_2_birthday)
                ->setCellValue('BE' . $column, $row->child_2_gender)
                ->setCellValue('BF' . $column, $row->child_3)
                ->setCellValue('BG' . $column, $row->child_3_birthday)
                ->setCellValue('BH' . $column, $row->child_3_gender)
                ->setCellValue('BI' . $column, $row->emergency_name)
                ->setCellValue('BJ' . $column, $row->emergency_relathionship)
                ->setCellValue('BK' . $column, $row->emergency_contact);

            $column++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = date('Y-m-d') . '-Data Employee';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function schedule()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Schedule',
            'employee'  => $this->EmployeeModel->dataEmployeeIndex($division_id)
        ];

        return view('employee/schedule', $data);
    }

    public function schedule_add($id)
    {
        $employee = $this->EmployeeModel->where('id', $id)->first();
        $shift = $this->ShiftModel->findAll();
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $schedule = $this->EmployeeScheduleModel->getScheduleEmployee($id, $start_date, $end_date);
        $data = [
            'title' => 'Schedule Add',
            'employee' => $employee,
            'shift' => $shift,
            'schedule' => $schedule,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        return view('employee/schedule_add', $data);
    }

    public function schedule_save()
    {
        $id = $this->request->getVar('id');
        $employee_pin = $this->request->getVar('employee_pin');
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
        $shift_id = $this->request->getVar('shift_id');

        $begin = new DateTime($start_date);
        $end   = new DateTime($end_date);

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $date = $i->format('Y-m-d');
            $day = $i->format('l');
            $check_working_days = $this->EmployeeModel->checkWorkingDays($shift_id, $day);
            if ($check_working_days != null) {
                foreach ($check_working_days as $row) {
                    $working_days_id =  $row->id;
                    $checkSchedule = $this->EmployeeModel->checkSchedule($employee_pin, $date);
                    $checkScheduleRowId = $checkSchedule ? $checkSchedule->id : null; // ambil id jika ada, null kalau belum

                    $this->EmployeeScheduleModel->save([
                        'id' => $checkScheduleRowId, // null = insert, ada id = update
                        'employee_id' => $id,
                        'employee_pin' => $employee_pin,
                        'date' => $date,
                        'working_days_id' => $working_days_id,
                        'day' => $day,
                    ]);
                }
            }
        }

        return redirect()->to(base_url('employee/schedule_add/' . $id))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function schedule_generate()
    {
        set_time_limit(0);
        $employee = $this->EmployeeModel->dataEmployeeIndex();
        foreach ($employee as $row) {
            $id = $row->id;
            $employee_pin = $row->employee_pin;

            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
            $shift_id = 1;

            $begin = new DateTime($start_date);
            $end   = new DateTime($end_date);

            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                $date = $i->format('Y-m-d');
                $day = $i->format('l');
                $check_working_days = $this->EmployeeModel->checkWorkingDays($shift_id, $day);
                if ($check_working_days != null) {
                    foreach ($check_working_days as $row) {
                        $working_days_id =  $row->id;
                        $checkSchedule = $this->EmployeeModel->checkSchedule($employee_pin, $date);
                        $checkScheduleRowId = $checkSchedule ? $checkSchedule->id : null; // ambil id jika ada, null kalau belum

                        $this->EmployeeScheduleModel->save([
                            'id' => $checkScheduleRowId, // null = insert, ada id = update
                            'employee_id' => $id,
                            'employee_pin' => $employee_pin,
                            'date' => $date,
                            'working_days_id' => $working_days_id,
                            'day' => $day,
                        ]);
                    }
                }
            }
        }
        return redirect()->to(base_url('employee/schedule'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function generate_schedule()
    {
        $plant = $this->PlantModel->findAll();
        $group = $this->EmployeeGroupModel->findAll();
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $shift = $this->ShiftModel->findAll();

        $data = [
            'title'     => 'Generate Schedule',
            'group'     => $group,
            'plant'     => $plant,
            'start_date' => $start_date,
            'end_date'  => $end_date,
            'shift'     => $shift
        ];

        return view('employee/generate_schedule', $data);
    }

    public function save_generate_schedule()
    {
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');
        $shift_id = $this->request->getVar('shift_id');

        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));

        $employee = $this->EmployeeModel->getEmployeeSchedule($plant_id, $employee_group_id, $division_id);

        foreach ($employee as $row) {
            $id = $row->id;
            $employee_pin = $row->employee_pin;

            $begin = new DateTime($start_date);
            $end   = new DateTime($end_date);
            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                $date = $i->format('Y-m-d');
                $day = $i->format('l');
                $check_working_days = $this->EmployeeModel->checkWorkingDays($shift_id, $day);
                if ($check_working_days != null) {
                    foreach ($check_working_days as $row) {
                        $working_days_id = $row->id;
                        $checkSchedule = $this->EmployeeModel->checkSchedule($employee_pin, $date);
                        $checkScheduleRowId = $checkSchedule ? $checkSchedule->id : null; // ambil id jika ada, null kalau belum

                        $this->EmployeeScheduleModel->save([
                            'id' => $checkScheduleRowId, // null = insert, ada id = update
                            'employee_id' => $id,
                            'employee_pin' => $employee_pin,
                            'date' => $date,
                            'working_days_id' => $working_days_id,
                            'day' => $day,
                        ]);
                    }
                }
                // jika tidak ada, tidak di add
            }
        }

        return redirect()->to(base_url('employee/generate_schedule'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function printAllCard()
    {
        $employees = $this->EmployeeModel->dataEmployeeArray();
        return view('employee/print', ['employees' => $employees]);
    }
    public function printCard($id)
    {
        $employees = $this->EmployeeModel->dataEmployeeArray($id);
        return view('employee/print', ['employees' => $employees]);
    }

    public function upload($id)
    {
        $data = [
            'title' => 'Upload File',
            'id'    => $id,
            'list_data' => $this->EmployeeModel->where(['id' => $id])->first()
        ];

        return view('employee/upload', $data);
    }

    public function upload_save($id)
    {
        $ktp = $this->request->getFile('ktp');
        $kk = $this->request->getFile('kk');

        $data = ['id' => $id];

        if ($ktp && $ktp->getError() == 0 && $ktp->isValid() && !$ktp->hasMoved()) {
            $ktpName = $ktp->getRandomName();
            $ktp->move('employee_picture', $ktpName);
            $data['ktp'] = $ktpName;
        }

        if ($kk && $kk->getError() == 0 && $kk->isValid() && !$kk->hasMoved()) {
            $kkName = $kk->getRandomName();
            $kk->move('employee_picture', $kkName);
            $data['kk'] = $kkName;
        }

        if (count($data) > 1) {
            $this->EmployeeModel->save($data);
            return redirect()->to(base_url('employee/details/' . $id))
                ->with('success', 'Dokumen <strong>berhasil</strong> diunggah.');
        } else {
            return redirect()->back()
                ->with('warning', 'Tidak ada file yang diunggah.');
        }
    }

    public function delete_file($id, $type)
    {
        $employee = $this->EmployeeModel->find($id);
        if (!$employee) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if (!in_array($type, ['ktp', 'kk'])) {
            return redirect()->back()->with('error', 'Tipe file tidak valid');
        }

        $filename = $employee->$type;
        $filepath = FCPATH . 'employee_picture/' . $filename;

        if ($filename && file_exists($filepath)) {
            unlink($filepath);
        }

        $this->EmployeeModel->update($id, [$type => null]);

        return redirect()->back()->with('success', ucfirst($type) . ' berhasil dihapus');
    }

    public function resign()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Resign',
            'list_data' => $this->ResignModel->dataResign($division_id)
        ];

        return view('employee/resign', $data);
    }

    public function resign_add()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Add Resign',
            'employee'  => $this->EmployeeModel->dataEmployeeIndex($division_id)
        ];

        return view('employee/resign_add', $data);
    }

    public function resign_save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $resign_date = $this->request->getVar('resign_date');
        $reason = $this->request->getVar('reason');
        $notes = $this->request->getVar('notes');
        $this->ResignModel->save([
            'employee_id'   => $employee_id,
            'resign_date'   => $resign_date,
            'reason'   => $reason,
            'notes'   => $notes,
        ]);

        $this->EmployeeModel->update($employee_id, [
            'resign_date'        => $resign_date,
            'employee_status_id' => 3 // Non Active
        ]);

        return redirect()->to(base_url('employee/resign'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function resign_edit($id)
    {
        $list_data = $this->ResignModel
            ->select('resign.*, data_employee.name as name')
            ->join('data_employee', 'data_employee.id = resign.employee_id')
            ->where(['resign.id' => $id])
            ->first();
        $data = [
            'title'     => 'Add Resign',
            'list_data' => $list_data
        ];

        return view('employee/resign_edit', $data);
    }

    public function resign_update($id)
    {
        $resign_date = $this->request->getVar('resign_date');
        $reason = $this->request->getVar('reason');
        $notes = $this->request->getVar('notes');

        $resignData = $this->ResignModel->find($id);
        $employee_id = $resignData->employee_id ?? null;

        $this->ResignModel->update($id, [
            'resign_date'   => $resign_date,
            'reason'   => $reason,
            'notes'   => $notes
        ]);

        $this->EmployeeModel->update($employee_id, [
            'resign_date'        => $resign_date
        ]);

        return redirect()->to(base_url('employee/resign'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function resign_delete($id)
    {
        $this->ResignModel->delete($id);
        return redirect()->to(base_url('employee/resign'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function uploads($id)
    {
        $employee = $this->EmployeeModel->where('id', $id)->first();
        $data = [
            'title'     => 'Add Files',
            'employee'  => $employee
        ];

        return view('employee/uploads', $data);
    }

    public function uploads_save()
    {
        $employee_id = $this->request->getPost('employee_id');
        $category = $this->request->getPost('category');
        $description = $this->request->getPost('description');
        $file = $this->request->getFile('file');

        $employee = $this->EmployeeModel->find($employee_id);
        $employeeSlug = strtolower(str_replace(' ', '_', $employee->name));
        $folder = WRITEPATH . 'uploads/' . $employeeSlug;

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $extension = $file->getExtension();
        $encryptedName = bin2hex(random_bytes(16)) . '.' . $extension;

        $file->move($folder, $encryptedName);

        $this->EmployeeUploadsModel->save([
            'employee_id'   => $employee_id,
            'category'   => $category,
            'description'   => $description,
            'file_name'   => $encryptedName,
            'file_path'   => 'uploads/' . $employeeSlug . '/' . $encryptedName,
            'file_size'   => $file->getSize(),
            'mime_type'   => $file->getClientMimeType(),
            'uploaded_by' => user_id(), // sesuaikan dengan auth
        ]);

        return redirect()->to(base_url('employee/details/' . $employee_id))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function download_file($id)
    {
        $file = $this->EmployeeUploadsModel->find($id);

        if (!$file) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File not found');
        }

        $filePath = WRITEPATH . $file->file_path;

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File not found');
        }

        return $this->response->download($filePath, null)->setFileName($file->file_name);
    }

    public function deleted_file($employee_id, $id)
    {


        // Ambil data file dulu
        $file = $this->EmployeeUploadsModel->find($id);
        if (!$file) {
            return redirect()->to(base_url('employee/details/' . $employee_id))
                ->with('error', 'File not found');
        }

        // Hapus file fisik
        $filePath = WRITEPATH . $file->file_path; // atau FCPATH kalau simpan di public
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus record di DB
        $this->EmployeeUploadsModel->delete($id);

        return redirect()->to(base_url('employee/details/' . $employee_id))
            ->with('success', 'File <strong>deleted</strong> successfully');
    }

    function employee_division($division_id)
    {
        $list_data = $this->EmployeeModel->getEmployeeDivision($division_id);
        $data = [
            'title' => 'Data Employee',
            'list_data' => $list_data
        ];
        return view('employee/employee_division', $data);
    }

    function employee_division_edit($id)
    {
        $list_data = $this->EmployeeModel->employeeDetails($id);
        $data = [
            'title' => 'Employee Edit',
            'list_data' => $list_data,
            'plant' => $this->PlantModel->findAll(),
            'employee_group' => $this->EmployeeGroupModel->findAll()
        ];
        return view('employee/employee_division_edit', $data);
    }

    function employee_division_update()
    {
        $division_id = user()->division_id;
        $employee_id = $this->request->getVar('id');
        $plant_id = $this->request->getVar('plant_id');
        $employee_group_id = $this->request->getVar('employee_group_id');

        $data = [
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id
        ];

        //simpan log history plant group
        $oldData = $this->EmployeeModel->asArray()->find($employee_id);

        $newData = [
            'plant_id' => $plant_id,
            'employee_group_id' => $employee_group_id
        ];

        // 🔥 simpan log dulu
        $this->logPlantGroup($employee_id, $oldData, $newData);
        //end simpan log history plant group

        $this->EmployeeModel->update($employee_id, $data);

        return redirect()->to(base_url('employee/employee_division/' . $division_id))->with('success', 'data <strong>updated</strong> successfully');
    }

    private function logPlantGroup($employee_id, $oldData, $newData)
    {
        if (
            $oldData['plant_id'] == $newData['plant_id'] &&
            $oldData['employee_group_id'] == $newData['employee_group_id']
        ) {
            return;
        }

        $this->LogHistoryModel->insertLog([
            'employee_id' => $employee_id,
            'old_plant_id' => $oldData['plant_id'],
            'old_group_id' => $oldData['employee_group_id'],
            'new_plant_id' => $newData['plant_id'],
            'new_group_id' => $newData['employee_group_id'],
            'changed_by' => user()->id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
