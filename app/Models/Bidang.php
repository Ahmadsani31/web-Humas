<?php

namespace App\Models;

use CodeIgniter\Model;

class Bidang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kerma_bidang';
    protected $primaryKey       = 'BidangID';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['Nama'];

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
        ]
    ];
    protected $validationMessages   = [
        'Nama'       =>   [
            'required' => '{field} Harus diisi',
            'min_length' => '{field} minimal 3 huruf',
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

    public function getData()
    {
        $builder = $this->table($this->table)->where(['DDeleted' => null, 'NA' => 'N']);
        $query   = $builder->get();  // Produces: SELECT * FROM mytable

        return $query;
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
