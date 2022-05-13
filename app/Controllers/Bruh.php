<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMahasiswa;

class Bruh extends BaseController
{
    /*
    ! Semua hal disini dipakai hanya untuk uji coba
    ! Tolong jangan pake file ini untuk file lain
    */
    public function SimpanData()
    {
        if (isset($_POST['SimpanData'])) {
            $valid = $this->validate([
                'nim' => [
                    'label' => 'nim',
                    'rules' => 'required|numeric|max_length[7]|is_unique[mahasiswa.nim_mhs]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'numeric' => '{field} harus berupa angka',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 7 karakter',
                        'is_unique' => '{field} harus unik',
                    ]
                ],
                'nama' => [
                    'label' => 'nama',
                    'rules' => 'required|alpha_space|max_length[255]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'alpha_space' => '{field} hanya boleh berisi Huruf dan spasi',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 255 karakter'
                    ]
                ],
                'TmpLahir' => [
                    'label' => 'TmpLahir',
                    'rules' => 'required|alpha_space|max_length[255]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'alpha_space' => '{field} hanya boleh berisi Huruf dan spasi',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 255 karakter'
                    ]
                ],
                'TglLahir' => [
                    'label' => 'TglLahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi',
                    ]
                ],
                'alamat' => [
                    'label' => 'alamat',
                    'rules' => 'required|alpha_numeric_space|max_length[255]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'alpha_numeric_space' => '{field} hanya boleh berisi Huruf, angka, dan spasi',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 255 karakter'
                    ]
                ],
                'telepon' => [
                    'label' => 'telepon',
                    'rules' => 'required|numeric|max_length[13]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'numeric' => '{field} harus berupa angka',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 13 karakter'
                    ]
                ],
                'jurusan' => [
                    'label' => 'jurusan',
                    'rules' => 'required|alpha_space|max_length[255]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'alpha_space' => '{field} hanya boleh berisi Huruf dan spasi',
                        'max_length' => 'maksimum karakter untuk field {field} adalah 255 karakter'
                    ]
                ],
            ]);

            if (!$valid) {

                $mhs = new ModelMahasiswa();
                $data = [
                    'title' => 'Dashboard | Admin',
                    'tampil' => 'viewdatamahasiswa',
                    'TampilData' => $mhs->TampilData()->getResultArray(),
                    session()->setFlashdata('error', \Config\Services::validation()->listErrors()),
                ];
                echo view('layouts/wrapper', $data);
            } else {

                $mhs = new ModelMahasiswa();
                $data = [
                    'nim_mhs' => $this->request->getPost('nim'),
                    'nama_mhs' => $this->request->getPost('nama'),
                    'TmpLahir_mhs' => $this->request->getPost('TmpLahir'),
                    'TglLahir_mhs' => $this->request->getPost('TglLahir'),
                    'alamat_mhs' => $this->request->getPost('alamat'),
                    'hp_mhs' => $this->request->getPost('telepon'),
                    'jurusan_mhs' => $this->request->getPost('jurusan'),
                ];

                $simpan = $mhs->simpan($data);
                if ($simpan) {
                    session()->setFlashdata('message', 'Ditambahkan');
                    return redirect()->to('Mahasiswa');
                }
            }
        } else {
            return redirect()->to('Mahasiswa');
        }
    }

    public function UpdateData()
    {
        if (!$this->validate([
            'nim' => [
                'label' => 'nim',
                'rules' => 'required|numeric|max_length[7]|is_unique[mahasiswa.nim_mhs]',
                'errors' => [
                    'required' => 'NIM harus diisi',
                    'numeric' => 'NIM harus berupa angka',
                    'max_length' => 'maksimum karakter untuk field NIM adalah 7 karakter',
                    'is_unique' => 'NIM harus unik',
                ]
            ],
            'nama' => [
                'label' => 'nama',
                'rules' => 'required|alpha_space|max_length[255]',
                'errors' => [
                    'required' => 'Field Nama harus diisi',
                    'alpha_space' => 'Field Nama hanya boleh berisi Huruf dan spasi',
                    'max_length' => 'maksimum karakter untuk field Field Nama adalah 255 karakter'
                ]
            ],
            'TmpLahir' => [
                'label' => 'TmpLahir',
                'rules' => 'required|alpha_space|max_length[255]',
                'errors' => [
                    'required' => 'Field tempat lahir harus diisi',
                    'alpha_space' => 'Field tempat lahir hanya boleh berisi Huruf dan spasi',
                    'max_length' => 'maksimum karakter untuk field Field tempat lahir adalah 255 karakter'
                ]
            ],
            'TglLahir' => [
                'label' => 'TglLahir',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Lahir harus diisi',
                ]
            ],
            'alamat' => [
                'label' => 'alamat',
                'rules' => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required' => 'Alamat harus diisi',
                    'min_length' => 'minimum karakter untuk Alamat adalah 5 karakter',
                    'max_length' => 'maksimum karakter untuk field Alamat adalah 255 karakter'
                ]
            ],
            'telepon' => [
                'label' => 'telepon',
                'rules' => 'required|numeric|min_length[7]|max_length[13]',
                'errors' => [
                    'required' => 'No Telepon harus diisi',
                    'numeric' => 'No Telepon harus berupa angka',
                    'min_length' => 'minimum karakter untuk No Telepon adalah 7 karakter',
                    'max_length' => 'maksimum karakter untuk No Telepon adalah 13 karakter'
                ]
            ],
            'jurusan' => [
                'label' => 'jurusan',
                'rules' => 'required|alpha_space|max_length[255]',
                'errors' => [
                    'required' => 'Jurusan harus diisi',
                    'alpha_space' => 'Jurusan hanya boleh berisi Huruf dan spasi',
                    'max_length' => 'maksimum karakter untuk field Jurusan adalah 255 karakter'
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/mahasiswa')->withInput()->with('validation', $validation);
        } else {
            $id = $this->request->getPost('id');
            $data = [
                'nama_mhs' => $this->request->getPost('nama'),
                'TmpLahir_mhs' => $this->request->getPost('TmpLahir'),
                'TglLahir_mhs' => $this->request->getPost('TglLahir'),
                'alamat_mhs' => $this->request->getPost('alamat'),
                'hp_mhs' => $this->request->getPost('telepon'),
                'jurusan_mhs' => $this->request->getPost('jurusan'),
            ];

            $mhs = new ModelMahasiswa();

            $edit = $mhs->EditData($data, $id);

            if ($edit) {
                return redirect()->to('Mahasiswa');
            }
        }
    }
}
