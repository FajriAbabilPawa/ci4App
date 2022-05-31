<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDelete        = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        "username",
        "email",
        "phone_no",
        "password",
        "name",
        "role",
        "token",
        "token_expire",
        "pfp",
        "users",
    ];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    
    protected $validationRules = [
		'name' =>'required|alpha_space|min_length[3]',
		'email'=>'required|valid_email|is_unique[user.email]',
		'contact'=>'required|numeric|min_length[10]',
		'profile_img'=>'required',
		'password'=>'required|min_length[8]',
		'confirm_password'=>'required_with[password]|matches[password]'];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = ["beforeInsert"];
    protected $afterInsert          = [];
    protected $beforeUpdate         = ["beforeUpdate"];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    function isValidFileType($filetype) {
		$types=['image/gif','image/png','image/jpg','image/jpeg'];
		return in_array($filetype, $types)?true:false;
	}

    public function getPfp(string $username)
    {
        $pfp =  $this->where('username', $username)->first();
        return $pfp['pfp'];
    }

    /**
     * Get id by email
     */
    public function getId($email)
    {
        $user = $this->where('email', $email)->first();
        if (isset($user)) {
            return $user['id'];
        } else {
            return null;
        }

    }
    
    /**
     * Get username 
     */
    public function getUser($username = false)
    {
        if ($username == false) {
            $user = $this->findAll();
        } else {
            $user = $this->where('username', $username)->first();
        }

        return $user;
    }

    // check if email already in database
    public function checkEmail($email)
    {
        $user = $this->where('email', $email)->first();

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    /** 
     * Get username by email
     * 
     * @return array
     */
    public function getUsername($email = 0)
    {
        $user = $this->where('email', $email)->first();
        return $user;
    }

    /**
     * Get password by user id 
     *
     */
    public function getPassword($id_user)
    {
        $user = $this->where('id', $id_user)->first();
        return $user['password'];
    }

    /**
     * Get all Ids
     */
    public function getAllId()
    {
        $query = $this->db->query("SELECT Id FROM users");
        $result = $query->getResult();
        return $result;
    }

    /**
     * Check if Id exists
     */
    public function IdExists($Id)
    {
        $user = $this->where('Id', $Id)->first();
        return $user;
    }

    /**
     * Create token for user
     */
    public function createToken($email)
    {
        $user = $this->where('email', $email)->first();
        $data = [
            'token' => substr(hash('md5', microtime(), false), 0, 16),
            'token_expire' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
        ];
        $this->update($user['id'], $data);
        return $data['token'];
    }

    /**
     * --------------------------------------------------------------------------------
     * Check Old Password
     * --------------------------------------------------------------------------------
     * Get old password with query, then compare it with new password 
     * @var string
     */
    public function checkOldPassword(string $oldPassword)
    {
        $model = new UserModel();

        $password = $model->where('id', session()->get('id_user'))->first()['password'];
        $oldPassword = password_verify($oldPassword, $password);

        return $oldPassword;
    }

    /**
     * Get Profile Pic by user id
     */
    public function getProfilePic($id_user)
    {
        $user = $this->where('id', $id_user)->first();
        return $user['profile_pic'];
    }

    public function timestampFile($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $name = pathinfo($file, PATHINFO_FILENAME);
        $newName = time() . '_' . $name;
        $newFile = $newName . '.' . $ext;
        return $newFile;
    }

}
