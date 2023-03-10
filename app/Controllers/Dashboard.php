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

        $data = [
            'Mitra' => $this->mMitra->getRows(),
            'Kerma' => $this->mKerma->getRows(),
        ];

        return view('v_dashboard', $data);
    }

    public function grafikDashboard()
    {
        $db = $this->mKerma->orderBy('TglMulai', 'asc')->findAll();

        $dataKer = [1, 2, 3, 4];
        foreach ($db as $n) {
            $Tahun = substr($n['TglMulai'], 0, 4);
            $th[] = substr($n['TglMulai'], 0, 4);
            $Data[$n['JenisDokumenID']][$Tahun][] = $n['KermaID'];

            $doc[$n['JenisDokumenID']][] = $n['KermaID'];
        }

        foreach (array_unique($th) as $vTahun) {
            $nTahun[] = $vTahun;
        }

        foreach ($dataKer as $dkl) {
            foreach ($nTahun as $thn) {
                if (isset($Data[$dkl][$thn])) {
                    $ttl = count($Data[$dkl][$thn]);
                } else {
                    $ttl = 0;
                }
                $dNN[$dkl][] = $ttl;
            }
        }

        echo json_encode(['bar' => ['Tahun' => $nTahun, 'MoA' => $dNN[2], 'MoU' => $dNN[1], 'MaI' => $dNN[3],], 'pie' => ['MoA' => count($doc[2]), 'MoU' => count($doc[1]), 'MaI' => count($doc[3])]]);
    }
}
