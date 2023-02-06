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
    protected $allowedFields    = ['JenisDokumenID', 'NoDokumen', 'MitraID', 'TingkatID', 'UnitID', 'UnitTerkaitID', 'TglMulai', 'TglSelesai', 'BidangID', 'LingkupID', 'JudulKegiatan', 'Manfaat', 'PeranKontribusi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'DCreate';
    protected $updatedField  = 'DEdited';
    protected $deletedField  = 'DDeleted';


    // Validation
    protected $validationRules      = [
        'JudulKegiatan'       =>        [
            'rules' => 'required|min_length[3]|max_length[255]',
        ],
        'TingkatID'       =>        [
            'rules' => 'required',
        ],
        'MitraID'       =>        [
            'rules' => 'required',
        ],
        'JenisDokumenID' => [
            'rule' => 'required'
        ],
        'NoDokumen' => [
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
        'JudulKegiatan' => [
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
        'TingkatID' => [
            'required' => '{field} Harus diisi',
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
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    public function getData($MitraID, $JenisDokumenID, $TingkatID, $UnitID, $StatusID)
    {
        $builder = $this->table('kerma')
            ->select('kerma.DDeleted,kerma.NoDokumen,kerma.JenisDokumenID,kerma.NA,kerma.KermaID,kerma.FileDokumen,mitra_jenis.Nama as NamaJenisMitra,kerma_ruang_lingkup.Nama as NamaLingkup, kerma.UnitID,kerma.UnitTerkaitID,kerma.TglMulai,kerma.TglSelesai, mitra.Nama as NamaMitra,kerma_tingkat.Nama as NamaTingkat,kerma_bidang.Nama as NamaBidang,kerma.JudulKegiatan,kerma.Manfaat,kerma.PeranKontribusi,')
            ->join('mitra', 'mitra.MitraID=kerma.MitraID')
            ->join('mitra_jenis', 'mitra_jenis.JenisMitraID=mitra.JenisMitraID')
            ->join('kerma_tingkat', 'kerma_tingkat.TingkatID=kerma.TingkatID')
            ->join('kerma_bidang', 'kerma_bidang.BidangID=kerma.BidangID')
            ->join('kerma_ruang_lingkup', 'kerma_ruang_lingkup.LingkupID=kerma.LingkupID')
            ->where('kerma.DDeleted', null)
            ->where('kerma.NA', 'N');
        if (!empty($MitraID)) {
            $builder->where('mitra.MitraID', $MitraID);
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
        return $builder;
    }
    //callback
    protected function beforeInsert(array $data)
    {
        $data['data']['UCreate'] = session()->get('s_Nama');
        return $data;
    }

    protected function afterDelete(array $data)
    {
        db_connect()->query('UPDATE ' . $this->table . ' SET NA="Y", UDelete="' . session()->get('s_Nama') . '" WHERE ' . $this->primaryKey . '="' . $data['id'][0] . '"');
    }
}
