<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Library;
use CodeIgniter\Files\File;
use PDF_FancyRow;

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

        $data = [
            'JenisDokumenID'    => $Post['JenisDokumenID'],
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

        if ($FileDokumen->isValid()) {
            // print_r($FileDokumen);
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
                // $data['FileDokumen'] = new File($filepath . $newName);
                $data['FileDokumen'] = $newName;
            } else {
                return $this->response->setJSON(['param' => $param, 'pesan' => $this->validator->getErrors()]);
            }
        }

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

    function lapAkreditas()
    {

        // header("Content-type: application/vnd-ms-excel");
        // header("Content-Disposition: attachment; filename=Data Pegawai.xls");

        $post = $this->request->getPost();

        $Table = $this->mKerma->getData($post['JenisMitraID'], $post['JenisDokumenID'], $post['TingkatID'], $post['UnitID'], $post['StatusID'])->get();

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="2">No</th>';
        echo '<th rowspan="2">Mitra</th>';
        echo '<th colspan="3">Peran dan Kontribusi Mitra</th>';
        echo '<th rowspan="2">Judul Kegiatan Kerja Sama</th>';
        echo '<th rowspan="2">Manfaat bagi PS yang Diakreditas</th>';
        echo '<th rowspan="2">Waktu dan Durasi</th>';
        echo '<th rowspan="2">Bukti Kerja Sama</th>';
        echo '<th rowspan="2">Tahun Berakhir</th>';
        echo '<th rowspan="2">Unit</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>Internasional</th>';
        echo '<th>Nasional</th>';
        echo '<th>Local/Wilayah</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $no = 1;
        foreach ($Table->getResultArray() as $key => $value) {
            // echo '<pre>';
            // print_r($value);
            // echo '</pre>';

            $date1 = date_create($value['TglMulai']);
            $date2 = date_create($value['TglSelesai']);
            $diff = date_diff($date1, $date2);
            if ($diff->format('%Y') > 0) {
                $Durasi = $diff->format('%y Tahun');
            } else {
                $Durasi = $diff->format('%m Bulan');
            }


            $a = '';
            $b = '';
            $c = '';

            if ($value['TingkatID'] == 1) {
                $a = '&#10004;';
            } elseif ($value['TingkatID'] == 2) {
                $b = '&#10004;';
            } elseif ($value['TingkatID'] == 3 || $value['TingkatID'] == 4) {
                $c = '&#10004;';
            }


            $Unit = GetField('simpeg_posisi_jabatan', 'PosisiID', $value['UnitID'], 'Nama', 'db_pegawai');

            echo '<tr>';
            echo '<th>' . $no++ . '</th>';
            echo '<td>' . $value['NamaMitra'] . '</td>';
            echo '<td>' . $b . '</td>';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $a . '</td>';
            echo '<td>' . $value['JudulKegiatan'] . '</td>';
            echo '<td>' . $value['Manfaat'] . '</td>';
            echo '<td>'  . $Durasi . '</td>';
            echo '<td>' . $value['LinkDokumen'] . '</td>';
            echo '<td>' . substr($value['TglSelesai'], 0, 4) . '</td>';
            echo '<td>' . $Unit . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    function lapLldikti()
    {
        $post = $this->request->getPost();

        $Table = $this->mKerma->getData($post['JenisMitraID'], $post['JenisDokumenID'], $post['TingkatID'], $post['UnitID'], $post['StatusID'])->get();

        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="2">No</th>';
        echo '<th rowspan="2">Unit</th>';
        echo '<th colspan="5">Mitra (Jenis Mitra)</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>Perguruan Tinggi</th>';
        echo '<th>Industri/Dunia Usaha</th>';
        echo '<th>Instansi Pemerintah</th>';
        echo '<th>lembaga Sosial</th>';
        echo '<th>Lain-lainya</th>';
        echo '</tr>';

        echo '</thead>';
        echo '<tbody>';
        $no = 1;
        foreach ($Table->getResultArray() as $key => $value) {
            $a = '';
            $b = '';
            $c = '';
            $d = '';
            $e = '';

            if ($value['JenisMitraID'] == 1) {
                $a = '&#10004;';
            } elseif ($value['JenisMitraID'] == 2 || $value['JenisMitraID'] == 3) {
                $b = '&#10004;';
            } elseif ($value['JenisMitraID'] == 4) {
                $c = '&#10004;';
            } elseif ($value['JenisMitraID'] == 5) {
                $d = '&#10004;';
            } elseif ($value['JenisMitraID'] == 6) {
                $e = '&#10004;';
            }


            $Unit = GetField('simpeg_posisi_jabatan', 'PosisiID', $value['UnitID'], 'Nama', 'db_pegawai');


            echo '<tr>';
            echo '<th>' . $no++ . '</th>';
            echo '<td>' . $Unit . '</td>';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $a . '</td>';
            echo '<td>' . $d . '</td>';
            echo '<td>' . $e . '</td>';
            echo '<td>' . $b . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    function lapMatriks()
    {
        $post = $this->request->getPost();

        $Table = $this->mKerma->getData($post['JenisMitraID'], $post['JenisDokumenID'], $post['TingkatID'], $post['UnitID'], $post['StatusID'])->get();


        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="3">No</th>';
        echo '<th rowspan="3">Tahun</th>';
        echo '<th rowspan="3">Program dan Kegiatan ITP</th>';
        echo '<th colspan="8">Peran dan Kontribusi Mitra</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th colspan="5">Jenis Mitra</th>';
        echo '<th colspan="2">Luaran</th>';
        echo '<th rowspan="2">Link Dokumen</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<th>IDUKA</th>';
        echo '<th>Perguruan Tinggi</th>';
        echo '<th>Pendidikan</th>';
        echo '<th>Instansi Pemerintah</th>';
        echo '<th>Organisasi</th>';
        echo '<th>Unit</th>';
        echo '<th>Keterangan</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $no = 1;
        foreach ($Table->getResultArray() as $key => $value) {
            $LingkupID =  explode(',', $value['LingkupID']);
            foreach ($LingkupID as $unit) {
                $dLingkup[$value['KermaID']][] =  GetField('kerma_ruang_lingkup', 'LingkupID', $unit, 'Nama');
            }

            $th[] = $value;

            $LingkupID1 =  implode(', ', $dLingkup[$value['KermaID']]);

            $UnitTerkaitID =  explode(',', $value['UnitTerkaitID']);
            foreach ($UnitTerkaitID as $unit) {
                $dUnitTerkait[$value['KermaID']][] =  GetField('simpeg_posisi_jabatan', 'PosisiID', $unit, 'Nama', 'db_pegawai');
            }
            $UnitTerkaitID1 =  implode(', ', $dUnitTerkait[$value['KermaID']]);

            $Unit = GetField('simpeg_posisi_jabatan', 'PosisiID', $value['UnitID'], 'Nama', 'db_pegawai');

            $Tahun = substr($value['TglMulai'], 0, 4);
            $NamaLingkup = $value['JenisDokumenID'];

            $a = '';
            $b = '';
            $c = '';
            $d = '';
            $e = '';

            if ($value['JenisMitraID'] == 1) {
                $a = '&#10004;';
            } elseif ($value['JenisMitraID'] == 2 || $value['JenisMitraID'] == 3) {
                $b = '&#10004;';
            } elseif ($value['JenisMitraID'] == 4) {
                $c = '&#10004;';
            } elseif ($value['JenisMitraID'] == 5) {
                $d = '&#10004;';
            } elseif ($value['JenisMitraID'] == 6) {
                $e = '&#10004;';
            }

            echo '<tr>';
            echo '<th>' . $no++ . '</th>';
            echo '<td>' . substr($value['TglMulai'], 0, 4) . '</td>';
            echo '<td>' . $LingkupID1 . '</td>';
            echo '<td>' . $a . '</td>';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $b . '</td>';
            echo '<td>' . $d . '</td>';
            echo '<td>' . $e . '</td>';
            echo '<td>' . $Unit . '</td>';
            echo '<td>' . $value['JudulKegiatan'] . '</td>';
            echo '<td>' . $value['LinkDokumen'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

    function rekap()
    {
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf = Library::loadPdf();

        $pdf = new PDF_FancyRow();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(12, 'Please fill in your name, company and email below:');
        $pdf->Ln(20);
        $widths = array(5, 40, 5, 40, 5, 40);
        $border = array('', 'LBR', '', 'LBR', '', 'LBR');
        $caption = array('', 'Name', '', 'Company', '', 'Email');
        $align = array('', 'C', '', 'C', '', 'C');
        $style = array('', 'I', '', 'I', '', 'I');
        $empty = array('', '', '', '', '', '');
        $pdf->SetWidths($widths);
        $pdf->FancyRow($empty, $border);
        $pdf->FancyRow($caption, $empty, $align, $style);
        $pdf->Output();
    }

    function uploadExcelKerma()
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
                $dataInsert = [
                    'KermaID'           => $row[0],
                    'NoDokumen'         => $row[1],
                    'JenisDokumenID'    => $row[2],
                    'MitraID'           => $row[3],
                    'TglMulai'          => $row[4],
                    'TglSelesai'        => $row[5],
                    'BidangID'          => $row[6],
                    'LingkupID'         => $row[7],
                    'JudulKegiatan'     => $row[8],
                    'Manfaat'           => $row[9],
                    'PeranKontribusi'   => $row[10],
                    'UnitID'            => $row[11],
                    'UnitTerkaitID'     => $row[12],
                    'LinkDokumen'       => $row[13],
                ];

                if ($this->mKerma->insert($dataInsert)) {
                    session()->setFlashdata('success', 'Berhasil import excel');
                }
                session()->setFlashdata('errors', $this->mKerma->errors());
            }
        }

        return redirect()->to(base_url('kerma'));
    }
}
