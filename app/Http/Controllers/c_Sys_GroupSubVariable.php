<?php

namespace App\Http\Controllers;

use App\group_sub_variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class c_Sys_GroupSubVariable extends Controller
{
    public function index() {
        return view('dashboard.system-utility.group-sub-variable.baru');
    }

    public function list() {
        return view('dashboard.system-utility.group-sub-variable.list');
    }

    public function listData() {
        $data['data']= DB::table('group_sub_variable')
        ->select('group_sub_variable.id as id','group_sub_variable.ord as ord','group_sub_variable.id_variable as idVariable','group_sub_variable.variable as variable','group_sub_variable.isDell as status','group_sub_variable.updated_at as updatedAt')
        ->get();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('group_sub_variable')
        ->select('group_sub_variable.id as id','group_sub_variable.ord as ord','group_sub_variable.id_variable as idVariable','group_sub_variable.variable as variable','group_sub_variable.isDell as status')
        ->where('group_sub_variable.id_variable','=',$id)
        ->first();

        return view('dashboard.system-utility.group-sub-variable.edit')->with('data',$data)->with('group',$data);
    }

    public function submit(Request $request) {
        $userLogin = request()->session()->get('username');

        $type = $request->type;
        $ord = $request->ord;
        $variable = $request->variable;
        
      
        try {
            DB::beginTransaction();

            if ($type == 'baru') {
                $id_variable = IdGenerator::generate(['table' => 'group_sub_variable', 'field' => 'id_variable', 'length' => 6, 'prefix' => 'VR-']);
                $val = new group_sub_variable();
                $val->ord = $ord;
                $val->id_variable = $id_variable;
                $val->variable = $variable;
                // 2= disable, 1=acive
                $val->isDell=1;
                $val->save();

                $_keterangan = 'Menambahkan Group Sub Variable Baru -- ID Variable : '.$id_variable .' Nama Variable : ' . $variable;
                // insert history
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group Sub Variable';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

            } elseif ($type == 'edit') {
                DB::table('group_sub_variable')
                    ->where('id_variable','=',$request->id_variable)
                    ->update([            
                        'ord'=>$ord,        
                        'variable' => $variable,
                    ]);
                
                $_keterangan = 'Update Group Sub Variable-- ID Variable : '.$request->id_variable .' Nama Variable : ' . $variable . ' Ord : '. $ord;
                // insert history
                $_requestValue['tipe'] = 1;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group Sub Variable';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;
            }
            
            $c_class = new c_classHistory;
            $c_class = $c_class->insertHistory($_requestValue);

            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function disable(Request $request) {
        $userLogin = request()->session()->get('username');
        $idVariable = $request->id_variable;

        try {
            DB::beginTransaction();

            DB::table('group_sub_variable')
            ->where('id_variable','=',$idVariable)
            ->update([                    
                'isDell' => 2,
            ]);
      
            $_keterangan = 'Disable Group Sub Variable-- ID Variable : '.$idVariable;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group Sub Variable';
            $_requestValue['keterangan'] = $_keterangan;
            $_requestValue['pic'] = $userLogin;

            $c_class = new c_classHistory;
            $c_class = $c_class->insertHistory($_requestValue);

            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function activate(Request $request) {
        $userLogin = request()->session()->get('username');
        $idSubGroup = $request->id_sub_group;
       
        try {
            DB::beginTransaction();

            DB::table('group_sub_variable')
            ->where('id_variable','=',$idSubGroup)
            ->update([                    
                'isDell' => 1,
            ]);

            $_keterangan = 'Active Group Sub Variable-- ID Variable : '.$idSubGroup;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group Sub Variable';
            $_requestValue['keterangan'] = $_keterangan;
            $_requestValue['pic'] = $userLogin;

            $c_class = new c_classHistory;
            $c_class = $c_class->insertHistory($_requestValue);


            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

}
