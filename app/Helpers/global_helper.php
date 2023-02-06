<?php

function createDir($path)
{
    if (!file_exists($path)) {
        $old_mask = umask(0);
        mkdir($path, 0777, true);
        umask($old_mask);
    }
}

function tanggalIndo($date = '', $j = '', $format = '')
{
    $tgl_indo = '';
    if ($date != '' and $date != '0000-00-00') {

        $th = substr($date, 0, 4);
        $bl = substr($date, 5, 2);
        switch ($bl) {
            case '1':
                $nb  = 'Januari';
                $nb2 = 'Jan';
                break;
            case '2':
                $nb  = 'Februari';
                $nb2 = 'Feb';
                break;
            case '3':
                $nb  = 'Maret';
                $nb2 = 'Mar';
                break;
            case '4':
                $nb  = 'April';
                $nb2 = 'Apr';
                break;
            case '5':
                $nb  = 'Mei';
                $nb2 = 'Mei';
                break;
            case '6':
                $nb  = 'Juni';
                $nb2 = 'Jun';
                break;
            case '7':
                $nb  = 'Juli';
                $nb2 = 'Jul';
                break;
            case '8':
                $nb  = 'Agustus';
                $nb2 = 'Agus';
                break;
            case '9':
                $nb  = 'September';
                $nb2 = 'Sept';
                break;
            case '10':
                $nb  = 'Oktober';
                $nb2 = 'Okt';
                break;
            case '11':
                $nb  = 'November';
                $nb2 = 'Nov';
                break;
            case '12':
                $nb  = 'Desember';
                $nb2 = 'Des';
                break;
            default:
                $nb  = '-';
                $nb2 = '-';
                break;
        }
        $tgl      = substr($date, 8, 2);
        $jam      = substr($date, 11, 8);
        $tgl_indo = $tgl . ' ' . $nb . ' ' . $th . ' ' . $jam;
        if ($j != '') {
            $tgl_indo = $tgl . ' ' . $nb2 . ' ' . $th . ' ' . $jam;
        }
    }

    return $tgl_indo;
}
