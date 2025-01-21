<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class c_master_dataMaster extends Controller
 {
    public function index()
 {
        return view( 'dashboard.master-data.data-master.main' );
    }

    public function gradeList()
 {
        return view( 'dashboard.master-data.data-master.grade' );
    }

    public function userManagementList()
 {
        return view( 'dashboard.master-data.data-master.user-management' );
    }

    public function upahMasterList()
 {
        return view( 'dashboard.master-data.data-master.upah' );
    }

    public function hutangMasterList()
 {
        return view( 'dashboard.master-data.data-master.hutang' );
    }
}