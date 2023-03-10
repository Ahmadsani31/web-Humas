<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Library;
use \Hermawan\DataTables\DataTable;

class ServerSide extends BaseController
{

    public function index()
    {

        $d = $this->request->getVar('datatable');
        switch ($d) {
            case 'mitra':
                $db = $this->mMitra->getData();
                return Datatable::of($db)->addNumbering('no')->toJson(true);
                break;
            case 'kerma':
                $JenisMitraID = $this->request->getPost('JenisMitraID');
                $JenisDokumenID = $this->request->getPost('JenisDokumenID');
                $TingkatID = $this->request->getPost('TingkatID');
                $UnitID = $this->request->getPost('UnitID');
                $StatusID = $this->request->getPost('StatusID');

                $db = $this->mKerma->getData($JenisMitraID, $JenisDokumenID, $TingkatID, $UnitID, $StatusID);
                return Datatable::of($db)
                    ->addNumbering('no')
                    ->add('UnitID', function ($row) {
                        return GetField('simpeg_posisi_jabatan', 'PosisiID', $row->UnitID, 'Nama', 'db_pegawai');
                    })
                    ->add('UnitTerkaitID', function ($row) {
                        $UnitTerkaitID =  explode(',', $row->UnitTerkaitID);
                        foreach ($UnitTerkaitID as $unit) {
                            $vUnit[] = '<span class="badge badge-info p-1">' . GetField('simpeg_posisi_jabatan', 'PosisiID', $unit, 'Nama', 'db_pegawai') . '</span>';
                        }
                        return implode(" ", $vUnit);
                    })
                    ->add('LingkupID', function ($row) {
                        $LingkupID =  explode(',', $row->LingkupID);
                        foreach ($LingkupID as $unit) {
                            $vUnit[] = '<span class="badge badge-info p-1">' . GetField('kerma_ruang_lingkup', 'LingkupID', $unit, 'Nama') . '</span>';
                        }
                        return implode(" ", $vUnit);
                    })
                    ->add('JenisDokumen', function ($row) {
                        return GetField('jenis_dokument', 'DokumentID', $row->JenisDokumenID, 'Nama');
                    })
                    ->add('TglMulai', function ($row) {
                        return tanggalIndo($row->TglMulai, 'A');
                    })
                    ->add('TglSelesai', function ($row) {
                        return tanggalIndo($row->TglSelesai, 'A');
                    })
                    ->add('Status', function ($row) {
                        $diff  = date_diff(date_create(date('Y-m-d')), date_create($row->TglSelesai));
                        if (date('Y-m-d') <= $row->TglMulai) {
                            $Status = '<span class="badge p-1 badge-info">Ongoing</span>';
                        } else if (date('Y-m-d') >=  $row->TglMulai  && date('Y-m-d') <= $row->TglSelesai) {
                            $Status = '<span class="badge p-1 badge-success">Sedang Berjalan</span>';
                            if ($diff->format('%R') == '+') {
                                if ($diff->format('%a') <= 15) {
                                    $Status .= '<br><span class="badge badge-warning">' . $diff->format('Tinggal %a hari lagi') . '</span>';
                                }
                            }
                        } else {
                            $Status = '<span class="badge p-1 badge-danger">Kadarluarsa</span>';
                        }
                        return $Status;
                    })
                    ->add('Button', function ($row) {
                        $btnClass = 'btn-danger';
                        if ($row->FileDokumen) {
                            $btnClass = 'btn-info';
                        }
                        $Button = '<a href="' . base_url() . '/assets/files/document/' . $row->JenisDokumenID . '/' . $row->FileDokumen . '" target="blank" class="btn btn-sm ' . $btnClass . ' btn-sm mr-1 mb-1"><i class="fa fa-file-pdf"></i></a>&nbsp;';
                        $Button .= '<button class="btn btn-sm btn-primary btn-sm modal-cre mr-1 mb-1" kermaid="' . $row->KermaID . '" id="add-kerma" Judul="Update data Kerma"><i class="fas fa-edit"></i></button>&nbsp;';
                        $Button .= '<button class="btn btn-sm btn-danger btn-sm mr-1 mb-1 modal-hapus-cre" id="' . $row->KermaID . '" table="kerma"><i class="fas fa-trash"></i></button>&nbsp;';
                        return $Button;
                    }, 'last')
                    ->toJson(true);
                break;
        }
    }
}
