<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Library;

class Kerma extends BaseController
{
    protected $library;
    public function __construct()
    {
        $this->library = new Library;
    }
    public function index()
    {
        return view('v_kerma');
    }

    public function saveKerma()
    {
        $param = 0;
        $Post = $this->request->getPost();
        $FileDokumen = $this->request->getFile('FileDokumen');
        $UnitTerkaitID = implode(",", $Post['UnitTerkaitID']);
        $LingkupID = implode(",", $Post['LingkupID']);
        $newName = '';
        if ($FileDokumen->isValid()) {

            $isValidFile = $this->validate([
                'FileDokumen'       =>        [
                    'label' => 'File Dokumen',
                    'rules' => 'uploaded[FileDokumen]|mime_in[FileDokumen,application/pdf]|max_size[FileDokumen,10240]',
                    'errors' => [
                        'mime_in' => '{field} type tidak support',
                        'max_size' => '{field} ukuran melebihi kapasitas',
                    ]
                ]
            ]);

            if (!$isValidFile) {;
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->validator->getErrors()]);
            }
            $filepath = 'assets/files/document/' . $Post['JenisDokumenID'] . '/';
            createDir($filepath);

            if ($FileDokumen->isValid() && !$FileDokumen->hasMoved()) {
                $newName = $FileDokumen->getRandomName();
                $FileDokumen->move($filepath, $newName);
                $data['FileDokumen'] = $newName;
            }
        }


        $data = [
            'JenisDokumenID'    => $Post['JenisDokumenID'],
            'TingkatID'         => $Post['TingkatID'],
            'MitraID'           => $Post['MitraID'],
            'TglMulai'          => $Post['TglMulai'],
            'TglSelesai'        => $Post['TglSelesai'],
            'BidangID'          => $Post['BidangID'],
            'LingkupID'         => $LingkupID,
            'JudulKegiatan'     => $Post['JudulKegiatan'],
            'Manfaat'           => $Post['Manfaat'],
            'PeranKontribusi'   => $Post['PeranKontribusi'],
            'UnitID'            => $Post['UnitID'],
            'NoDokumen'         => $Post['NoDokumen'],
            'UnitTerkaitID'     => $UnitTerkaitID,
        ];


        if ($Post['KermaID'] == 0) {
            $param = $this->mKerma->insert($data);
        } else {
            $d =  $this->mKerma->find($Post['KermaID']);
            $filepath = 'assets/files/document/' . $d['JenisDokumenID'] . '/';
            if (file_exists($filepath . $d['FileDokumen']) && $d['FileDokumen']) {
                unlink($filepath . $d['FileDokumen']);
            }
            $param = $this->mKerma->update($Post['KermaID'], $data);
        }
        if ($param > 0) {
            return $this->response->setJSON(['param' => $param, 'pesan' => 'Berhasil Simpan']);
        } else {
            return $this->response->setJSON(['param' => $param, 'pesan' => $this->mKerma->errors()]);
        }
    }
}
