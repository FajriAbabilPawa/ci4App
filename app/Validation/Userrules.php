<?php

namespace App\Validation;

use App\Models\UserModel;

class Userrules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        // get user data by email or username
        $user = $model->where('email', $data['user'])->orwhere('username', $data['user'])->first();

        if (!$user) {
            return false;
        }

        return password_verify($data['password'], $user['password']);
    }

    /**
     * Authenticate admin by using admin key
     */
    public function admin_key(string $str, string $fields, array $data)
    {
        if ($data['admin'] == 'endit') {
            return true;
        }

        return false;
    }

    /** 
     * Check if password input is the same as the old password
     */
    public function checkOldPassword(string $str, string $fields, array $data)
    {
        $model = new UserModel();

        $password = $model->where('id', session()->get('id_user'))->first()['password'];
        $oldPassword = password_verify($data['oldPassword'], $password);

        if ($oldPassword) {
            return true;
        }

        return false;
    }

    /** 
     * Check if email or username is exist in database.
     * if exist, return true
     */
    public function is_exist(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        // get user data by email or username
        $user = $model->where('email', $data['user'])->orwhere('username', $data['user'])->first();

        if ($user) {
            return true;
        }

        return false;
    }

    /** 
     * Check if the token is valid
     */
    // public function is_token(string $str, string $fields, array $data)
    // {
    //     $model = new UserModel();
    //     // get user data by email or username
    //     $user = $model->where('email', $data['user'])->orwhere('username', $data['user'])->first();

    //     if ($user) {
    //         if ($user['token'] == $data['token']) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

    /** 
     * Check if the token is expired
     */
    public function is_token_expired(string $str, string $fields, array $data)
    {
        if (false == $this->is_token_in_email($str, $fields, $data)) {
            return null;
        } else {
            $model = new UserModel();
            if (null != $data['token']) {
                // get user data by token
                $user = $model->where('token', $data['token'])->first();

                if ($user) {
                    if ($user['token_expire'] > date('Y-m-d H:i:s')) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Check if token is in email
     */
    public function is_token_in_email(string $str, string $fields, array $data)
    {
        if (false == $this->is_exist($str, $fields, $data)) {
            return null;
        } else {
            $model = new UserModel();
            // get user data by email or username
            $user = $model->where('email', $data['user'])->first();

            if ($user) {
                if ($user['token'] == $data['token'] && $user['email'] == $data['user']) {
                    return true;
                }
            }

            return false;
        }
    }
}