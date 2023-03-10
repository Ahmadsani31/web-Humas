<?php

echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th rowspan="3">No</th>';
echo '<th rowspan="3">Tahun</th>';
echo '<th rowspan="3">Program dan Kegiatan ITP</th>';
echo '<th colspan="6">Peran dan Kontribusi Mitra</th>';
echo '</tr>';
echo '<tr>';
echo '<th rowspan="2">PT Lain</th>';
echo '<th rowspan="2">IDUKA</th>';
echo '<th rowspan="2">Instansi Lainya</th>';
echo '<th colspan="2">Luaran</th>';
echo '<th rowspan="2">Link Dokumen</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Program Studi</th>';
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

    echo '<tr>';
    echo '<th>' . $no++ . '</th>';
    echo '<td>' . substr($value['TglMulai'], 0, 4) . '</td>';
    echo '<td>' . GetField('jenis_dokument', 'DokumentID', $value['JenisDokumenID'], 'Nama') . '</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td>' . $LingkupID1 . '</td>';
    echo '<td>' . $UnitTerkaitID1 . '</td>';
    echo '<td>' . $value['JudulKegiatan'] . '</td>';
    echo '<td>' . $value['LinkDokumen'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
