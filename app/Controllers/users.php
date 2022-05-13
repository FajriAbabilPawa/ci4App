<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
class users extends BaseController
{
	private $userModel=NULL;
	function __construct(){
		$this->userModel = new UserModel();
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
}