<?php

namespace App\Libraries;

class Library
{

    function loadPdf()
    {
        require_once(APPPATH . 'ThirdParty/fpdf/fancyrow.php');
    }

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
                $query =  db_connect()->query("SELECT * FROM " . $Table . " WHERE NA='N' AND DDeleted IS NULL ORDER BY '" . $Nama . "'");
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

    function OptCreate($Key, $Name, $Selected)
    {

        $data = '';

        $Jumlah = count($Key);

        if ($Jumlah > 0) {

            for ($i = 0; $i < $Jumlah; $i++) {

                $selected = $Key[$i] == $Selected ? "selected" : "";

                $data .= '<option value ="' . $Key[$i] . '" ' . $selected . '>' . $Name[$i] . '</option>';
            }
        } else {

            $data .= '<option =""></option>';
        }

        return $data;
    }

    function GetField($Table, $Primary, $Key, $Field)
    {

        $query = db_connect()->query("SELECT $Field as Hasil FROM $Table WHERE $Primary = '$Key'");
        if ($query->getNumRows() > 0) {
            $sql = $query->getRow();
            return $sql->Hasil;
        }
    }
}
