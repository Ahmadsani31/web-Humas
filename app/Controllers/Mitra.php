<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Mitra extends BaseController
{
    public function index()
    {
        return view('mitra/v_mitra');
    }

    public function jenisMitra()
    {
        return view('mitra/v_jenis_mitra');
    }

    public function tingkat()
    {
        return view('mitra/v_tingkat');
    }

    public function saveMitra()
    {
        $Post = $this->request->getPost();

        $data = [
            'Nama' => $Post['Nama'],
            'JenisMitraID' => $Post['JenisMitraID'],
            'TingkatID' => $Post['TingkatID'],
            'Kontak' => $Post['Kontak'],
            'Alamat' => $Post['Alamat'],
        ];

        if ($Post['MitraID'] == 0) {
            $param = $this->mMitra->insert($data);
        } else {
            $param = $this->mMitra->update($Post['MitraID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mMitra->errors()]);
        }
    }

    public function saveTingkat()
    {
        $Post = $this->request->getPost();

        $data = [
            'Nama' => $Post['Nama']
        ];

        if ($Post['TingkatID'] == 0) {
            $param = $this->mTingkat->insert($data);
        } else {
            $param = $this->mTingkat->update($Post['TingkatID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mTingkat->errors()]);
        }
    }

    public function saveJenisMitra()
    {
        $Post = $this->request->getPost();

        $data = [
            'Nama' => $Post['Nama']
        ];

        if ($Post['JenisMitraID'] == 0) {
            $param = $this->mJenisMitra->insert($data);
        } else {
            $param = $this->mJenisMitra->update($Post['JenisMitraID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mJenisMitra->errors()]);
        }
    }
}
