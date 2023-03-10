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

    function uploadExcelMitra()
    {
        $FileExcel = $this->request->getFile('FileExcel');
        $ext = $FileExcel->getClientExtension();
        if (!$FileExcel->isValid()) {
            session()->setFlashdata('errors', ['Gagal simpan, File not exist']);
            return redirect()->to(base_url('kerma'));
            exit();
        }
        switch ($ext) {
            case 'xls':
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                break;
            case 'xlsx':
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                break;
            case 'csv':
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                break;
        }

        $spreadsheet = $render->load($FileExcel);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $key => $row) {

            if ($key != 0) {

                $cekUd = $this->mMitra->getWhere(['Nama' => $row[1]])->getResult();
                if (count($cekUd) > 0) {
                    session()->setFlashdata('errors', ['Gagal simpan, Data Duplicate']);
                    return redirect()->to(base_url('kerma'));
                    exit();
                } else {
                    $data = [
                        'Nama' => $row[1],
                        'TingkatID' => $row[2],
                        'JenisMitraID' => $row[3],
                        'Kontak' => $row[4],
                        'Alamat' => $row[5],
                    ];
                    // $db->table('undangan')->insert($save);
                    if ($this->mMitra->insert($data)) {
                        session()->setFlashdata('success', 'Berhasil import excel');
                    }
                    session()->setFlashdata('errors', $this->mMitra->errors());
                }
            }
        }
        return redirect()->to(base_url('mitra'));
    }
}
