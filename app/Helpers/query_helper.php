<?php

function querySelect($select = '*', $from = false, $where = false, $order_by = false, $limit = false, $db = 'default')
{
    $db = \Config\Database::connect($db);

    if ($from) {
        $builder =  $db->table($from);
        $builder->select($select);
        if ($where) {
            $builder->where($where);
        }
        if ($order_by) {
            $builder->orderBy($order_by);
        }
        if ($limit) {
            $builder->limit($limit);
        }
        $sql =  $builder->get();

        return $sql;
    }
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

function Option2($Table, $Primary, $Selected, $Nama, $where = '', $Order = 'ASC', $limit = '')
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
            $query =  db_connect('db_pegawai')->query("SELECT  a.*, Nama from $Table  as a $where order by $Primary $Order $limit");
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

function Option2Multiple($Table, $Primary, $Selected, $Nama, $where = '', $Order = 'ASC', $limit = '')
{

    $data = "";
    switch ($Table) {
        case 'kerma_ruang_lingkup':
            $query =  db_connect()->query("SELECT  * from $Table $where order by $Primary $Order $limit");
            break;

        default:
            $query =  db_connect('db_pegawai')->query("SELECT  a.*, Nama from $Table  as a $where order by $Primary $Order $limit");
            break;
    }
    $x = explode(",", $Selected);

    foreach ($query->getResultArray() as $fetch) {

        if (in_array($fetch[$Primary], $x)) {
            $sel = "selected";
        } else {
            $sel = "";
        }

        $data .= '<option value="' . $fetch[$Primary] . '" ' . $sel . '>' . $fetch[$Nama] . '</option>';
    }

    return $data;
}

function GetField($Table, $Primary, $Key, $Field, $db = 'default')
{

    $query = db_connect($db)->query("SELECT $Field as Hasil FROM $Table WHERE $Primary = '$Key'");
    if ($query->getNumRows() > 0) {
        $sql = $query->getRow();
        return $sql->Hasil;
    }
}
