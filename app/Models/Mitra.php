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
            'label'  => 'Tingkatan Mitra',
            'rules' => 'required',
        ],
        'JenisMitraID'       =>        [
            'label'  => 'Jenis Mitra',
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
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    public function getData($JenisMitraID = null)
    {
        $builder = db_connect()->table($this->table)
            ->where('DDeleted', null)
            ->where('NA', 'N');
        if ($JenisMitraID != null) {
            $builder->where('JenisMitraID', $JenisMitraID);
        }
        $builder->orderBy('MitraID', 'DESC');
        return $builder->get();
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
        // $this->db_connect()->query('UPDATE ' . $this->table . ' SET NA="Y", UDelete="' . session()->get('s_Nama') . '" WHERE ' . $this->primaryKey . '="' . $data['id'][0] . '"');
    }
}
