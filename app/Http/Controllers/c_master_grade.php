<?php

namespace App\Http\Controllers;

use App\grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class c_master_grade extends Controller
{
    public function index() {
        return view('dashboard.master-data.grade.baru');
    }

    public function list() {
        return view('dashboard.master-data.grade.list');
    }

    public function listData() {
        $data['data'] = grade::all();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('grade')->where('id','=',$id)->first();
        return view('dashboard.master-data.grade.edit')->with('data',$data);
    }

    public function submit(Request $request) {
        $type = $request->type;
        $level = $request->level;
        $nominalTnjTransport = $request->nominalTnjTransport;
        $intervalBln = $request->intervalBulan;
  
        try {
            DB::beginTransaction();
            if ($type == 'baru') {
                $idGrade = IdGenerator::generate(['table' => 'grade', 'field' => 'id_grade', 'length' => 6, 'prefix' => 'LV-']);
                
                $data = new grade();
                $data->id_grade = $idGrade;
                $data->level = $level; 
                $data->nominal_tnj_transport = $nominalTnjTransport; 
                $data->interval_bln = $intervalBln; 
                $data->isDell = '1'; 
              
                $data->save();
            } elseif ($type == 'edit') {
                DB::table('grade')
                    ->where('id_grade','=',$request->idGrade)
                    ->update([
                        'level' => $level,
                        'nominal_tnj_transport' => $nominalTnjTransport,
                        'interval_bln' => $intervalBln
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
