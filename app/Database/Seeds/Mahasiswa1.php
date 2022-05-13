<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Mahasiswa extends Seeder
{
    public function run()
    {
        // membuat data untuk table mahasiswa
        $mahasiswa_data = [
            [
                'nim_mhs' => '1',
                'nama_mhs' => 'RIZAL ANDITAMA',
                'TmpLahir_mhs'  => 'WONOSOBO',
                'TglLahir_mhs' => 2020 - 02 - 21,
                'alamat_mhs'  => 'JALAN',
                'hp_mhs'  => '083807787971',
                'jurusan_mhs'  => 'DEFAULT'
            ],
            [
                'nim_mhs' => '01234567890',
                'nama_mhs' => 'GOTTA TEST',
                'TmpLahir_mhs'  => 'BANTEN',
                'TglLahir_mhs' => 2020 - 02 - 21,
                'alamat_mhs'  => 'JALAN',
                'hp_mhs'  => '01923012998',
                'jurusan_mhs'  => 'intro'
            ],
            [
                'nim_mhs' => '11111111111',
                'nama_mhs' => 'EXTRA FLY',
                'TmpLahir_mhs'  => 'JALAN',
                'TglLahir_mhs' => 2020 - 02 - 21,
                'alamat_mhs'  => 'JALAN',
                'hp_mhs'  => '902390193',
                'jurusan_mhs'  => 'intro'
            ]
        ];

        foreach ($mahasiswa_data as $data) {
            // insert semua data ke tabel
            $this->db->table('mahasiswa')->insert($data);
        }
    }
}
