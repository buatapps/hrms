<?php

namespace App\Models;

use CodeIgniter\Model;

class WelcomeBoardModel extends Model
{
    protected $table            = 'welcome_board';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['guest_id', 'topic', 'start_date', 'end_date', 'start_time', 'end_time', 'active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function welcome_board_guest()
    {
        return $this->db->table('welcome_board_guest')->get()->getResultObject();
    }

    public function welcome_board_guest_first()
    {
        return $this->db->table('welcome_board_guest')->where('active', 1)->get();
    }

    public function member_guest($id)
    {
        return $this->db->table('welcome_guest')->where('welcome_board_id', $id)->get()->getResultObject();
    }

    public function save_welcome_guest($data)
    {
        $this->db->table('welcome_guest')->insert($data);
    }

    public function update_active($data)
    {
        $this->db->table('welcome_board')->update($data);
    }
}
