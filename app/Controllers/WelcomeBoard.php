<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WelcomeBoard extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Welcome Board',
            'list_data' => $this->WelcomeBoardModel->welcome_board_guest()
        ];

        return view('welcome_board/index', $data);
    }

    public function add()
    {
        $guest = $this->GuestModel->orderBy('name', 'ASC')->findAll();
        $data = [
            'title'     => 'Add Welcome Board',
            'guest'     => $guest
        ];


        return view('welcome_board/add', $data);
    }

    public function save()
    {
        $guest_id = $this->request->getVar('guest_id');
        $topic = $this->request->getVar('topic');
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
        $start_time = $this->request->getVar('start_time');
        $end_time = $this->request->getVar('end_time');
        $member_guest = $this->request->getVar('member_guest');
        $member_information = $this->request->getVar('member_guest');

        $data = [
            'active'    => 0
        ];
        $this->WelcomeBoardModel->update_active($data);

        $this->WelcomeBoardModel->save([
            'guest_id'      => $guest_id,
            'topic'         => $topic,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'start_time'    => $start_time,
            'end_time'      => $end_time,
            'active'        => 1
        ]);

        $data_welcome_board = $this->WelcomeBoardModel->orderBy('id', 'DESC')->first();

        $welcome_board_id = $data_welcome_board->id;

        for ($i = 0; $i < count($member_guest); $i++) {
            if ($member_guest[$i] != null) {
                $data2 = [
                    'welcome_board_id'      => $welcome_board_id,
                    'member_guest'  => $member_guest[$i],
                    'member_information' => $member_information[$i]
                ];

                $this->WelcomeBoardModel->save_welcome_guest($data2);
            }
        }

        return redirect()->to(base_url('welcome_board'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function active($id)
    {
        $data = [
            'active'    => 0
        ];
        $this->WelcomeBoardModel->update_active($data);

        $this->WelcomeBoardModel->save([
            'id'        => $id,
            'active'    => 1
        ]);
        return redirect()->back();
    }

    public function non_active($id)
    {
        $this->WelcomeBoardModel->save([
            'id'        => $id,
            'active'    => 0
        ]);
        return redirect()->back();
    }

    public function view()
    {
        $wb = $this->WelcomeBoardModel->welcome_board_guest_first()->getResultObject();

        if (!$wb) {
            return redirect()->back()->with('success', 'data <strong>not showing</strong>');
        } else {
            $member = $this->WelcomeBoardModel->member_guest($wb[0]->id);
            $data = [
                'list_data'     => $wb,
                'member'        => $member
            ];
            // dd($wb);
            return view('welcome_board/view', $data);
        }
    }
}
