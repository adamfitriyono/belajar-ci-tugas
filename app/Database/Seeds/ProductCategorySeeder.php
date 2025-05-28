<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        //membuat data
        $data = [
            [
                'nama_kategori' => 'Makanan',
                'deskripsi' => 'Kategori untuk semua jenis makanan',
                'gambar' => 'makanan.jpg',
                'dibuat_pada'     => '2025-05-06 10:00:00',
                'diperbarui_pada' => '2025-05-06 10:00:00',
            ],
            [
                'nama_kategori' => 'Minuman',
                'deskripsi' => 'Kategori untuk semua jenis minuman',
                'gambar' => 'minuman.jpg',
                'dibuat_pada' => '2025-05-06 10:05:00',
                'diperbarui_pada' => '2025-05-06 10:05:00',
            ],
            [
                'nama_kategori' => 'Aksesoris Laptop',
                'deskripsi' => 'Kategori untuk semua aksesoris laptop',
                'gambar' => 'mouse.jpg',
                'dibuat_pada' => '2025-05-06 10:10:00',
                'diperbarui_pada' => '2025-05-06 10:10:00',
            ],
            [
                'nama_kategori' => 'Aksesoris Mobil',
                'deskripsi' => 'Kategori untuk semua aksesoris mobil',
                'gambar' => 'velg.jpg',
                'dibuat_pada' => '2025-05-06 10:15:00',
                'diperbarui_pada' => '2025-05-06 10:15:00',
            ],
        ];

        $this->db->table('product_category')->insertBatch($data);
    }
}
