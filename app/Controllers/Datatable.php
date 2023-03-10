<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Library;

class Datatable extends BaseController
{
    public function index()
    {

        $d = $this->request->getVar('datatable');
        switch ($d) {
            case 'mitra':
                $table = $d;
                $JenisMitraID = $this->request->getPost('jenisMitra');
                $db = $this->mMitra->getData($JenisMitraID);
                break;
            case 'tingkat':
                $table = $d;
                $db = $this->mTingkat->getData();
                break;
            case 'jenis-tingkat':
                $table = $d;
                $db = $this->mJenisMitra->getData();
                break;
            case 'bidang':
                $table = $d;
                $db = $this->mBidang->getData();
                break;
            case 'ruang-lingkup':
                $table = $d;
                $db = $this->mRuangLingkup->getData();
                break;
            case 'kerma':
                $table = $d;
                $db = $this->mKerma->getData();
                break;
        }

        if ($db->getNumRows() > 0) {
            switch ($table) {
                case 'mitra':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "MitraID"        => $info['MitraID'],
                            "TingkatID"        => Library::GetField('kerma_tingkat', 'TingkatID', $info['TingkatID'], 'Nama'),
                            "Nama"        => $info['Nama'],
                            "Alamat"        => $info['Alamat'],
                            "JenisMitraID"        => Library::GetField('mitra_jenis', 'JenisMitraID', $info['JenisMitraID'], 'Nama'),
                            "Kontak"        => $info['Kontak'],
                            "NA"        => $info['NA'],
                            "UCreate"        => $info['UCreate'] . '<br>' . $info['DCreate'],
                        ];
                    }
                    break;
                case 'tingkat':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "TingkatID"        => $info['TingkatID'],
                            "Nama"        => $info['Nama'],
                            "NA"        => $info['NA'],
                            "UCreate"        => $info['UCreate'] . '<br>' . $info['DCreate'],
                            "DCreate"        => $info['DCreate'],
                        ];
                    }
                    break;
                case 'jenis-tingkat':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "JenisMitraID"        => $info['JenisMitraID'],
                            "Nama"        => $info['Nama'],
                            "NA"        => $info['NA'],
                            "UCreate"        => $info['UCreate'] . '<br>' . $info['DCreate'],
                            "DCreate"        => $info['DCreate'],
                        ];
                    }
                    break;
                case 'bidang':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "BidangID"        => $info['BidangID'],
                            "Nama"        => $info['Nama'],
                            "NA"        => $info['NA'],
                            "UCreate"        => $info['UCreate'] . '<br>' . $info['DCreate'],
                            "DCreate"        => $info['DCreate'],
                        ];
                    }
                    break;
                case 'ruang-lingkup':
                    foreach ($db->getResultArray() as $info) {
                        $data['data'][] = [
                            "LingkupID"        => $info['LingkupID'],
                            "Nama"        => $info['Nama'],
                            "NA"        => $info['NA'],
                            "UCreate"        => $info['UCreate'] . '<br>' . $info['DCreate'],
                            "DCreate"        => $info['DCreate'],
                        ];
                    }
                    break;
                case 'kerma':
                    foreach ($db->getResultArray() as $info) {

                        $que =   db_connect()->query('SELECT b.Nama FROM mitra as a JOIN mitra_jenis as b on b.JenisMitraID=a.JenisMitraID WHERE a.MitraID="' . $info['MitraID'] . '"')->getRow();
                        $JenisMitra = $que->Nama;

                        $UnitTerkaitID =  explode(',', $info['UnitTerkaitID']);
                        $vUnit = '';
                        foreach ($UnitTerkaitID as $unit) {
                            $vUnit .= GetField('simpeg_posisi_jabatan', 'PosisiID', $unit, 'Nama', 'db_pegawai');
                        }
                        $LingkupID =  explode(',', $info['LingkupID']);
                        $vLingkup = '';
                        foreach ($LingkupID as $lingkup) {
                            $vLingkup .= '<span class="badge badge-info">' . GetField('kerma_ruang_lingkup', 'LingkupID', $lingkup, 'Nama') . '</span><br>';
                        }

                        $diff  = date_diff(date_create(date('Y-m-d')), date_create($info['TglSelesai']));

                        if (date('Y-m-d') <= $info['TglMulai']) {
                            $Status = '<span class="badge p-1 badge-info">Ongoing</span>';
                        } else if (date('Y-m-d') >=  $info['TglMulai']  && date('Y-m-d') <= $info['TglSelesai']) {
                            $Status = '<span class="badge p-1 badge-success">Sedang Berjalan</span>';
                            if ($diff->format('%R') == '+') {
                                if ($diff->format('%a') <= 15) {
                                    $Status .= '<br><span class="badge badge-warning">' . $diff->format('Tinggal %a hari lagi') . '</span>';
                                }
                            }
                        } else {
                            $Status = '<span class="badge p-1 badge-danger">Kadarluarsa</span>';
                        }

                        $Button = '<a href="' . base_url() . '/assets/files/document/' . $info['JenisDokumenID'] . '/' . $info['FileDokumen'] . '" target="blank" class="btn btn-sm btn-info btn-sm mr-1 mb-1"><i class="fa fa-file-pdf"></i></a>&nbsp;';

                        $data['data'][] = [
                            "NoDokumen"             => $info['NoDokumen'],
                            "JenisDokumenID"        => $info['JenisDokumenID'],
                            "KermaID"               => $info['KermaID'],
                            "JenisMitra"             => $JenisMitra,
                            "TingkatID"             => GetField('kerma_tingkat', 'TingkatID', $info['TingkatID'], 'Nama'),
                            "TglMulai"              => tanggalIndo($info['TglMulai'], "A"),
                            "TglSelesai"            => tanggalIndo($info['TglSelesai'], "A"),
                            "BidangID"              => GetField('kerma_bidang', 'BidangID', $info['BidangID'], 'Nama'),
                            "JudulKegiatan"         => $info['JudulKegiatan'],
                            "Manfaat"               => $info['Manfaat'],
                            "PeranKontribusi"       => $info['PeranKontribusi'],
                            "Mitra"                 =>  GetField('mitra', 'MitraID', $info['MitraID'], 'Nama'),
                            "KermaTingkat"          =>  GetField('kerma_tingkat', 'TingkatID', $info['TingkatID'], 'Nama'),
                            "UnitID"                => GetField('simpeg_posisi_jabatan', 'PosisiID', $info['UnitID'], 'Nama', 'db_pegawai'),
                            "UnitTerkaitID"         => $vUnit,
                            "LingkupID"             => $vLingkup,
                            "Jadwal"                => tanggalIndo($info['TglMulai'], 'A') . ' s/d ' . tanggalIndo($info['TglSelesai'], 'A'),
                            "NA"                    => $info['NA'],
                            "Status"                => $Status,
                            "Button"                => $Button,
                            "UCreate"               => $info['UCreate'] . '<br>' . $info['DCreate'],
                            "DCreate"               => $info['DCreate'],
                        ];
                    }
                    break;
            }
            echo json_encode($data);
        } else {
            echo '{"data":""}';
        }
    }
}
