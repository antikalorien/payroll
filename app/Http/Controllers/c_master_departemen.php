<?php

namespace App\Http\Controllers;

use App\departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class c_master_departemen extends Controller
{
    public function index() {
        return view('dashboard.master-data.departemen.baru');
    }

    public function list() {
        return view('dashboard.master-data.departemen.list');
    }

    public function listData() {
        $data['data'] = departemen::all();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('departemen')->where('id','=',$id)->first();
        return view('dashboard.master-data.departemen.edit')->with('data',$data);
    }

    public function submit(Request $request) {
        $type = $request->type;
        $idDepartemen = $request->idDepartemen;
        $departemen = $request->departemen;
     
        try {
            DB::beginTransaction();
            if ($type == 'baru') {
                $dpt = new departemen();
                $dpt->id_dept = $idDepartemen;
                $dpt->departemen = $departemen; 
                $dpt->isDell = '1'; 
                $dpt->save();
            } elseif ($type == 'edit') {
                DB::table('departemen')
                    ->where('id','=',$request->id)
                    ->update([
                        'departemen' => $departemen
                    ]);
            }
            DB::commit();
            
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($request);
        }
    }
}
