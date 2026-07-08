<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Myth\Auth\Models\UserModel;

class Account extends BaseController
{

    protected $db;
    public function index()
    {

        $data = [
            'title'     => 'Account Data',
            'list_data' => $this->UserModel->users_details()
        ];
        return view('account/index', $data);
    }

    public function edit($id)
    {
        $auth_groups = $this->UserModel->auth_groups();

        $data = [
            'title'         => 'Edit Account',
            'list_data'     => $this->UserModel->users_details($id),
            'division'      => $this->DivisionModel->findAll(),
            'auth_groups'    => $auth_groups,
            'validation'    => \Config\Services::validation()

        ];
        return view('account/edit', $data);
    }

    public function update($id)
    {
        $oldusername = $this->request->getVar('oldusername');
        $oldemail = $this->request->getVar('oldemail');
        $oldimage = $this->request->getVar('oldimage');
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $group_id = $this->request->getVar('group_id');
        $division_id = $this->request->getVar('division_id');

        $fileimage = $this->request->getFile('image');

        if (! $fileimage->isValid()) {
            $imagename = $oldimage;
        } else {
            $imagename = $fileimage->getRandomName();
            $fileimage->move('assets/images/users', $imagename);
        }

        if ($username == $oldusername) {
            $rule_username = 'required';
        } else {
            $rule_username = 'required|is_unique[users.username]';
        }

        if ($email == $oldemail) {
            $rule_email = 'required';
        } else {
            $rule_email = 'required|is_unique[users.email]';
        }

        if (!$this->validate([
            'username'      => $rule_username,
            'email'         => $rule_email,
        ])) {
            return redirect()->to('account/edit/' . $id)->withInput();
        }

        $data = [
            'username'  => $username,
            'division_id' => $division_id,
            'email'     => $email,
            'image'     => $imagename
        ];

        $data_groups = [
            'group_id'  => $group_id
        ];

        $this->UserModel->update_users($id, $data);
        $this->UserModel->update_auth_groups_users($id, $data_groups);

        return redirect()->to(base_url('account'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $data = [
            'deleted_at' => date('Y-m-d H:i:s') // atau DateTime::now()->format('Y-m-d H:i:s')
        ];
        $this->UserModel->update_users($id, $data);
        return redirect()->to(base_url('account'))->with('success', 'data <strong>deleted</strong> successfully');
    }
}
