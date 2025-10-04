<?php
namespace App\Models;

use CodeIgniter\Model;

class KomponenModel extends Model
{
    protected $table      = 'komponen_gaji';          // ← ganti
    protected $primaryKey = 'id_komponen_gaji';       // ← ganti

    protected $allowedFields = [
        'nama_komponen', 'kategori', 'jabatan', 'nominal', 'satuan'
    ];

    // Tabel kamu tidak punya created_at/updated_at → jangan aktifkan timestamps
    protected $useTimestamps = false;                 // ← ganti
}
