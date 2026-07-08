<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketStatusModel extends Model
{
    protected $table            = 'ticket_status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'slug', 'color', 'order', 'is_active'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
