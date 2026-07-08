<?php

namespace App\Models;

use CodeIgniter\Model;

class ToolsModel extends Model
{
    protected $table = 'auth_keys';
    protected $primaryKey = 'id';
    protected $allowedFields = ['auth_key', 'label', 'is_active'];

    public function generateAndSave($date, $label = 'main_system')
    {
        // nonaktifkan semua dulu
        $this->where('is_active', 1)
            ->set(['is_active' => 0])
            ->update();

        $secret = getenv('app.auth_key');

        $signature = hash('sha256', $date . $secret);

        $payload = base64_encode(json_encode([
            'auth_date' => $date,
            'auth_signature' => $signature
        ]));

        return $this->insert([
            'auth_key' => $payload,
            'label' => $label,
            'is_active' => 1
        ]);
    }
}
