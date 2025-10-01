<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJumlahAnakToAnggota extends Migration
{
    public function up()
    {
        $fields = [
            'jumlah_anak' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'status_pernikahan'
            ],
        ];
        $this->forge->addColumn('anggota', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'jumlah_anak');
    }
}
