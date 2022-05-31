<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
class users extends BaseController
{
	private $userModel=NULL;
	function __construct(){
		$this->userModel = new UserModel();
        $this->email = \Config\Services::email();
	}
	public function index()
	{
		return view('welcome_message');
	}
	public function register()
	{
		return view('register');
	}
	public function login()
	{
		return view('login');
	}
	public function userRegister()
	{
		/*print_r($this->request->getFiles());
		print_r($this->request->getPost());die;*/
		$img='';
		$files=$this->request->getFile('profile_img');
		if(!$files->isValid()){
			session()->setFlashData("Error", "Profile Image is Required");
			return redirect()->back()->withInput();
		}
		if(!$this->userModel->isValidFileType($files->getMimeType())){
			session()->setFlashData("Error", "Please Upload a Valid Image File Type");
			return redirect()->back()->withInput();
		}
		$file=$files->move('public/uploads/user/', $files->getClientName());
		if($files->hasMoved()){
			$img=$files->getName();
		}else{
			session()->setFlashData("Error", "Profile Image Failed to Upload");
			return redirect()->back()->withInput();
		}
		//echo $img;
		$data=[
			'name'=>$this->request->getPost('name'),
			'email'=>$this->request->getPost('email'),
			'phone_no'=>$this->request->getPost('contact'),
			'pfp'=>$img,
			'password'=>$this->request->getPost('password'),
			'confirm_password'=>$this->request->getPost('confirm_password')
		];
		if(!$this->userModel->insert($data)){
			session()->setFlashData("Error", " Fialed to Register");
			session()->setFlashData("ErrorData", $this->userModel->errors());
			return redirect()->back()->withInput();
		}

		session()->setFlashData("Success", "User Register Successful");
		return redirect()->to(base_url()."/login");
	}

	function userLogin(){
		//print_r($this->request->getPost());die;
		$find=$this->userModel->getWhere(['email'=>$this->request->getPost('email')])->getRowArray();
		if(!$find){
			session()->setFlashData("Error", "Please Enter a Valid Email Id");
			session()->setFlashData("ErrorData", $this->userModel->errors());
			return redirect()->back()->withInput();
		}
		if(!password_verify($this->request->getPost('password'), $find['password'])){
			session()->setFlashData("Error", "Please Enter a Valid Password");
			session()->setFlashData("ErrorData", $this->userModel->errors());
			return redirect()->back()->withInput();
		}
		session()->set("LoggedUserData", $find);
		session()->setFlashData("Success", "Login Successful ");
		return redirect()->to(base_url()."/profile");
	}

	public function profile(){
		$data = [
			'title' => "Profile",
			'pfp' => base_url('') . '/' . $this->userModel->getPfp(session()->get('username')),
		];
		return view('profile', $data);
	}

	public function logout()
	{
		if(session()->get('LoggedUserData')){
			session()->remove('LoggedUserData');
			session()->setFlashData("Success", "Logout Successful ");
			return redirect()->to(base_url()."/login");
		}
		session()->setFlashData("Error", "Failed to Logout, Please Try Again");
		return redirect()->to(base_url()."/profile");
	}

	
	
