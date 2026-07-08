<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use DateTime;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class Contract extends BaseController
{
    public function index()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $data = [
            'title'     => 'Contract',
            'divisions' => $this->DivisionModel->findAll(),
            'statuses' => $this->ContractStatusesModel->findAll(),
            'list_data' => $this->ContractModel->dataContract($division_id)
        ];

        return view('contract/index', $data);
    }

    public function add()
    {
        $datetime = Time::parse('now');
        $newDate = $datetime->addYears(1);
        $newDates = explode(' ', $newDate);
        $end_date = $newDates[0];
        $data = [
            'title'     => 'Add Contract',
            'employee'  => $this->EmployeeModel->where(['employee_status_id' => 2])->findAll(),
            'contractTypes' => $this->ContractTypesModel->where('is_initial', 1)->findAll(),
            'division' => $this->DivisionModel->findAll(),
            'end_date' => $end_date
        ];

        return view('contract/add', $data);
    }

    public function save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $division_id = $this->request->getVar('division_id');
        $contract_types_id = $this->request->getVar('contract_types_id');
        $employee = $this->EmployeeModel->where('id', $employee_id)->first();

        $hasK1SameDivision = $this->ContractModel
            ->everHasContractTypeInDivision($employee_id, 1, $division_id);

        $hasRecall = $this->ContractModel
            ->everHasContractType($employee_id, 3);

        $active = $this->ContractModel
            ->hasActiveContract($employee_id);

        if ($active) {
            return redirect()->back()
                ->with('error', 'Masih ada kontrak aktif. Akhiri kontrak sebelumnya dulu.');
        }

        // K1
        if ($contract_types_id == 1 && $hasK1SameDivision) {
            return redirect()->back()
                ->with('error', 'Karyawan sudah pernah memiliki Kontrak 1 di divisi ini');
        }

        // Re-Call
        if ($contract_types_id == 3 && $hasRecall) {
            return redirect()->back()
                ->with('error', 'Karyawan hanya boleh Re-Call satu kali');
        }

        $this->ContractModel->save([
            'employee_id'       => $employee_id,
            'contract_types_id' => $contract_types_id,
            'division_id'       => $this->request->getVar('division_id'),
            'salary'            => $employee->salary,
            'contract_statuses_id' => 2, //active, karena tidak butuh approval
            'start_date'        => $this->request->getVar('start_date'),
            'end_date'          => $this->request->getVar('end_date'),
        ]);

        return redirect()->to(base_url('contract'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'edit Contract',
            'employee'  => $this->EmployeeModel->where(['employee_status_id' => 2])->findAll(),
            'contract_type' => $this->ContractTypesModel->findAll(),
            'contract_statuses' => $this->ContractStatusesModel->findAll(),
            'list_data' => $this->ContractModel->ContractEmployeeID($id)
        ];

        return view('contract/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $this->ContractModel->save([
            'id'        => $id,
            'contract'  => $this->request->getVar('contract'),
            'start_date'  => $this->request->getVar('start_date'),
            'end_date'  => $this->request->getVar('end_date'),
            'contract_statuses_id'  => $this->request->getVar('contract_statuses_id')
        ]);

        return redirect()->to(base_url('contract'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->ContractModel->delete($id);
        return redirect()->to(base_url('contract'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function search()
    {
        $division_id = resolveDivisionFilter($this->request->getVar('division_id'));
        $date_type = $this->request->getVar('date_type');
        $month = $this->request->getVar('month');
        $year = $this->request->getVar('year');
        $contract_statuses_id = $this->request->getVar('contract_statuses_id');
        $data = [
            'title'     => 'Contract',
            'divisions' => $this->DivisionModel->findAll(),
            'statuses' => $this->ContractStatusesModel->findAll(),
            'list_data' => $this->ContractModel->dataContractSearch($date_type, $month, $year, $contract_statuses_id, $division_id)
        ];

        return view('contract/index', $data);
    }

    public function employee($id)
    {
        $list_data = $this->ContractModel->ContractEmployeeID($id);
        $employee = $this->EmployeeModel->where(['id' => $id])->first();
        $data = [
            'title'     => 'Employee',
            'employee_id'        => $id,
            'list_data' => $list_data,
            'employee'  => $employee

        ];

        return view('contract/employee', $data);
    }

    public function add_employee($id)
    {
        $datetime = Time::parse('now');
        $newDate = $datetime->addYears(1);
        $newDates = explode(' ', $newDate);
        $end_date = $newDates[0];
        $data = [
            'title'     => 'Add Contract',
            'employee_id'        => $id,
            'employee'  => $this->EmployeeModel->where(['id' => $id])->first(),
            'end_date'  => $end_date
        ];

        return view('contract/add_employee', $data);
    }

    public function save_employee()
    {
        $employee_id = $this->request->getVar('employee_id');
        $checkContract = $this->ContractModel->checkContract($employee_id);
        if ($checkContract != null) {
            foreach ($checkContract as $row) {
                $this->ContractModel->save([
                    'id'    => $row->id,
                    'status'    => 'Non Active'
                ]);
            }
        }
        $this->ContractModel->save([
            'employee_id'      => $employee_id,
            'contract'      => $this->request->getVar('contract'),
            'start_date'      => $this->request->getVar('start_date'),
            'end_date'      => $this->request->getVar('end_date'),
            'status'        => 'Active'
        ]);

        return redirect()->to(base_url('contract/employee/' . $employee_id))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit_employee($id)
    {
        $data = [
            'title'     => 'edit Contract',
            'list_data' => $this->ContractModel->ContractEmployeeID($id)
        ];

        return view('contract/edit_employee', $data);
    }

    public function update_employee()
    {
        $id = $this->request->getVar('id');
        $employee_id = $this->request->getVar('employee_id');
        $this->ContractModel->save([
            'id'        => $id,
            'contract'  => $this->request->getVar('contract'),
            'start_date'  => $this->request->getVar('start_date'),
            'end_date'  => $this->request->getVar('end_date'),
            'status'  => $this->request->getVar('status'),
        ]);

        return redirect()->to(base_url('contract/employee/' . $employee_id))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete_employee($id, $employee_id)
    {
        $this->ContractModel->delete($id);
        return redirect()->to(base_url('contract/employee/' . $employee_id))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function print($id)
    {
        $contract = $this->ContractModel->ContractEmployeeID($id);
        $datetime = new Time('now');
        $dates = explode(' ', $datetime);
        $date = $dates[0];
        $tanggal = date('d-m-Y', strtotime($date));
        $name = strtoupper($contract[0]->name);
        $tanggal_terbilang = tanggal_terbilang($date);
        $jk = $contract[0]->gender;
        $usia = hitung_umur($contract[0]->date_of_birth);
        $address = $contract[0]->address . ' RT/RW ' . $contract[0]->rt . '/' . $contract[0]->rw;
        $villages = $contract[0]->villages;
        $districts = $contract[0]->districts;
        $regencies = $contract[0]->regencies;
        $start_date = format_tanggal_indo($contract[0]->start_date);
        $end_date = format_tanggal_indo($contract[0]->end_date);
        $position = $contract[0]->position;
        $division = $contract[0]->division;
        $salary = format_rupiah($contract[0]->salary);
        $hariini = format_tanggal_indo($date);



        $templateProcessor = new TemplateProcessor('template.docx');
        $templateProcessor->setValue('date', $tanggal);
        $templateProcessor->setValue('tanggal_terbilang', $tanggal_terbilang);
        $templateProcessor->setValue('name', $name);
        $templateProcessor->setValue('jk', $jk);
        $templateProcessor->setValue('usia', $usia);
        $templateProcessor->setValue('address', $address);
        $templateProcessor->setValue('villages', $villages);
        $templateProcessor->setValue('districts', $districts);
        $templateProcessor->setValue('regencies', $regencies);
        $templateProcessor->setValue('start_date', $start_date);
        $templateProcessor->setValue('end_date', $end_date);
        $templateProcessor->setValue('position', $position);
        $templateProcessor->setValue('division', $division);
        $templateProcessor->setValue('salary', $salary);
        $templateProcessor->setValue('hariini', $hariini);


        // 2. Simpan hasil ke temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $templateProcessor->saveAs($tempFile);

        $filename = 'PKWT_JOIN_' . $name . '_' . date('Y_m_d') . '.docx';

        // 3. Kirim file ke browser agar bisa didownload
        header("Content-Description: File Transfer");
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($tempFile));
        readfile($tempFile);

        // 4. Hapus file sementara
        unlink($tempFile);
        exit;
    }
}
