<?php

namespace App\Http\Controllers;

use App\group_sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class c_Sys_GroupSub extends Controller
{
    public function index() {
        return view('dashboard.system-utility.group-sub.baru');
    }

    public function list() {
        return view('dashboard.system-utility.group-sub.list');
    }

    public function listData() {
        $data['data']= DB::table('group_sub')
        ->select('group_sub.id as id','group_sub.ord as ord','group_sub.id_sub_group as idSubGroup','group_sub.sub_group as subGroup','group_sub.isDell as status','group_sub.updated_at as updatedAt')
        ->get();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('group_sub')
        ->select('group_sub.id as id','group_sub.ord as ord','group_sub.id_sub_group as idSubGroup','group_sub.sub_group as subGroup','group_sub.isDell as isDell')
        ->where('group_sub.id_sub_group','=',$id)
        ->first();

        return view('dashboard.system-utility.group-sub.edit')->with('data',$data)->with('group',$data);
    }

    public function submit(Request $request) {
        $userLogin = request()->session()->get('username');

        $type = $request->type;
        $ord = $request->ord;
        $sub_group = $request->sub_group;
      
        try {
            DB::beginTransaction();

            if ($type == 'baru') {
                $id_sub_group = IdGenerator::generate(['table' => 'group_sub', 'field' => 'id_sub_group', 'length' => 6, 'prefix' => 'GS-']);
                $val = new group_sub();
                $val->ord = $ord;
                $val->id_sub_group = $id_sub_group;
                $val->sub_group = $sub_group;
                // 2= disable, 1=acive
                $val->isDell=1;
                $val->save();
          
                $_keterangan = 'Menambahkan Group Sub Baru -- ID Group Sub : '.$id_sub_group .' Nama Group Sub : ' . $sub_group;
                // insert history
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group Sub';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;
            

            } elseif ($type == 'edit') {
                DB::table('group_sub')
                    ->where('id_sub_group','=',$request->id_sub_group)
                    ->update([            
                        'ord'=>$ord,        
                        'sub_group' => $sub_group,
                    ]);

                $_keterangan = 'Update Group Sub -- ID Group Sub : '.$request->id_sub_group .' Nama Group Sub : ' . $sub_group . ' Ord : '. $ord;
                // insert history
                $_requestValue['tipe'] = 1;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group Sub';
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
        $idSubGroup = $request->id_sub_group;

        try {
            DB::beginTransaction();

            DB::table('group_sub')
            ->where('id_sub_group','=',$idSubGroup)
            ->update([                    
                'isDell' => 2,
            ]);

            $_keterangan = 'Disable Group Sub -- ID Group Sub : '.$idSubGroup;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group Sub';
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

            DB::table('group_sub')
            ->where('id_sub_group','=',$idSubGroup)
            ->update([                    
                'isDell' => 1,
            ]);

            
            $_keterangan = 'Active Group Sub -- ID Group Sub : '.$idSubGroup;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group Sub';
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
