<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsentModel extends Model
{
    protected $table            = 'absent';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['employee_id', 'employee_pin', 'date', 'end_date', 'absent_type_id', 'information'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function Absent($date, $division_id)
    {
        $builder = $this->db->table('absent');
        $builder->select('*,absent.id as id, data_employee.name as name, absent_type.name as absent_type, absent.created_at, absent.updated_at');
        $builder->join('data_employee', 'data_employee.id = absent.employee_id');
        $builder->join('absent_type', 'absent_type.id = absent.absent_type_id');
        $builder->where("'$date' BETWEEN `date` AND `end_date`");
        // Hanya ambil karyawan yang aktif (status ID bukan 3 = non-aktif)
        $builder->where('data_employee.employee_status_id !=', 3);
        if (!empty($division_id)) {
            $builder->where('division_id', $division_id);
        }
        $builder->where('absent.deleted_at', null);
        $builder->orderBy('absent.id', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
}