	public function profileupdate()
	{
		$img='';
		helper('form');
		$files = $this->request->getFile('profile_img');
		$data=[];
		if (isset($files)) {
			if(!$files->isValid()){
				// it means you dont want to change your profile photo/Image
				$data = [
					'name'=>$this->request->getPost('name'),
					'phone_no'=>$this->request->getPost('contact')
				];
			}else{
				//if you want to change your profile photo also.
				if(!$this->userModel->isValidFileType($files->getMimeType())){
					session()->setFlashData("Error", "Please Upload a Valid Image File Type");
					return redirect()->back()->withInput();
				}
				$files->move('images/uploads/user/', $files->getClientName());
				if($files->hasMoved()){
					$img=$files->getName();
				}
				$data=[
					'name'=>$this->request->getPost('name'),
					'phone_no'=>$this->request->getPost('contact'),
					'pfp'=> 'images/uploads/user/' . $img
				];
			}

			$update = $this->userModel->update($this->userModel->getId(session()->get('email')), $data);
			if ($update){
				session()->set($data);
				session()->setFlashData("Success", "Profile Update Successful");
			} else {
				$data = [
					'error' => "Failed to Update Your Profile.",
					'ErrorData' => $this->userModel->errors(),
					'ErrorData' => $this->userModel->errors(),
					'name'=>$this->request->getPost('name'),
					'phone_no'=>$this->request->getPost('contact'),
				];
				return view('profileupdate', $data);
			}
			
			return redirect()->to(base_url()."/profile");
		}
		return view('profileupdate', $data);
	}

	public function changepassword()
	{
		return view('changepassword');
	}
	public function updatepassword()
	{
		$this->userModel = new UserModel();
		// print_r($this->request->getPost());die;
		// dd($this->request->getPost('confirm_password'));
		$email = session()->get('email');
		$pass = $this->request->getPost('password');
		$row = $this->userModel->get();
		// dd(session()->get());
		if($this->request->getPost('oldpassword') == session()->get('password')){ d('layer1');
			if($this->request->getPost('password')===$this->request->getPost('confirm_password')){d('layer2');
				if(!$this->userModel->update($email, ['password'=>password_hash($pass, PASSWORD_BCRYPT)]). d('layer3 . data passed . forwarding to other neverending errors :)')){
					return redirect()->back()->with("Error", "Failed to Change Password, Please Try Again");
				}
				d('layer4');
				$find=$this->userModel->getWhere(['id'=>$email])->getRowArray();
				session()->remove('LoggedUserData');
				session()->set('LoggedUserData', $find);
				session()->setFlashData("Success", "Password Update Successful ");
				return redirect()->to(base_url()."/profile");
			}
			return redirect()->back()->with("Error", "Confirm Password is not Matched, Please Try Again");
		}
		return redirect()->to('changepassword')->with("Error", "Old Password is not Matched, Please Try Again");
	}
	public function deleteAccount()
	{
		if(!$this->userModel->delete(session()->get('id'))){
			return redirect()->back()->with("Error", "Failed to delete Account, Please Try Again");
		}
		session()->remove('LoggedUserData');
		session()->setFlashData("Success", "Account Delete Successful ");
		return redirect()->to(base_url()."/login");
	}
	
	private function sendEmail($user)
    {
		$this->email = \Config\Services::email();
		$this->email->setTo($user['email']);

        $this->email->setSubject('Reset Password');
        $this->email->setMessage(
            '<h3>Hi, ' . $user['username'] . '</h3> 
            Click here to reset your password: <br> 
            <a href="' . base_url('reset-password/' . $user['token']) .
                '" class="btn btn-primary"></a><br>or click the link below and use the token <br>' .
                '<a href="' . base_url('reset-password') . '/' . $user['uuid'] . '">Reset Password</a><br>' .
                '<br>Token: <h3>' . $user['token'] .  '</h3>'
        );

        if ($this->email->send()) {
            session()->set('token', $user['token']);
            return true;
        } else {
            echo $this->email->printDebugger();
            return false;
        }
    }

	public function ForgotPassword()
    {
        $data = [
            'title' => 'Forgot Your Password ?',
        ];

        // validate email
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|valid_email',
            ];

