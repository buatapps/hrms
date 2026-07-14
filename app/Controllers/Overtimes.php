<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Overtimes extends BaseController
{

    public function index()
    {
        $startDate = $this->request->getGet('start_date')
            ?? date('Y-m-01');

        $endDate = $this->request->getGet('end_date')
            ?? date('Y-m-t');

        $builder = $this->OvertimesModel;

        $builder = $builder
            ->select('overtimes.*, division.name as division_name, employee.name as sub_leader_name, overtime_categories.name as category_name, employee_group.name as employee_group,overtime_approval.name as overtime_approval')
            ->join('division', 'division.id = overtimes.division_id', 'left')
            ->join('employee', 'employee.id = overtimes.sub_leader_id', 'left')
            ->join('employee_group', 'employee_group.id = overtimes.employee_group_id', 'left')
            ->join('overtime_categories', 'overtime_categories.id = overtimes.overtime_category_id', 'left')
            ->join('overtime_approval', 'overtime_approval.id = overtimes.current_approval_level', 'left')
            ->where('overtime_date >=', $startDate)
            ->where('overtime_date <=', $endDate)
            ->where('overtimes.deleted_at IS NULL', null, false)
            ->orderBy('overtime_date', 'DESC');

        if (in_groups('admin')) {
            $builder->where('overtimes.division_id', user()->division_id);
        }

        $data = [
            'title'       => 'Overtimes',
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'list_data'   => $builder->findAll()
        ];

        return view('overtimes/index', $data);
    }

    public function add()
    {

        if (in_groups('admin')) {
            $divisions = $this->DivisionModel
                ->where('id', user()->division_id)
                ->orderBy('name', 'ASC')
                ->findAll();
        } else {
            $divisions = $this->DivisionModel
                ->orderBy('name', 'ASC')
                ->findAll();
        }

        $data = [
            'title' => 'Add Overtime',

            // division
            'divisions' => $divisions,

            // overtime category
            'categories' => $this->OvertimeCategoriesModel
                ->orderBy('name', 'ASC')
                ->findAll(),

            // sub leader
            'sub_leaders' => $this->EmployeeModel
                ->where('position_id', 6)
                ->orderBy('name', 'ASC')
                ->findAll(),

            // employee list
            'employees' => $this->EmployeeModel
                ->whereIn('employee_status_id', [1, 2])
                ->orderBy('name', 'ASC')
                ->findAll(),

            //group
            'group' => $this->EmployeeGroupModel
                ->whereIn('id', [1, 2, 3])
                ->orderBy('name', 'ASC')
                ->findAll(),

            // default date
            'date' => date('Y-m-d')
        ];

        return view('overtimes/add', $data);
    }

    public function getEmployeesByDivision()
    {
        $divisionId = $this->request->getGet('division_id');

        $employees = $this->EmployeeModel
            ->where('division_id', $divisionId)
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->response->setJSON($employees);
    }

    public function getSubLeadersByDivision()
    {
        $divisionId = $this->request->getGet('division_id');

        $subLeaders = $this->EmployeeModel
            ->where('division_id', $divisionId)
            ->where('position_id', 6)
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->response->setJSON($subLeaders);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // ================= HEADER =================
        $header = [
            'overtime_date'      => $this->request->getPost('overtime_date'),
            'division_id'        => $this->request->getPost('division_id'),
            'sub_leader_id'      => $this->request->getPost('sub_leader_id') ?: null,
            'overtime_category_id' => $this->request->getPost('overtime_category_id'),
            'shift'              => $this->request->getPost('shift'),
            'employee_group_id'  => $this->request->getPost('employee_group_id'),
            'notes'              => $this->request->getPost('notes'),
            'status'             => 'progress',
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $this->OvertimesModel->insert($header);

        $overtimeId = $this->OvertimesModel->insertID();

        $overtimeNumber = 'OT-' . date('Y') . '-' . str_pad($overtimeId, 5, '0', STR_PAD_LEFT);

        $this->OvertimesModel->update($overtimeId, [
            'overtime_number' => $overtimeNumber
        ]);

        // ================= ITEMS =================
        $employees      = $this->request->getPost('employee_id');
        $startTimes     = $this->request->getPost('start_time');
        $endTimes       = $this->request->getPost('end_time');
        $durations      = $this->request->getPost('duration_hours');
        $descriptions   = $this->request->getPost('task_description');

        $items = [];

        for ($i = 0; $i < count($employees); $i++) {

            if (!$employees[$i]) continue;

            $items[] = [
                'overtime_id'     => $overtimeId,
                'employee_id'     => $employees[$i],
                'start_time'      => $startTimes[$i],
                'end_time'        => $endTimes[$i],
                'duration_hours'  => $durations[$i],
                'task_description' => $descriptions[$i],
            ];
        }

        if (!empty($items)) {
            $this->OvertimeItemsModel->insertBatch($items);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to save overtime');
        }

        return redirect()->to('/overtimes')->with('success', 'Overtime saved successfully');
    }

    public function details($id)
    {
        $data['title'] = "Overtimes Details";
        $data['overtime'] = $this->OvertimesModel
            ->select('overtimes.*, overtimes.id as overtimes_id, division.name as division_name, overtime_categories.name as overtime_categories_name, employee_group.name as employee_group, overtime_approval.name as overtime_approval')
            ->join('division', 'division.id = overtimes.division_id')
            ->join('employee_group', 'employee_group.id = overtimes.employee_group_id')
            ->join('overtime_approval', 'overtime_approval.id = overtimes.current_approval_level')
            ->join('overtime_categories', 'overtime_categories.id = overtimes.overtime_category_id')
            ->find($id);

        // $data['items'] = $this->OvertimeItemsModel
        //     ->select('overtime_items.*, overtime_items.id as overtime_items_id, employee.name')
        //     ->join('employee', 'employee.id = overtime_items.employee_id')
        //     ->where('overtime_id', $id)
        //     ->where('overtime_items.deleted_at IS NULL', null, false)
        //     ->findAll();

        $data['approval'] = $this->OvertimeApprovalModel->findAll();

        $data['items'] = $this->OvertimesModel->getOvertimeDetailsWithAttendance($id);

        return view('overtimes/details', $data);
    }

    public function search()
    {
        $startDate = $this->request->getGet('start_date')
            ?? date('Y-m-01');

        $endDate = $this->request->getGet('end_date')
            ?? date('Y-m-t');

        $builder = $this->OvertimesModel;

        $builder = $builder
            ->select('
            overtimes.*,
            division.name as division_name,
            employee.name as sub_leader_name,
            overtime_categories.name as category_name,
            employee_group.name as employee_group,
            overtime_approval.name as overtime_approval

        ')
            ->join('division', 'division.id = overtimes.division_id', 'left')
            ->join('employee', 'employee.id = overtimes.sub_leader_id', 'left')
            ->join('employee_group', 'employee_group.id = overtimes.employee_group_id', 'left')
            ->join('overtime_approval', 'overtime_approval.id = overtimes.current_approval_level', 'left')
            ->join('overtime_categories', 'overtime_categories.id = overtimes.overtime_category_id', 'left')
            ->where('overtime_date >=', $startDate)
            ->where('overtime_date <=', $endDate)
            ->orderBy('overtime_date', 'DESC');

        $data = [
            'title'       => 'Overtimes',
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'list_data'   => $builder->findAll()
        ];

        return view('overtimes/index', $data);
    }

    public function edit($id)
    {
        $data['title'] = "Overtimes Edit";
        $data['overtime'] = $this->OvertimesModel->find($id);

        if (in_groups('admin')) {
            $divisions = $this->DivisionModel
                ->where('id', user()->division_id)
                ->orderBy('name', 'ASC')
                ->findAll();
        } else {
            $divisions = $this->DivisionModel
                ->orderBy('name', 'ASC')
                ->findAll();
        }

        $data['divisions'] = $divisions;

        $data['categories'] = $this->OvertimeCategoriesModel->findAll();

        $data['sub_leaders'] = $this->EmployeeModel
            ->where('position_id', 6)
            ->findAll();

        $data['employees'] = $this->EmployeeModel
            ->whereIn('employee_status_id', [1, 2])
            ->findAll();

        //group
        $data['group'] = $this->EmployeeGroupModel
            ->whereIn('id', [1, 2, 3])
            ->orderBy('name', 'ASC')
            ->findAll();

        $data['items'] = $this->OvertimeItemsModel
            ->where('overtime_id', $id)
            ->where('overtime_items.deleted_at IS NULL', null, false)
            ->findAll();

        return view('overtimes/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // =====================
        // 1. UPDATE HEADER
        // =====================
        $header = [
            'overtime_date'        => $this->request->getPost('overtime_date'),
            'division_id'          => $this->request->getPost('division_id'),
            'sub_leader_id'        => $this->request->getPost('sub_leader_id') ?: null,
            'overtime_category_id' => $this->request->getPost('overtime_category_id'),
            'shift'                => $this->request->getPost('shift'),
            'employee_group_id'    => $this->request->getPost('employee_group_id'),
            'notes'                => $this->request->getPost('notes'),
        ];

        $this->OvertimesModel->update($id, $header);

        // =====================
        // 2. DELETE OLD ITEMS
        // =====================
        $this->OvertimeItemsModel
            ->where('overtime_id', $id)
            ->delete();

        // =====================
        // 3. INSERT NEW ITEMS
        // =====================
        $employees = $this->request->getPost('employee_id');

        $items = [];

        for ($i = 0; $i < count($employees); $i++) {

            // skip kalau kosong
            if (!$employees[$i]) continue;

            $start = $this->request->getPost('start_time')[$i];
            $end   = $this->request->getPost('end_time')[$i];

            $duration = $this->request->getPost('duration_hours')[$i];

            $items[] = [
                'overtime_id'      => $id,
                'employee_id'      => $employees[$i],
                'start_time'       => $start,
                'end_time'         => $end,
                'duration_hours'   => $duration,
                'task_description' => $this->request->getPost('task_description')[$i],
            ];
        }

        if (!empty($items)) {
            $this->OvertimeItemsModel->insertBatch($items);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Update failed');
        }

        return redirect()->to('/overtimes')->with('success', 'Updated successfully');
    }

    public function deleteItem()
    {
        $json = $this->request->getJSON();

        $itemId = $json->item_id ?? null;

        if (!$itemId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID not found'
            ]);
        }

        $this->OvertimeItemsModel->delete($itemId);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // =====================
        // 1. DELETE ITEMS DULU
        // =====================
        $this->OvertimeItemsModel
            ->where('overtime_id', $id)
            ->delete();

        // =====================
        // 2. DELETE HEADER
        // =====================
        $this->OvertimesModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Delete failed');
        }

        return redirect()->to('/overtimes')->with('success', 'Deleted successfully');
    }

    function approval()
    {
        $id = $this->request->getVar('overtimes_id');
        $new_approval_level = (int)$this->request->getVar('current_approval_level');

        // 1. Ambil data dari database untuk pembanding
        $overtime = $this->OvertimesModel->find($id);

        if (!$overtime) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // 2. Cek apakah level yang dikirim lebih kecil dari yang ada di database
        // Contoh: Di DB level 2, tapi user kirim level 1 (berarti mundur/bukan progres baru)
        if ($new_approval_level < (int)$overtime->current_approval_level) {
            return redirect()->back()->with('error', 'Gagal: Approval level tidak boleh lebih rendah dari status saat ini.');
        }

        // 3. Tentukan status final
        if ($new_approval_level >= 3) {
            $final_status = 'approved';
        } else {
            $final_status = 'progress';
        }

        $header = [
            'current_approval_level' => $new_approval_level,
            'final_status'           => $final_status
        ];

        // 4. Update data
        $this->OvertimesModel->update($id, $header);

        return redirect()->to('/overtimes/details/' . $id)->with('success', 'Update successfully');
    }

    public function notapproval($id, $overtime_items_id)
    {
        $header = [
            'not_approve'  => '1'
        ];

        $this->OvertimeItemsModel->update($overtime_items_id, $header);

        return redirect()->to('/overtimes/details/' . $id)->with('success', 'Update successfully');
    }

    public function cancelnotapproval($id, $overtime_items_id)
    {
        $header = [
            'not_approve'  => '0'
        ];

        $this->OvertimeItemsModel->update($overtime_items_id, $header);

        return redirect()->to('/overtimes/details/' . $id)->with('success', 'Update successfully');
    }

    public function sendMail($id)
    {
        $row = $this->OvertimesModel
            ->where('overtimes.id', $id)
            ->first();
        if (!$row) return redirect()->back()->with('error', 'Data tidak ditemukan');

        $targetGroupId = ($row->current_approval_level == '1') ? 7 : 8;
        $levelName = ($row->current_approval_level == '1') ? 'assisten-manager' : 'senior-manager';
        
        $db = \Config\Database::connect();
        $targetUsers = $db->table('users u')
        ->select('u.email, u.username')
        ->join('auth_groups_users agu', 'agu.user_id = u.id')
        ->where('u.division_id', $row->division_id) // Asumsi user punya kolom division_id
        ->where('agu.group_id', $targetGroupId)
        ->get()
        ->getResult();

        $emailService = \Config\Services::email();

        foreach ($targetUsers as $user) {
        $emailService->setTo($user->email);
        $emailService->setSubject('New Overtime Approval Request');

        // Template Email
        $message = "
            <h3>Halo, " . $user->username . "</h3>
            <p>Ada pengajuan lembur baru yang memerlukan persetujuan Anda.</p>
            <p>Silakan klik link di bawah ini untuk melihat detail pengajuan:</p>
            <p><a href='" . base_url('overtimes/details/' . $id) . "' style='padding: 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Lihat Detail Lembur</a></p>
            <br>
            <p>Terima kasih.</p>
        ";

        $emailService->setMessage($message);

        // Kirim email
        if ($emailService->send()) {
            // Berhasil
        } else {
            // Log error jika perlu
            $data = $emailService->printDebugger(['headers']);
        }
    }

        return redirect()->to('/overtimes')->with('success', 'Email berhasil dikirim ke ' . count($targetUsers) . ' ' . $levelName . '(s)');
    }

    public function print($id)
    {

        $data['overtime'] = $this->OvertimesModel
            ->select('overtimes.*, division.name as division_name, employee.name as sub_leader_name, employee_group.name as employee_group, overtime_categories.name as category_name   ')
            ->join('division', 'division.id = overtimes.division_id')
            ->join('employee', 'employee.id = overtimes.sub_leader_id', 'left')
            ->join('employee_group', 'employee_group.id = overtimes.employee_group_id', 'left')
            ->join('overtime_categories', 'overtime_categories.id = overtimes.overtime_category_id', 'left')
            ->find($id);

        $data['items'] = $this->OvertimeItemsModel
            ->select('overtime_items.*, employee.name, employee.employee_id, overtime_items.not_approve')
            ->join('employee', 'employee.id = overtime_items.employee_id')
            ->where('overtime_id', $id)
            ->where('not_approve', 0)
            ->where('overtime_items.deleted_at IS NULL', null, false)
            ->findAll();

            // echo "<pre>";
            // print_r($data['overtime']); exit;

        return view('overtimes/print', $data);
    }

    public function cancel($id)
    {
        $header = [
            'final_status'  => 'cancelled'
        ];

        $this->OvertimesModel->update($id, $header);

        return redirect()->to('/overtimes/details/' . $id)->with('success', 'Overtime cancelled successfully');
    }

public function testEmail()
{
    $email = \Config\Services::email();

        // Ganti dengan email tujuan uji coba kamu
        $to = 'alathiefpermana@gmail.com'; 
        
        $email->setTo($to);
        $email->setSubject('Testing Kirim Email CodeIgniter 4');
        $email->setMessage('<h1>Halo!</h1><p>Email ini dikirim otomatis menggunakan SMTP Gmail dari CodeIgniter 4 kamu.</p>');

        if ($email->send()) {
            echo "<h3>Hore! Email berhasil dikirim ke $to.</h3>";
        } else {
            echo "<h3>Yach, email gagal dikirim!</h3>";
            // Ini akan menampilkan log error untuk memudahkan debugging
            $data = $email->printDebugger(['headers', 'subject', 'body']);
            echo '<pre>' . print_r($data, true) . '</pre>';
        }
}

}



