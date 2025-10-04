<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJumlahAnakToAnggota extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // CEGAH DUPLIKAT: hanya tambah kalau kolom belum ada
        if (! $db->fieldExists('jumlah_anak', 'anggota')) {
            $this->forge->addColumn('anggota', [
                'jumlah_anak' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'status_pernikahan',
                ],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        // Hanya drop kalau memang ada
        if ($db->fieldExists('jumlah_anak', 'anggota')) {
            $this->forge->dropColumn('anggota', 'jumlah_anak');
        }
    }
}
