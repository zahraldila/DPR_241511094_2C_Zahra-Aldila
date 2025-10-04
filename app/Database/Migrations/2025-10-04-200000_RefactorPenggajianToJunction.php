<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorPenggajianToJunction extends Migration
{
    public function up()
    {
        // Hapus tabel lama jika ada (header/detail)
        if ($this->db->tableExists('penggajian_item')) {
            $this->forge->dropTable('penggajian_item', true);
        }
        if ($this->db->tableExists('penggajian')) {
            $this->forge->dropTable('penggajian', true);
        }

        // Buat tabel junction sederhana
        $this->forge->addField([
            'id_anggota'       => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'id_komponen_gaji' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
        ]);
        // kombinasi unik/PK → mencegah duplikat komponen utk anggota yang sama
        $this->forge->addKey(['id_anggota','id_komponen_gaji'], true); // composite primary
        $this->forge->createTable('penggajian', true);
    }

    public function down()
    {
        // Balikkan: hapus junction (tanpa mengembalikan header/detail)
        $this->forge->dropTable('penggajian', true);
    }
}
