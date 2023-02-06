<?php

namespace App\Models;

use CodeIgniter\Model;

class Models extends Model
{
    function Option($Table, $Primary, $Selected, $Nama, $where = '')
    {

        if ($Nama != "") {
            $Nama = $Nama;
        } else {
            $Nama = "Nama";
        }
        $data = "";

        switch ($Table) {
            case 'value':
                # code...
                break;

            default:
                $query =  db_connect()->query("SELECT * FROM '" . $Table . "' WHERE=NA='N' ORDER BY '" . $Nama . "'");
                break;
        }

        foreach ($query->getResultArray() as $fetch) {

            if ($Selected == $fetch[$Primary]) {
                $sel = "selected";
            } else {
                $sel = "";
            }

            if ($Nama != "") {
                $Nama = $Nama;
            } else {
                $Nama = "Nama";
            }

            $data .= '<option value="' . $fetch[$Primary] . '" ' . $sel . '>' . $fetch[$Nama] . '</option>';
        }

        return $data;
    }
}
