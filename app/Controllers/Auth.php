<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MAuth;
use Config\Services;

class Auth extends BaseController
{
    public function __construct()
    {
        //__construct
        $this->MAuth = new MAuth();
        $this->helpers = ['form', 'url'];
    }

    public function index()
    {
        return view('v_login');
    }

    public function register()
    {
        return view('v_login');
    }

    public function login()
    {
        $Post = $this->request->getPost();
        $Credentials = ['Username' => $Post['Username']];

        $Data = $this->MAuth->where($Credentials)->first();

        if ($Data) {
            $Password = $Data['Password'];
            $AuthenticatePassword = password_verify($Post['Password'], $Password);
            if ($AuthenticatePassword) {
                $sessionData = [
                    's_UserID' => $Data['UserID'],
                    's_Nama' => $Data['Nama'],
                    'isLoggedIn' => TRUE
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', "Password yang anda masukan salah");
            }
        } else {
            return redirect()->back()->with('error', "Username dan password tidak terdaftar");
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
