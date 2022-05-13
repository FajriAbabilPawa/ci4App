<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $User_data = [
            // [
            //     "username" => "Raja",
            //     "name" => "Rahul Sharma",
            //     "email" => "rahul_sharma@mail.com",
            //     "phone_no" => "7899654125",
            //     "role" => "admin",
            //     "password" => password_hash("12345678", PASSWORD_DEFAULT)
            // ],
            [
                "username" => "Rizalandit",
                "name" => "Rizal Anditama",
                "email" => "rizalanditama2105@gmail.com",
                "phone_no" => "083807787971",
                "role" => "admin",
                "password" => password_hash("12345678", PASSWORD_DEFAULT)
            ],
            [
                "username" => "Rendit",
                "name" => "Rizal Anditama",
                "email" => "rizalanditama05@gmail.com",
                "phone_no" => "083807787971",
                "role" => "member",
                "password" => password_hash("12345678", PASSWORD_DEFAULT)
            ],
        ];

        foreach ($User_data as $data) {
            $this->db->table('users')->insert($data);
        }
    }
}
