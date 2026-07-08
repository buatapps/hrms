<?php

namespace App\Models;

use CodeIgniter\Model;

class SimModel extends Model
{
    protected $table            = 'sim';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['employee_id', 'tipe_sim', 'masa_berlaku', 'file_sim'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataSim()
    {
        $builder = $this->db->table('sim');
        $builder->select('*, sim.id as id');
        $builder->join('data_employee', 'data_employee.id = sim.employee_id');
        $builder->where('sim.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function simEmployee($id)
    {
        $builder = $this->db->table('sim');
        $builder->where('employee_id', $id);
        $builder->where('sim.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function dataExpired($date)
    {
        $builder = $this->db->table('sim');
        $builder->select('*, sim.id as id');
        $builder->join('data_employee', 'data_employee.id = sim.employee_id');
        $builder->where('sim.deleted_at', null);
        $builder->where('masa_berlaku <=', $date);
        $query = $builder->get();
        return $query->getResultObject();
    }
}
