<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'tampil' => 'home'
        ];
        echo view('pages/home', $data);
    }

    public function welcome()
    {
        return view('welcome_message');
    }
}
