<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'ticket';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $allowedFields = ['ticket_number', 'date', 'time', 'employee_id', 'title', 'description', 'solution', 'ticket_status_id', 'ticket_category_id', 'priority', 'attachment', 'closed_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function dataTicket($date, $ticket_category_id)
    {
        $builder = $this->db->table('ticket');
        $builder->select('*, data_employee.name as name, ticket.id as id, ticket.employee_id as employee_id, ticket.created_at, ticket.updated_at, ticket_status.name as ticket_status, ticket_category.name as ticket_category');
        $builder->join('data_employee', 'data_employee.id = ticket.employee_id');
        $builder->join('ticket_status', 'ticket_status.id = ticket.ticket_status_id');
        $builder->join('ticket_category', 'ticket_category.id = ticket.ticket_category_id');
        $builder->where('ticket.date', $date);
        if ($ticket_category_id != 0) {
            $builder->where('ticket_category_id', $ticket_category_id);
        }
        $builder->where('ticket.deleted_at', null);
        $query = $builder->get();
        return $query->getResultObject();
    }

    public function generateTicketNumber()
    {
        $today = date('Ymd'); // contoh: 20250624

        // Hitung tiket yang sudah ada di tanggal hari ini
        $count = $this->where('date', date('Y-m-d'))->countAllResults();

        // Nomor urut 1 + jumlah tiket hari ini
        $nextNumber = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "TCK-$today-$nextNumber";
    }
}
