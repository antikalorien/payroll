<?php

namespace App\Http\Controllers;

use App\departemen_sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class c_master_subDepartemen extends Controller
{
    public function index() {
        return view('dashboard.master-data.sub-departemen.baru');
    }

    public function list() {
        return view('dashboard.master-data.sub-departemen.list');
    }

    public function listData() {
        $data['data'] = DB::table('departemen_sub')
        ->select('departemen_sub.id as id',
        'departemen.departemen as departemen',
        'departemen_sub.id_subDepartemen as id_subDepartemen',
        'departemen_sub.sub_departemen as sub_departemen',
        'departemen_sub.isDell as status',
        'departemen_sub.updated_at as updatedAt')
        ->join('departemen','departemen.id_dept','departemen_sub.id_departemen')
        ->orderBy('departemen.departemen','asc')
        ->get();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('departemen_sub')
        ->select('departemen_sub.id as id',
        'departemen.id_dept as id_dept',
        'departemen.departemen as departemen',
        'departemen_sub.id_departemen as id_departemen',
        'departemen_sub.id_subDepartemen as id_subDepartemen',
        'departemen_sub.sub_departemen as sub_departemen')
        ->join('departemen','departemen.id_dept','departemen_sub.id_departemen')
        ->where('departemen_sub.id','=',$id)
        ->first();
        return view('dashboard.master-data.sub-departemen.edit')->with('data',$data);
    }

    public function submit(Request $request) {
        $type = $request->type;
        $departemen = $request->departemen;
        $idSubDepartemen = $request->idSubDepartemen;
        $subDepartemen = $request->subDepartemen;
     
        try {
            DB::beginTransaction();
            if ($type == 'baru') {
                $dpt = new departemen_sub();
                $dpt->id_departemen = $departemen;
                $dpt->id_subDepartemen = $idSubDepartemen; 
                $dpt->sub_departemen = $subDepartemen; 
                $dpt->isDell = 1; 
                $dpt->save();
            } elseif ($type == 'edit') {
                DB::table('departemen_sub')
                    ->where('id','=',$request->id)
                    ->update([
                        'id_departemen' => $departemen,
                        'id_subDepartemen' => $idSubDepartemen,
                        'sub_departemen' => $subDepartemen,
                    ]);
            }
            DB::commit();
            
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
