<?php
namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table      = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    protected $allowedFields = [
        'username','password','email',
        'nama_depan','nama_belakang','role'
    ];

    protected $useTimestamps = false;
}
