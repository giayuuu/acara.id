<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
        {
            $data = [
        'full_name'   => 'Admin Utama',
        'gender'      => 'Laki-laki',
        'nip'         => '1122334455',
        'phone'       => '081234567891',
        'institution' => 'Pemerintah Kabupaten Malang',
        'position'    => 'staff',
        'email'       => 'admin@malangkab.go.id',
        'password'    => password_hash('Diskominfo@2025', PASSWORD_DEFAULT),
        'role'        => 'admin',
        'dinas'       => null,
        'is_approved' => 1
    ];
    $this->db->table('users')->insert($data);

    }
}
