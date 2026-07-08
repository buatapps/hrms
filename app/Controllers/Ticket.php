<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Ticket extends BaseController
{
    public function index()
    {
        $date = date('Y-m-d');
        $ticket_category_id = 0;
        $data = [
            'title'     => 'Ticket',
            'list_data' => $this->TicketModel->dataTicket($date, $ticket_category_id),
            'date'      => $date,
            'category'  => $this->TicketCategoryModel->findAll(),
            'ticket_category_id' => $ticket_category_id,
        ];

        return view('ticket/index', $data);
    }

    public function search()
    {
        $date = $this->request->getPost('date');
        $ticket_category_id = $this->request->getPost('ticket_category_id');
        $data = [
            'title'     => 'Ticket',
            'list_data' => $this->TicketModel->dataTicket($date, $ticket_category_id),
            'date'      => $date,
            'category'  => $this->TicketCategoryModel->findAll(),
            'ticket_category_id' => $ticket_category_id,
        ];

        return view('ticket/index', $data);
    }

    public function add()
    {
        $date = date('Y-m-d');
        $data = [
            'title'     => 'Ticket Add',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'status'    => $this->TicketStatusModel->findAll(),
            'category'     => $this->TicketCategoryModel->findAll(),
            'date'      => $date
        ];

        return view('ticket/add', $data);
    }

    public function save()
    {
        // Generate ticket number dan waktu simpan
        $ticketNumber = $this->TicketModel->generateTicketNumber();
        $currentTime = date('H:i:s');

        $attachmentName = null;
        $attachment = $this->request->getFile('attachment');

        if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {
            $attachmentName = $attachment->getRandomName();
            $attachment->move('attachment', $attachmentName);
        }

        $this->TicketModel->save([
            'ticket_number' => $ticketNumber,
            'date'      => $this->request->getPost('date'),
            'time'      => $currentTime,
            'employee_id' => $this->request->getPost('employee_id'),
            'title' => $this->request->getPost('title'),
            'ticket_category_id' => $this->request->getPost('ticket_category_id'),
            'priority' => $this->request->getPost('priority'),
            'description' => $this->request->getPost('description'),
            'solution' => $this->request->getPost('solution'),
            'ticket_status_id' => 1,
            'attachment' => $attachmentName
        ]);

        return redirect()->to(base_url('ticket'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Ticket Add',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'status'    => $this->TicketStatusModel->findAll(),
            'category'     => $this->TicketCategoryModel->findAll(),
            'list_data' => $this->TicketModel->where(['id' => $id])->first(),
        ];

        return view('ticket/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        // Generate ticket number dan waktu simpan
        $ticketNumber = $this->TicketModel->generateTicketNumber();
        $currentTime = date('H:i:s');

        $attachmentName = null;
        $attachment = $this->request->getFile('attachment');

        if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {
            $attachmentName = $attachment->getRandomName();
            $attachment->move('attachment', $attachmentName);
        }

        $this->TicketModel->save([
            'id'        => $id,
            'date'      => $this->request->getPost('date'),
            'time'      => $currentTime,
            'employee_id' => $this->request->getPost('employee_id'),
            'title' => $this->request->getPost('title'),
            'ticket_category_id' => $this->request->getPost('ticket_category_id'),
            'priority' => $this->request->getPost('priority'),
            'description' => $this->request->getPost('description'),
            'solution' => $this->request->getPost('solution'),
            'ticket_status_id' => $this->request->getPost('ticket_status_id'),
            'attachment' => $attachmentName
        ]);

        return redirect()->to(base_url('ticket'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function delete($id)
    {
        $this->TicketModel->delete($id);
        return redirect()->to(base_url('ticket'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function closed($id)
    {
        $this->TicketModel->save([
            'id'        => $id,
            'ticket_status_id' => 5,
            'closed_at' => date('Y-m-d H:i:s')

        ]);

        return redirect()->to(base_url('ticket'))->with('success', 'data <strong>closed</strong> successfully');
    }
}
