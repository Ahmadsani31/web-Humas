<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Select2 extends BaseController
{
    public function index()
    {

        $table =   $this->request->uri->getSegment(2);
        $builder = db_connect('db_pegawai')->table($table);
        if ($this->request->getVar('q')) {
            $builder->like('Nama', $this->request->getVar('q'));
        }
        $builder->select('PosisiID as id, Nama as text');
        $query =  $builder->limit(10)->get();
        $data = $query->getResult();
        return $this->response->setJSON($data);
    }
}
