<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenggajian extends Migration
{
    public function up()
    {
        // header penggajian
        $this->forge->addField([
            'id_penggajian' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'id_anggota'    => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            // simpan periode sebagai YYYY-MM-01 (date) atau boleh NULL dulu
            'periode'       => ['type'=>'DATE','null'=>true],
            'created_at'    => ['type'=>'DATETIME','null'=>true],
            'updated_at'    => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id_penggajian', true);
        $this->forge->createTable('penggajian', true);

        // detail komponen penggajian
        $this->forge->addField([
            'id_item_penggajian' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'id_penggajian'      => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'id_komponen_gaji'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            // snapshot nilai & satuan dari komponen_gaji saat ditambahkan
            'nominal'            => ['type'=>'DECIMAL','constraint'=>'17,2','default'=>'0.00'],
            'satuan'             => ['type'=>'VARCHAR','constraint'=>30],
        ]);
        $this->forge->addKey('id_item_penggajian', true);
        $this->forge->addUniqueKey(['id_penggajian','id_komponen_gaji']); // cegah duplikat komponen di satu penggajian
        $this->forge->createTable('penggajian_item', true);
    }

    public function down()
    {
        $this->forge->dropTable('penggajian_item', true);
        $this->forge->dropTable('penggajian', true);
    }
}
