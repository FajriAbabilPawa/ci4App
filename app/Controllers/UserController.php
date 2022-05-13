<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function login()
    {
        $data = [
            'title' => 'Login',
            'tampil' => 'login',

            'username' => '',
            'name' => '',
            'phone_no' => '',
            'email' => '',
            'password' => '',
        ];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                // 'username' => 'required|min_length[3]|max_length[50]',
                // 'name' => 'required|alpha_numeric_space|min_length[2]|max_length[255]',
                // 'phone' => 'required|numeric|min_length[7]|max_length[15]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'email' => [
                    'required' => 'Field Email harus diisi',
                    'valid_email' => 'Email harus valid "(Memakai @ dan .com)"',
                    'min_length' => 'Minimum karakter untuk Field Email adalah 3 karakter',
                    'max_length' => 'Maksimum karakter untuk Field Email adalah 50 karakter'
                ],
                'password' => [
                    'required' => 'Field password harus diisi',
                    'validateUser' => 'Email atau password tidak cocok',
                    'min_length' => 'Minimum karakter untuk Field password adalah 8 karakter',
                    'max_length' => 'Maksimum karakter untuk Field password adalah 255 karakter'
                ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data = [
                    'validation' => $this->validator,
                    'tampil' => 'login',
                    'title' => 'Login',
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                ];

                return view('pages/login', $data);
            } else {
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();

                // Storing session values
                $this->setUserSession($user);

                // Redirecting to dashboard after login
                if ($user['role'] == "admin") {
                    return redirect()->to(base_url('admin'));
                } elseif ($user['role'] == "member") {
                    return redirect()->to(base_url('member'));
                }
            }
        }
        return view('pages/login', $data);
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'phone_no' => $user['phone_no'],
            'email' => $user['email'],
            'password' => $this->request->getPost('password'),
            'isLoggedIn' => true,
            'role' => $user['role'],
        ];

        session()->set($data);
        return true;
    }

    public function register()
    {
        $data = [
            'title' => 'Register',
            'tampil' => 'register',

            'username' => '',
            'name' => '',
            'phone_no' => '',
            'email' => '',
            'password' => '',
            'password_confirm' => '',
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[users.username]|alpha_numeric|min_length[3]|max_length[50]',
                    'errors' => [
                        'required' => 'Field Username harus diisi',
                        'is_unique' => 'Username sudah dipakai',
                        'alpha_numeric' => 'Field Username hanya boleh berisi huruf dan angka',
                        'min_length' => 'Minimum karakter untuk Field Username adalah 3 karakter',
                        'max_length' => 'Maksimum karakter untuk Field Username adalah 50 karakter'
                    ]
                ],
                'name' => [
                    'label' => 'name',
                    'rules' => 'required|alpha_space|max_length[255]',
                    'errors' => [
                        'required' => 'Field Nama harus diisi',
                        'alpha_space' => 'Field Nama hanya boleh berisi Huruf dan spasi',
                        'max_length' => 'Maksimum karakter untuk Field Nama adalah 255 karakter'
                    ]
                ],
                'phone_no' => [
                    'label' => 'Phone Number',
                    'rules' => 'required|numeric|min_length[7]|max_length[15]',
                    'errors' => [
                        'required' => 'Field Phone No harus diisi',
                        'numeric' => 'Field Phone No hanya boleh berisi angka',
                        'min_length' => 'Maksimum digit untuk Field Phone No adalah 7 karakter',
                        'max_length' => 'Maksimum digit untuk Field Phone No adalah 15 karakter'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Field Email harus diisi',
                        'is_unique' => 'Email sudah dipakai',
                        'valid_email' => 'Email harus valid "(Memakai @ dan .com)"',
                        'min_length' => 'Minimum karakter untuk Field Email adalah 3 karakter',
                        'max_length' => 'Maksimum karakter untuk Field Email adalah 50 karakter'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'Field password harus diisi',
                        'min_length' => 'Minimum karakter untuk Field password adalah 8 karakter',
                        'max_length' => 'Maksimum karakter untuk Field password adalah 255 karakter'
                    ]
                ],
                'password_confirm' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Password harus di konfirmasi',
                        'matches' => 'Password konfirmasi harus sama',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $data = [
                    'validation' => $this->validator,
                    'tampil' => 'register',
                    'title' => 'Register',
                    'username' => $this->request->getVar('username'),
                    'name' => $this->request->getVar('name'),
                    'phone_no' => $this->request->getVar('phone_no'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'password_confirm' => $this->request->getVar('password_confirm'),
                ];

                return view('pages/register', $data);
            } else {
                $model = new UserModel();

                $newData = [
                    'username' => $this->request->getVar('username'),
                    'name' => $this->request->getVar('name'),
                    'phone_no' => $this->request->getVar('phone_no'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                $model->save($newData);
                session();
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                $data = [
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'tampil' => 'login',
                    'title' => 'Login'
                ];
                return view('pages/login', $data);
            }
        }
        return view('pages/register', $data);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
