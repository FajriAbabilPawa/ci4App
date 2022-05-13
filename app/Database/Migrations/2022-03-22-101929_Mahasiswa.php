<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel mahasiswa
        $this->forge->addField([
            'id_mhs'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nim_mhs'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'nama_mhs'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'TmpLahir_mhs'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'TglLahir_mhs'      => [
                'type'           => 'DATE',
            ],
            'alamat_mhs' => [
                'type'           => 'TEXT',
            ],
            'hp_mhs'      => [
                'type'           => 'CHAR',
                'constraint'     => 15,
            ],
            'jurusan_mhs'      => [
                'type'           => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at'       => [
                'type'           => 'DATETIME',   
                'null'           => true,   
            ],
            'updated_at'       => [
                'type'           => 'DATETIME',   
                'null'           => true,   
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id_mhs', TRUE);

        // Membuat tabel mahasiswa
        $this->forge->createTable('mahasiswa', TRUE);
    }

    public function down()
    {
        // menghapus tabel mahasiswa
        $this->forge->dropTable('mahasiswa');
    }
}
