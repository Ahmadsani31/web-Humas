<?php

namespace App\Controllers;

use App\Libraries\Library;
use App\Models\Models;

class Modal extends BaseController
{
    protected  $Library;
    function __construct()
    {
        $this->Library = new Library();
        // $this->Models = new Models();
    }
    public function index()
    {
        $modal =   $this->request->uri->getSegment(2);
        // echo $modal;
        return view('modal/' . $modal);
    }
}
