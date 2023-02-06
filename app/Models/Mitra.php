<?php

namespace App\Models;

use CodeIgniter\Model;

class Mitra extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mitra';
    protected $primaryKey       = 'MitraID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['Nama', 'TingkatID', 'JenisMitraID', 'Kontak'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'DCreate';
    protected $updatedField  = 'DEdited';
    protected $deletedField  = 'DDeleted';

    // Validation
    protected $validationRules = [
        'Nama'       =>        [
            'rules' => 'required|min_length[3]|max_length[255]',
        ],
        'TingkatID'       =>        [
            'rules' => 'required',
        ],
        'JenisMitraID'       =>        [
            'rules' => 'required',
        ],
        'Kontak' => [
            'rule' => 'required'
        ]
    ];
    protected $validationMessages   = [
        'Nama' => [
            'required' => '{field} harus diisi',
            'min_length' => '{field} minimal 3 huruf',
        ],
        'TingkatID' => [
            'required' => '{field} Harus diisi',
        ],
        'JenisMitraID' => [
            'required' => '{field} Harus diisi',
        ],
        'Kontak' => [
            'required' => '{field} Harus diisi',
        ],
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

    public function getData()
    {
        $builder = db_connect()->table($this->table)
            ->where('DDeleted', null)
            ->where('NA', 'N')->get();
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
