<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Bidang extends BaseController
{
    public function index()
    {
        return view('v_bidang');
    }

    public function saveBidang()
    {
        $Post = $this->request->getPost();

        $data = [
            'Nama' => $Post['Nama']
        ];

        if ($Post['BidangID'] == 0) {
            $param = $this->mBidang->insert($data);
        } else {
            $param = $this->mBidang->update($Post['BidangID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mBidang->errors()]);
        }
    }
}
