<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Delete extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $ID =  $this->request->getPost('id');
        $Table =  $this->request->getPost('table');
        switch ($Table) {
            case 'mitra':
                if ($found = $this->mMitra->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'kerma_tingkat':
                if ($found = $this->mTingkat->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'mitra_jenis':
                if ($found = $this->mJenisMitra->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'kerma_bidang':
                if ($found = $this->mBidang->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'kerma_ruang_lingkup':
                if ($found = $this->mRuangLingkup->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            case 'kerma':
                if ($found = $this->mKerma->delete($ID)) {
                    return $this->respondDeleted($found);
                }
                return $this->fail('Data Gagal Dihapus');
                break;
            default:
                return $this->fail('Data model belum dibuat');
                break;
                // $found =   db_connect()->table($Table)->delete(['KermaID' => $ID]);
        }
    }
}
