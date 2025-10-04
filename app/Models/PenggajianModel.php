<?php
namespace App\Models;

use CodeIgniter\Model;

class PenggajianModel extends Model
{
    protected $table            = 'penggajian';
    protected $primaryKey       = '';              // composite → kosong
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_anggota','id_komponen_gaji'];
    protected $returnType       = 'array';
}
