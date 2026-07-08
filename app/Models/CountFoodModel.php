<?php

namespace App\Models;

use CodeIgniter\Model;

class CountFoodModel extends Model
{
    protected $table            = 'count_food';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['date', 'employee_pin', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataCountFood($date)
    {
        $builder = $this->db->table('count_food');
        $builder->select('count_food.id as id, count_food.employee_pin as employee_pin, count_food.date as date, employee.name as name, employee.employee_id, division.name as division, plant.name as plant, employee_group.name as employee_group, status, count_food.created_at, count_food.updated_at');
        $builder->join('employee', 'employee.employee_pin = count_food.employee_pin', 'left');
        $builder->join('division', 'division.id = employee.division_id', 'left');
        $builder->join('plant', 'plant.id = employee.plant_id', 'left');
        $builder->join('employee_group', 'employee_group.id = employee.employee_group_id', 'left');
        $builder->where('date', $date);
        $query = $builder->get();
        return $query;
    }

    public function groupdataCountFood($date)
    {
        $builder = $this->db->table('count_food');
        $builder->select('status, count(status) as count_status');
        $builder->where('date', $date);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function searchdataCountFood($date, $status, $division_id)
    {
        $builder = $this->db->table('count_food');
        $builder->select('count_food.id as id, count_food.employee_pin as employee_pin, count_food.date as date, employee.name as name, employee.employee_id, division.name as division, plant.name as plant, employee_group.name as employee_group, status, count_food.created_at, count_food.updated_at');
        $builder->join('employee', 'employee.employee_pin = count_food.employee_pin', 'left');
        $builder->join('division', 'division.id = employee.division_id', 'left');
        $builder->join('plant', 'plant.id = employee.plant_id', 'left');
        $builder->join('employee_group', 'employee_group.id = employee.employee_group_id', 'left');
        $builder->where('date', $date);
        if ($status != null) {
            $builder->where('status', $status);
        }
        if ($division_id != null) {
            $builder->where('division_id', $division_id);
        }
        $query = $builder->get();
        return $query;
    }

    public function groupsearchdataCountFood($date, $status)
    {
        $builder = $this->db->table('count_food');
        $builder->select('status, count(status) as count_status');
        $builder->groupBy('status');
        $builder->where('date', $date);
        if ($status != null) {
            $builder->where('status', $status);
        }
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function checkCountFood($date, $employee_pin)
    {
        $builder = $this->db->table('count_food');
        $builder->where('date', $date);
        $builder->where('employee_pin', $employee_pin);
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function countFood($date, $status)
    {
        $builder = $this->db->table('count_food');
        $builder->where('date', $date);
        $builder->where('status', $status);
        return $builder->get()->getNumRows();
    }

    public function getDashboardCountByStatus($date)
    {
        return $this->db->table('count_food')
            ->select('status, COUNT(*) as count_status')
            ->where('date', $date)
            ->groupBy('status')
            ->get()
            ->getResultObject();
    }
}
