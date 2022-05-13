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
        "pfp",
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
    protected $beforeUpdate         = [];
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

}
