<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class c_penggajian_dataPenggajian extends Controller
 {
    public function index()
 {
        return view( 'dashboard.penggajian.data-penggajian.main' );
    }

    public function absensiList()
 {
        return view( 'dashboard.penggajian.data-penggajian.absensi' );
    }

    public function lemburList()
 {
        return view( 'dashboard.penggajian.data-penggajian.lembur' );
    }

    public function bpjsList()
 {
        return view( 'dashboard.penggajian.data-penggajian.bpjs' );
    }

    public function payCheckList()
 {
        return view( 'dashboard.penggajian.data-penggajian.paycheck' );
    }
}