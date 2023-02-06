<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // $db_pegawai = db_connect('db_pegawai');
        // $builder = $db_pegawai->table('pegawai');
        // $query   = $builder->get();
        // print_r($query->getResult());
        return view('v_dashboard');
    }

    public function test()
    {
        echo 'daasdasd';
    }
}
