<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = [
        'id',
        'full_name',
        'gender',
        'nip',
        'phone',
        'institution',
        'position',
        'email',
        'password',
        'role',
        'is_approved',
        'dinas'
    ];

    protected $useTimestamps = false; // Tambahkan ini untuk nonaktifkan created_at/updated_at

    public function getPendingAdmindinas()
    {
        return $this->where('role', 'admindinas')
            ->where('is_approved', 0)
            ->findAll();
    }

    public function getApprovedAdmindinas()
    {
        return $this->where('role', 'admindinas')
            ->where('is_approved', 1)
            ->findAll();
    }
}
