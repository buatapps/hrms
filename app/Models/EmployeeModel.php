<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table            = 'employee';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['company_id', 'name', 'employee_id', 'employee_pin', 'division_id', 'section_id', 'position_id', 'plant_id', 'employee_group_id', 'education_id', 'product_synchronization', 'date_of_entry', 'resign_date', 'employee_status_id', 'working_days', 'gender_id', 'place_of_birth', 'date_of_birth', 'address', 'address_identity', 'rt', 'rw', 'villages_id', 'districts_id', 'regencies_id', 'provinces_id', 'phone_number', 'email', 'identity_number', 'identity_family_number', 'religion', 'marriage_status_id', 'mothers_name', 'number_of_children', 'bank_id', 'account_number', 'salary', 'npwp_number', 'tax_status_id', 'ketenagakerjaan_number', 'kesehatan_number', 'clinic_provider', 'hospital_provider', 'insurance_employee', 'insurance_couple', 'insurance_children', 'blood_type', 'uniform_size', 'shoes_size', 'emergency_name', 'emergency_relathionship', 'emergency_contact', 'couple', 'couple_date_of_birth', 'child_1', 'child_1_birthday', 'child_1_gender', 'child_2_birthday', 'child_2', 'child_2_gender', 'child_3', 'child_3_birthday', 'child_3_gender', 'picture', 'ktp', 'kk'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function employeeDetails($id = false)
    {
        if ($id == false) {
            return $this->db->table('employee_details')->get()->getResultObject();
        } else {
            return $this->db->table('employee_details')->where('id', $id)->get()->getRowArray();
        }
    }

    public function dataEmployeeIndex($division_id = null)
    {
        $builder = $this->db->table('data_employee e');

        $builder->select('
        e.*,
        c.contract_types_id AS latest_contract_type_id,
        ct.name AS latest_contract_types_name
    ');

        // Filter employee aktif
        $builder->where('e.employee_status_id !=', 3);

        // Filter divisi jika ada
        if ($division_id !== null) {
            $builder->where('e.division_id', $division_id);
        }

        // SUBQUERY: kontrak aktif TERAKHIR
        $subQuery = $this->db->table('contract c1')
            ->select('
            c1.id,
            c1.employee_id,
            c1.contract_types_id
        ')
            ->join(
                '(SELECT employee_id, MAX(end_date) AS max_end
              FROM contract
              WHERE contract_statuses_id = 2
                AND deleted_at IS NULL
              GROUP BY employee_id
            ) c2',
                'c1.employee_id = c2.employee_id AND c1.end_date = c2.max_end',
                'inner'
            )
            ->where('c1.contract_statuses_id', 2)
            ->where('c1.deleted_at', null);

        // Join kontrak terakhir
        $builder->join(
            '(' . $subQuery->getCompiledSelect() . ') c',
            'e.id = c.employee_id',
            'left'
        );

        // Join master contract type
        $builder->join(
            'contract_types ct',
            'ct.id = c.contract_types_id',
            'left'
        );

        $query = $builder->get();
        return $query->getResultObject();
    }

    // public function employeeDetailsSearch($gender_id = null, $employee_status_id = null, $plant_id = null, $employee_group_id = null, $division_id = null, $company_id = null)
    // {
    //     $builder = $this->db->table('data_employee e');

    //     //     // Filter optional
    //     if ($employee_status_id != null) {
    //         $builder->where('e.employee_status_id', $employee_status_id);
    //     } else {
    //         $builder->where('e.employee_status_id !=', 3); // exclude resigned
    //     }
    //     if ($gender_id != null) {
    //         $builder->where('e.gender_id', $gender_id);
    //     }
    //     if ($plant_id != null) {
    //         $builder->where('e.plant_id', $plant_id);
    //     }
    //     if ($employee_group_id != null) {
    //         $builder->where('e.employee_group_id', $employee_group_id);
    //     }
    //     if ($division_id != null) {
    //         $builder->where('e.division_id', $division_id);
    //     }
    //     if ($company_id != null) {
    //         $builder->where('e.company_id', $company_id);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }

    public function employeeDetailsSearch($gender_id = null, $employee_status_id = null, $plant_id = null, $employee_group_id = null, $division_id = null, $company_id = null)
    {
        $builder = $this->db->table('data_employee e');
        $builder->select('
        e.*, c.contract_types_id AS latest_contract_type_id, ct.name AS latest_contract_types_name');

        // Filter employee_status
        if ($employee_status_id != null) {
            $builder->where('e.employee_status_id', $employee_status_id);
        } else {
            $builder->where('e.employee_status_id !=', 3); // exclude resigned
        }

        // Filter optional
        if ($gender_id != null) {
            $builder->where('e.gender_id', $gender_id);
        }
        if ($plant_id != null) {
            $builder->where('e.plant_id', $plant_id);
        }
        if ($employee_group_id != null) {
            $builder->where('e.employee_group_id', $employee_group_id);
        }
        if ($division_id != null) {
            $builder->where('e.division_id', $division_id);
        }
        if ($company_id != null) {
            $builder->where('e.company_id', $company_id);
        }

        // SUBQUERY: kontrak aktif TERAKHIR
        $subQuery = $this->db->table('contract c1')
            ->select(' c1.id,
            c1.employee_id,
            c1.contract_types_id
        ')
            ->join(
                '(SELECT employee_id, MAX(end_date) AS max_end
              FROM contract
              WHERE contract_statuses_id = 2
                AND deleted_at IS NULL
              GROUP BY employee_id
            ) c2',
                'c1.employee_id = c2.employee_id AND c1.end_date = c2.max_end',
                'inner'
            )
            ->where('c1.contract_statuses_id', 2)
            ->where('c1.deleted_at', null);

        // Join kontrak terakhir
        $builder->join(
            '(' . $subQuery->getCompiledSelect() . ') c',
            'e.id = c.employee_id',
            'left'
        );

        // Join master contract type
        $builder->join(
            'contract_types ct',
            'ct.id = c.contract_types_id',
            'left'
        );

        $query = $builder->get();
        return $query->getResultObject();
    }



    // public function dataEmployee($division_id)
    // {

    //     $subQuery = $this->db->table('contract c1')
    //         ->select('c1.employee_id, c1.contract')
    //         ->join('(SELECT employee_id, MAX(end_date) AS max_end 
    //             FROM contract 
    //             WHERE status = "Active" AND deleted_at IS NULL
    //             GROUP BY employee_id
    //            ) c2', 'c1.employee_id = c2.employee_id AND c1.end_date = c2.max_end')
    //         ->where('c1.status', 'Active')
    //         ->where('c1.deleted_at', null);


    //     $builder = $this->db->table('data_employee e');
    //     $builder->select('e.*, c.contract AS latest_contract');
    //     $builder->where('e.employee_status_id !=', 3);
    //     if ($division_id != null) {
    //         $builder->where('division_id', $division_id);
    //     }
    //     $builder->join("({$subQuery->getCompiledSelect()}) c", 'e.id = c.employee_id', 'left');
    //     $query = $builder->get();
    //     return $query->getResultObject();
    // }

    public function dataEmployeeFilter($plant_id, $employee_group_id, $division_id)
    {
        $builder = $this->db->table('data_employee');
        $builder->select('*');
        if (!empty($plant_id) && $plant_id != 0) {
            $builder->where('plant_id', $plant_id);
        }
        if (!empty($employee_group_id) && $employee_group_id != 0) {
            $builder->where('employee_group_id', $employee_group_id);
        }
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $builder->where('employee_status_id !=', 3);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataEmployeeFilter2($employee_id, $division_id)
    {
        $builder = $this->db->table('data_employee');
        $builder->select('*');
        $builder->where('id', $employee_id);
        if (!empty($division_id)) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataEmployeeArray($id = false)
    {
        $builder = $this->db->table('data_employee');
        $builder->select('*');
        if ($id != false) {
            $builder->where('id', $id);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }






    public function employeeExport($gender_id, $employee_status_id, $division_id, $company_id)
    {
        $builder = $this->db->table('employee_details');
        $builder->select('*');
        if ($gender_id != null) {
            $builder->where('gender_id', $gender_id);
        }
        if ($employee_status_id != null) {
            $builder->where('employee_status_id', $employee_status_id);
        }
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        if ($company_id != null) {
            $builder->where('company_id', $company_id);
        }
        $query = $builder->get();
        // echo $this->db->getLastQuery();
        return $query->getResultObject();
    }

    public function checkWorkingDays($shift_id, $day)
    {
        $builder = $this->db->table('working_days');
        $builder->where('shift_id', $shift_id);
        $builder->where('day', $day);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function checkSchedule($employee_pin, $date)
    {
        $builder = $this->db->table('employee_schedule');
        $builder->where('employee_pin', $employee_pin);
        $builder->where('date', $date);
        $query = $builder->get()->getRow();
        return $query;
    }

    public function getEmployeeSchedule($plant_id, $employee_group_id, $division_id)
    {
        $builder = $this->db->table('employee');
        if ($plant_id != null) {
            $builder->where('plant_id', $plant_id);
        }
        if ($employee_group_id != null) {
            $builder->where('employee_group_id', $employee_group_id);
        }
        $builder->where('employee_status_id !=', 3);
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataCutiEmployee($id)
    {
        $builder = $this->db->table('absent');
        $builder->where('employee_id', $id);
        $builder->where('absent_type_id', 16); //cuti
        $builder->orderBy('date', 'ASC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function getEmployeeDivision($division_id)
    {
        $builder = $this->db->table('data_employee');
        $builder->where('division_id', $division_id);
        $builder->where('employee_status_id !=', 3);
        $builder->orderBy('employee_group_id', 'ASC');
        $builder->orderBy('plant_id', 'ASC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function getAbsentHistory($employeeId, $start, $end, $type = 'all')
    {
        $builder = $this->db->table('absent a')
            ->select('a.date, t.name as type_name')
            ->join('absent_type t', 't.id = a.absent_type_id')
            ->where('a.employee_id', $employeeId)
            ->where('a.date >=', $start)
            ->where('a.date <=', $end)
            ->where('a.deleted_at', null);

        if ($type !== 'all') {
            $builder->where('a.absent_type_id', $type);
        }

        return $builder
            ->orderBy('a.date', 'ASC')
            ->get()
            ->getResultArray();
    }
}