            $errors = [
                'email' => [
                    'required' => 'Field Email harus diisi',
                    'valid_email' => 'Email harus valid "(Memakai @ dan .com)"',
                ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data = [
                    'title' => 'Forgot Your Password',
                    'validation' => $this->validator,
                    'email' => $this->request->getVar('email'),
                ];

                return view('forgot-password', $data);
            } else {
                $model = new UserModel();
                $user = $model->where('email', $this->request->getVar('email'))->first();

                if ($user) {
                    $sendMail = $this->sendEmail([
                        'email' => $this->request->getVar('email'),
                        'username' => $model->getUsername($this->request->getVar('email'))['username'],
                        'uuid' => $model->getId($this->request->getVar('email')),
                        'token' => $model->createToken($this->request->getVar('email')),
                    ]);

                    if ($sendMail !== false) {
                        session()->setFlashdata('success', 'Silahkan cek email anda untuk melakukan reset password<br><b>Link akan dihapus dalam 15 menit</b>');
                        session()->markAsTempdata('success', 1);
                        $data = [
                            'user' => $this->request->getVar('email'),
                            'title' => 'Login',
                        ];

                        return view('pages/login', $data);
                    } else {
                        session()->setTempdata('error', 'Email gagal dikirim, coba lagi', 3);
                        session()->markAsTempdata('error', 1);
                    }

                    $data = [
                        'title' => 'Forgot Your Password',
                        'email' => $this->request->getVar('email'),
                    ];
                } else {
                    $data = [
                        'title' => 'Forgot Your Password',
                        'email' => $this->request->getVar('email'),
                    ];
                    session()->setFlashdata('error', 'Email tidak terdaftar');
                    session()->markAsTempdata('error', 1);
                    return view('pages/forgot-password', $data);
                }
            }
        }

        return view('forgot-password', $data);
    }
	public function resetPassword($slug)
    {
        $model = new UserModel();
        $data = [
            'title' => 'Reset Password',
            'slug' => $slug,
        ];

        $user = $model->where('id', $slug)->first();
        if (null != $user) {
            if ($user['token_expire'] > date('Y-m-d H:i:s')) {
                if ($this->request->getMethod() == 'post') {
                    $rules = [
                        'token' => 'required|is_token_expired[token]',
                        'user' => 'required|valid_email|is_exist[user]|is_token_in_email[user,token]',
                        'password' => 'required|min_length[8]|max_length[255]',
                        'pass_confirm' => 'required|matches[password]',
                    ];
                    $errors = [
                        'token' => [
                            'required' => 'Token tidak boleh kosong',
                            'is_token' => 'Token tidak cocok',
                            'is_token_expired' => 'Token sudah kadaluarsa',
                        ],
                        'user' => [
                            'required' => 'Email tidak boleh kosong',
                            'valid_email' => 'Email tidak valid',
                            'is_exist' => 'Email tidak terdaftar',
                            'is_token_in_email' => 'Token tidak cocok dengan email. Silahkan cek email anda',
                        ],
                        'password' => [
                            'required' => 'Password tidak boleh kosong',
                            'min_length' => 'Minimum karakter untuk Field password adalah 8 karakter',
                            'max_length' => 'Maksimum karakter untuk Field password adalah 255 karakter',
                        ],
                        'pass_confirm' => [
                            'required' => 'Konfirmasi password tidak boleh kosong',
                            'matches' => 'Konfirmasi password tidak cocok',
                        ],
                    ];

                    if (!$this->validate($rules, $errors)) {
                        $data = [
                            'validation' => $this->validator,
                            'title' => 'Reset Password',
                            'slug' => $slug,
                            'token' => $this->request->getPost('token'),
                            'user' => $this->request->getPost('user'),
                        ];
                    } else {
                        $user = $model->where('email', $this->request->getVar('user'))->first();

                        $data = [
                            'title' => 'Login',
                            'token' => null,
                            'token_expire' => null,
                            'password' => $this->request->getVar('password'),
                            'user' => $user['email'],
                        ];

                        $model->update($user['id'], $data);

                        session()->destroy();
                        session()->set('success', 'Password berhasil diubah');

                        return view('pages/login', $data);
                    }
                }
            } else {
                session()->setTempdata('expired', 'expired', 3);
            }
        } else {
            session()->setTempdata('not-found', 'not found', 3);
        }
        return view('pages/reset-password', $data);
    }

}