<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use App\Models\ModelMahasiswa;

class Mahasiswa extends Seeder
{
    public function run()
    {
        $this->mhs = new ModelMahasiswa();
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $jurusan = ($faker->randomElements(['sejarah', 'mipa', 'sastra']));
            $data = [
                'nim_mhs' => $this->mhs->autonumber($jurusan),
                'nama_mhs' => $faker->firstName . ' ' . $faker->lastName,
                'TmpLahir_mhs' => $faker->city,
                'TglLahir_mhs' => $faker->dateTimeBetween('-30 years', '-20 years')->format('Y-m-d'),
                'alamat_mhs' => $faker->address,
                'hp_mhs' => $faker->e164PhoneNumber,
                'jurusan_mhs' => $jurusan,
            ];

            $this->db->table('mahasiswa')->insert($data);
        }
    }
}
