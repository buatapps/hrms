<?php

namespace App\Models;

use CodeIgniter\Model;

class StnkModel extends Model
{
    protected $table            = 'stnk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'nama_stnk', 'kendaraan', 'nomor_plat', 'brand', 'tipe_kendaraan', 'masa_berlaku_pajak', 'masa_berlaku_plat', 'file_stnk', 'file_stnk_pajak', 'foto_tampak_depan', 'foto_tampak_samping', 'foto_tampak_belakang'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataStnk()
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->orderBy('stnk.id', 'DESC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataStikerKendaraan($division_id)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        if ($division_id != 0) {
            $builder->where('division_id', $division_id);
        }
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->orderBy('stnk.id', 'DESC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataStnkArray($division_id)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $this->addSimMasaBerlaku($builder);
        if ($division_id != 0) {
            $builder->where('division_id', $division_id);
        }
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->orderBy('stnk.id', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function stnkEmployee($id)
    {
        $builder = $this->db->table('stnk');
        $builder->where('employee_id', $id);
        $builder->where('stnk.deleted_at', null);
        $builder->orderBy('stnk.id', 'DESC');
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataStnkwhere($id)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $this->addSimMasaBerlaku($builder);
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->where('stnk.id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function dataStnkwherein($id)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $this->addSimMasaBerlaku($builder);
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->whereIn('stnk.id', $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    protected function addSimMasaBerlaku($builder)
    {
        $simSub = $this->db->table('sim')
            ->select('masa_berlaku')
            ->where('sim.employee_id = data_employee.id')
            ->where('sim.deleted_at', null)
            ->orderBy('masa_berlaku', 'ASC')
            ->limit(1);
        $builder->selectSubquery($simSub, 'sim_masa_berlaku');

        return $builder;
    }

    public function dataPajakExpired($date)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->where('masa_berlaku_pajak <=', $date);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataPlatExpired($date)
    {
        $builder = $this->db->table('stnk');
        $builder->select('*, stnk.id as id');
        $builder->join('data_employee', 'data_employee.id = stnk.employee_id');
        $builder->where('employee_status_id !=', 3);
        $builder->where('stnk.deleted_at', null);
        $builder->where('masa_berlaku_plat <=', $date);
        $query = $builder->get();
        return $query->getResultObject();
    }
}
