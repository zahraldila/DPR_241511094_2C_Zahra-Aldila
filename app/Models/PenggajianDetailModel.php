<?php
namespace App\Models;

use CodeIgniter\Model;

class PenggajianDetailModel extends Model
{
    protected $table         = 'penggajian_detail';
    protected $primaryKey    = 'id_detail';
    protected $allowedFields = ['id_penggajian','id_komponen_gaji','nominal'];
    protected $useTimestamps = false;
}
