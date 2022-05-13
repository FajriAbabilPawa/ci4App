<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mhs';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = [
        'nim_mhs',
        'nama_mhs',
        'TmpLahir_mhs',
        'TglLahir_mhs',
        'alamat_mhs',
        'hp_mhs',
        'jurusan_mhs',
    ];

    public function search($keyword)
    {
        if (true) {
            return $this->table('mahasiswa')->like('nama_mhs', $keyword)
                ->orLike('nim_mhs', $keyword)
                ->orLike('jurusan_mhs', $keyword)
                ->orLike('TmpLahir_mhs', $keyword)
                ->orLike('TglLahir_mhs', $keyword)
                ->orLike('alamat_mhs', $keyword)
                ->orLike('hp_mhs', $keyword);
        } else {
            return session()->setFlashdata('fail_search', 'Gagal mencari data mahasiswa');
        }
    }

    // autonumber buat nambah string berdasar kode jurusan dan angka auto increment
    public function autonumber($jurusan)
    {
        $query = $this->db->query("SELECT MAX(RIGHT(nim_mhs,4)) AS kode FROM mahasiswa");
        $kode = "";
        if ($query->getRowArray()) {
            foreach ($query->getResult() as $k) {
                $tmp = ((int) $k->kode) + 1;
                $kode = sprintf("%04s", $tmp);
            }
        } else {
            $kode = "0001";
        }

        if ($jurusan == 'sejarah') {
            return "MHS" . "SEJ" . $kode;
        } else if ($jurusan == 'mipa') {
            return "MHS" . "MIP" . $kode;
        } else if ($jurusan == 'sastra') {
            return "MHS" . "SAS" . $kode;
        } else {
            return "MHS" . "ERR" . $kode;
        }
    }

    // Ngambil nama jurusan
    public function getJurusan($id)
    {
        $query = $this->db->query("SELECT jurusan_mhs FROM mahasiswa WHERE id_mhs = '$id'");
        return $query->getRowArray();
        
    }

    // Ganti format kode nim berdasar jurusan
    public function changeFormat($nim, $jurusan)
    {
        $kode = substr($nim, 6, 4);
        if ($jurusan == 'sejarah') {
            $nim = substr_replace($nim, "SEJ", 3) . $kode;
        } elseif ($jurusan == 'mipa') {
            $nim = substr_replace($nim, "MIP", 3) . $kode;
        } elseif ($jurusan == 'sastra') {
            $nim = substr_replace($nim, "SAS", 3) . $kode;
        }

        return $nim;
    }
}
