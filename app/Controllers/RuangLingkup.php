<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RuangLingkup extends BaseController
{
    public function index()
    {
        return view('v_ruang-lingkup');
    }

    public function saveRuangLingkup()
    {
        $Post = $this->request->getPost();

        $data = [
            'Nama' => $Post['Nama']
        ];

        if ($Post['LingkupID'] == 0) {
            $param = $this->mRuangLingkup->insert($data);
        } else {
            $param = $this->mRuangLingkup->update($Post['LingkupID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mRuangLingkup->errors()]);
        }
    }
}
