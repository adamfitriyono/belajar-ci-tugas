<?php 

namespace App\Models;

use CodeIgniter\Model;

class DiskonModel extends Model
{
    // Tentukan nama tabel yang akan digunakan
    protected $table = 'diskon';  
    protected $primaryKey = 'id';
    protected $useTimestamps = false;

    protected $allowedFields = ['nominal', 'tanggal', 'created_at'];
}