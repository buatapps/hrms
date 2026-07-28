<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractModel extends Model
{
    protected $table            = 'contract';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'contract_types_id', 'division_id', 'salary', 'contract_statuses_id', 'start_date', 'end_date'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataContract($division_id)
    {
        $builder = $this->db->table('contract');
        $builder->select('*, data_employee.name as name, contract.id as id, contract.employee_id as employee_id, data_employee.employee_id as nip, contract.created_at,contract.updated_at, contract_types.name as contract_types, contract_statuses.code as contract_statuses, division.name as division');
        $builder->join('data_employee', 'data_employee.id = contract.employee_id');
        $builder->join('contract_types', 'contract_types.id = contract.contract_types_id');
        $builder->join('contract_statuses', 'contract_statuses.id = contract.contract_statuses_id');
        $builder->join('division', 'division.id = contract.division_id');
        $builder->where('contract.deleted_at', null);
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $builder->orderBy('contract.id', 'DESC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function ContractEmployeeID($id)
    {
        $builder = $this->db->table('contract');
        $builder->select('*, contract.id as id, contract.employee_id as employee_id, employee.name as name, gender.name as gender, villages.name as villages, districts.name as districts,regencies.name as regencies, position.name as position, division.name as division');
        $builder->where('contract.id', $id);
        $builder->join('employee', 'employee.id = contract.employee_id');
        $builder->join('gender', 'gender.id = employee.gender_id');
        $builder->join('villages', 'villages.id = employee.villages_id', 'left');
        $builder->join('districts', 'districts.id = employee.districts_id', 'left');
        $builder->join('regencies', 'regencies.id = employee.regencies_id', 'left');
        $builder->join('position', 'position.id = employee.position_id');
        $builder->join('division', 'division.id = employee.division_id');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataContractSearch(
        $date_type,
        $month,
        $year,
        $contract_statuses_id = null,
        $division_id = null
    ) {
        $builder = $this->db->table('contract');
        $builder->select('*, data_employee.name as name, contract.id as id, contract.employee_id as employee_id, data_employee.employee_id as nip, contract.created_at,contract.updated_at, contract_types.name as contract_types, contract_statuses.code as contract_statuses, division.name as division');
        $builder->join('data_employee', 'data_employee.id = contract.employee_id');
        $builder->join('contract_types', 'contract_types.id = contract.contract_types_id');
        $builder->join('contract_statuses', 'contract_statuses.id = contract.contract_statuses_id');
        $builder->join('division', 'division.id = contract.division_id');

        // 🔐 whitelist kolom tanggal
        $allowedDateType = ['start_date', 'end_date'];
        $dateColumn = in_array($date_type, $allowedDateType)
            ? $date_type
            : 'start_date';

        // 📅 Filter month & year (index friendly)
        if ($month && $year) {
            $startDate = sprintf('%04d-%02d-01', $year, $month);
            $endDate   = date('Y-m-t', strtotime($startDate));

            $builder->where("$dateColumn >=", $startDate)
                ->where("$dateColumn <=", $endDate);
        }

        // 🏷 Status
        if (!empty($contract_statuses_id)) {
            $builder->where('contract_statuses_id', $contract_statuses_id);
        }

        // 🏢 Division
        if (!empty($division_id)) {
            $builder->where('division_id', $division_id);
        }

        // 🚫 soft delete
        $builder->where('contract.deleted_at', null);

        // 🔃 optional sorting
        $builder->orderBy($dateColumn, 'ASC');

        return $builder->get()->getResult();
    }

    public function everHasContractType($employeeId, $contractTypeId)
    {
        return $this->where('employee_id', $employeeId)
            ->where('contract_types_id', $contractTypeId)
            ->where('deleted_at', null)
            ->countAllResults() > 0;
    }

    public function hasActiveContract($employeeId)
    {
        return $this->where('employee_id', $employeeId)
            ->where('contract_statuses_id', 2) // active
            ->where('deleted_at', null)
            ->first();
    }

    public function everHasContractTypeInDivision($employee_id, $type_id, $division_id)
    {
        return $this->where('employee_id', $employee_id)
            ->where('contract_types_id', $type_id)
            ->where('division_id', $division_id)
            ->where('deleted_at', null)
            ->countAllResults() > 0;
    }

    public function getContractsByEmployee($employee_id)
    {
        $builder = $this->db->table('contract');
        $builder->select('contract.*, contract_types.name as contract_type_name, contract_statuses.code as status_name, contract_statuses.class as status_class, division.name as division_name');
        $builder->join('contract_types', 'contract_types.id = contract.contract_types_id');
        $builder->join('contract_statuses', 'contract_statuses.id = contract.contract_statuses_id');
        $builder->join('division', 'division.id = contract.division_id');
        $builder->where('contract.employee_id', $employee_id);
        $builder->where('contract.deleted_at', null);
        $builder->orderBy('contract.start_date', 'DESC');
        return $builder->get()->getResultObject();
    }

    // public function ContractEmployee($id)
    // {
    //     $builder = $this->db->table('contract');
    //     $builder->where('employee_id', $id);
    //     $builder->where('deleted_at', null);
    //     $builder->orderBy('id', 'DESC');
    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }

    // public function checkContract($employee_id)
    // {
    //     $builder = $this->db->table('contract');
    //     $builder->where('employee_id', $employee_id);
    //     $builder->where('status', 'Active');
    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }



    // public function ContractEmployeeID($id)
    // {
    //     $builder = $this->db->table('contract');
    //     $builder->select('*, contract.id as id, contract.employee_id as employee_id, employee.name as name, gender.name as gender, villages.name as villages, districts.name as districts,regencies.name as regencies, position.name as position, division.name as division');
    //     $builder->where('contract.id', $id);
    //     $builder->join('employee', 'employee.id = contract.employee_id');
    //     $builder->join('gender', 'gender.id = employee.gender_id');
    //     $builder->join('villages', 'villages.id = employee.villages_id', 'left');
    //     $builder->join('districts', 'districts.id = employee.districts_id', 'left');
    //     $builder->join('regencies', 'regencies.id = employee.regencies_id', 'left');
    //     $builder->join('position', 'position.id = employee.position_id');
    //     $builder->join('division', 'division.id = employee.division_id');
    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }

    // public function ContractExpired($date)
    // {
    //     $builder = $this->db->table('contract');
    //     $builder->select('*, contract.id as id, contract.employee_id as employee_id');
    //     $builder->join('data_employee', 'data_employee.id = contract.employee_id');
    //     $builder->where('status', 'Active');
    //     $builder->where('end_date <=', $date);
    //     $builder->where('contract.deleted_at', null);
    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }
}
