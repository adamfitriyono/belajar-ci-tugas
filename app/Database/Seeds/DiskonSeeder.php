<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        // 
        $data = [
            [
                'tanggal'    => '2025-07-03',
                'nominal'    => 100000,
                'created_at' => '2025-07-03 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-04',
                'nominal'    => 200000,
                'created_at' => '2025-07-04 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-05',
                'nominal'    => 300000,
                'created_at' => '2025-07-05 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-06',
                'nominal'    => 100000,
                'created_at' => '2025-07-06 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-07',
                'nominal'    => 300000,
                'created_at' => '2025-07-07 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-08',
                'nominal'    => 100000,
                'created_at' => '2025-07-08 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-09',
                'nominal'    => 200000,
                'created_at' => '2025-07-09 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-10',
                'nominal'    => 200000,
                'created_at' => '2025-07-10 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-11',
                'nominal'    => 300000,
                'created_at' => '2025-07-11 12:30:21',
            ],
            [
                'tanggal'    => '2025-07-12',
                'nominal'    => 100000,
                'created_at' => '2025-07-12 12:30:21',
            ],
        ];

        // insert data ke dalam tabel diskon
        $this->db->table('diskon')->insertBatch($data);
    }
}
