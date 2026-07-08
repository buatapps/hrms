<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $db;
    protected $table = 'users_details';
    protected $primaryKey = 'id';
    protected $useSoftDeletes   = true;
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function users_details($id = false)
    {
        if ($id == false) {
            // return $this->db->table('users_detail')->get()->getResultObject();
            return $this->findAll();
        } else {
            return $this->where(['id' => $id])->first();
            // return $this->db->table('users_detail')->where('id', $id, null)->get()->getResultObject();
        }
    }

    public function auth_groups()
    {
        return $this->db->table('auth_groups')->get()->getResultObject();
    }

    public function update_users($id, $data)
    {
        $this->db->table('users')->where('id', $id)->set($data)->update();
    }

    public function update_auth_groups_users($id, $data_groups)
    {
        $this->db->table('auth_groups_users')->where('user_id', $id)->set($data_groups)->update();
    }
}
