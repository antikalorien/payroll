<?php

namespace App\Http\Controllers;

use App\sysActivityHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class c_SysActivityHistory extends Controller
{
    public function index() {
        return view('dashboard.system-utility.activity-history.baru');
    }

    public function list() {
        return view('dashboard.system-utility.activity-history.list');
    }

    public function listData() {
        $data['data'] =  DB::table('log_activity')
        ->orderBy('created_at','desc')
        ->limit(1000)
        ->get();
        return json_encode($data);
    }

}
