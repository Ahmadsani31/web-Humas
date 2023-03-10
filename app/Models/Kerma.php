<?php

namespace App\Models;

use CodeIgniter\Model;

class Kerma extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kerma';
    protected $primaryKey       = 'KermaID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['JenisDokumenID', 'FileDokumen', 'NoDokumen', 'UnitID', 'UnitTerkaitID', 'TglMulai', 'TglSelesai', 'BidangID', 'LingkupID', 'JudulKegiatan', 'Manfaat', 'PeranKontribusi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'DCreate';
    protected $updatedField  = 'DEdited';
    protected $deletedField  = 'DDeleted';


    // Validation
    protected $validationRules      = [

        'JudulKegiatan'       =>        [
            'label'  => 'Judul kegiatan',
            'rules' => 'required|min_length[3]|max_length[255]',
        ],
        'MitraID'       =>        [
            'label'  => 'Mitra',
            'rules' => 'required',
        ],
        'JenisDokumenID' => [
            'label'  => 'Jenis Dokument',
            'rule' => 'required'
        ],
        'NoDokumen' => [
            'label'  => 'Nomor dokument',
            'rule' => 'required'
        ],
        'TglMulai' => [
            'rule' => 'required'
        ],
        'TglSelesai' => [
            'rule' => 'required'
        ],
        'BidangID' => [
            'rule' => 'required'
        ],
        'LingkupID' => [
            'rule' => 'required'
        ],
        'Manfaat' => [
            'rule' => 'required'
        ],
        'PeranKontribusi' => [
            'rule' => 'required'
        ]
    ];
    protected $validationMessages   = [
        'JudulKegiatan' => [
            'required' => '{field} harus diisi',
            'min_length' => '{field} minimal 3 huruf',
        ],
        'MitraID' => [
            'required' => '{field} Harus diisi',
        ],
        'JenisDokumenID' => [
            'required' => '{field} Harus diisi',
        ],
        'TglMulai' => [
            'required' => '{field} Harus diisi',
        ],
        'TglSelesai' => [
            'required' => '{field} Harus diisi',
        ],
        'BidangID' => [
            'required' => '{field} Harus diisi',
        ],
        'LingkupID' => [
            'required' => '{field} Harus diisi',
        ],
        'JudulKegiatan' => [
            'required' => '{field} Harus diisi',
        ],
        'Manfaat' => [
            'required' => '{field} Harus diisi',
        ],
        'PeranKontribusi' => [
            'required' => '{field} Harus diisi',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    public function getData($JenisMitraID, $JenisDokumenID, $TingkatID, $UnitID, $StatusID)
    {
        $builder = $this->table('kerma')
            ->select('kerma.LingkupID,mitra.TingkatID,mitra.JenisMitraID,kerma.LinkDokumen,kerma.DDeleted,kerma.NoDokumen,kerma.JenisDokumenID,kerma.NA,kerma.KermaID,kerma.FileDokumen,mitra_jenis.Nama as NamaJenisMitra,kerma_ruang_lingkup.Nama as NamaLingkup, kerma.UnitID,kerma.UnitTerkaitID,kerma.TglMulai,kerma.TglSelesai, mitra.Nama as NamaMitra,kerma_tingkat.Nama as NamaTingkat,kerma_bidang.Nama as NamaBidang,kerma.JudulKegiatan,kerma.Manfaat,kerma.PeranKontribusi,kerma.FileDokumen')
            ->join('mitra', 'mitra.MitraID=kerma.MitraID', 'LEFT')
            ->join('mitra_jenis', 'mitra_jenis.JenisMitraID=mitra.JenisMitraID', 'LEFT')
            ->join('kerma_tingkat', 'kerma_tingkat.TingkatID=mitra.TingkatID', 'LEFT')
            ->join('kerma_bidang', 'kerma_bidang.BidangID=kerma.BidangID', 'LEFT')
            ->join('kerma_ruang_lingkup', 'kerma_ruang_lingkup.LingkupID=kerma.LingkupID', 'LEFT')
            ->where('kerma.DDeleted', null)
            ->where('kerma.NA', 'N');
        if (!empty($JenisMitraID)) {
            $builder->where('mitra_jenis.JenisMitraID', $JenisMitraID);
        }
        if (!empty($JenisDokumenID)) {
            $builder->where('kerma.JenisDokumenID', $JenisDokumenID);
        }
        if (!empty($TingkatID)) {
            $builder->where('kerma_tingkat.TingkatID', $TingkatID);
        }
        if (!empty($UnitID)) {
            $builder->where('kerma.UnitID', $UnitID);
        }
        if (!empty($StatusID)) {
            if ($StatusID == 'STA') {
                $builder->where('kerma.TglMulai >=', date('Y-m-d'));
            } elseif ($StatusID == 'STB') {
                $builder->where('kerma.TglMulai <= "' . date('Y-m-d') . '" AND kerma.TglSelesai >="' . date('Y-m-d') . '"');
            } elseif ($StatusID == 'STC') {
                $builder->where('kerma.TglSelesai <=', date('Y-m-d'));
            }
        }
        $builder->orderBy('year(TglMulai)', 'DESC');
        $builder->orderBy('KermaID');
        // $builder->limit(10);
        return $builder;
    }

    public function getRows()
    {
        $builder = db_connect()->table($this->table)
            ->where('DDeleted', null)
            ->where('NA', 'N')->get()->getNumRows();
        return $builder;
    }
    //callback
    protected function beforeInsert(array $data)
    {
        $data['data']['UCreate'] = session()->get('s_Nama');
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['UEdited'] = session()->get('s_Nama');
        return $data;
    }

    protected function afterDelete(array $data)
    {
        $builder = db_connect()->table($this->table);
        $dataUpdate = [
            'NA' => 'Y',
            'UDelete'  => session()->get('s_Nama'),
        ];
        $builder->where($this->primaryKey, $data['id'][0]);
        $builder->update($dataUpdate);
        // db_connect()->query('UPDATE ' . $this->table . ' SET NA="Y", UDelete="' . session()->get('s_Nama') . '" WHERE ' . $this->primaryKey . '="' . $data['id'][0] . '"');
    }
}
