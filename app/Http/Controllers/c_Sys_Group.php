<?php

namespace App\Http\Controllers;

use App\grup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class c_Sys_Group extends Controller
{
    public function index() {
        return view('dashboard.system-utility.groups.baru');
    }

    public function list() {
        return view('dashboard.system-utility.groups.list');
    }

    public function listData() {
        $data['data']= DB::table('grup')
        ->select('grup.id as id','grup.ord as ord','grup.id_group as idGroup','grup.group as group','grup.isDell as status','grup.updated_at as updatedAt')
        ->get();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('grup')
        ->select('grup.id as id','grup.ord as ord','grup.id_group as idGroup','grup.group as group','grup.isDell as isDell')
        ->where('grup.id_group','=',$id)
        ->first();

        return view('dashboard.system-utility.groups.edit')->with('data',$data)->with('group',$data);
    }

    public function submit(Request $request) {
        $userLogin = request()->session()->get('username');
        $type = $request->type;
        $group = $request->group;
        $ord = $request->ord;
      
        try {
            DB::beginTransaction();

            if ($type == 'baru') {
                $id_group = IdGenerator::generate(['table' => 'grup', 'field' => 'id_group', 'length' => 6, 'prefix' => 'GR-']);
                $val = new grup();
                $val->ord = $ord;
                $val->id_group = $id_group;
                $val->group = $group;
                // 2= disable, 1=acive
                $val->isDell=1;
                $val->save();

                $_keterangan = 'Menambahkan Group Baru -- ID Group : '.$id_group .' Nama Group : ' . $group;
                // insert history
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;
           
               

            } elseif ($type == 'edit') {
                DB::table('grup')
                    ->where('id_group','=',$request->id_group)
                    ->update([                    
                        'group' => $group,
                        'ord'=>$ord
                    ]);

                $_keterangan = 'Update Group -- ID Group : '.$request->id_group .' Nama Group : ' . $group . ' Ord : '. $ord;
                // insert history
                $_requestValue['tipe'] = 1;
                $_requestValue['menu'] ='System Utility';
                $_requestValue['module'] = 'Group';
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

        $_idGroup = $request->id_group;
        try {
            DB::beginTransaction();

            DB::table('grup')
            ->where('id_group','=',$request->id_group)
            ->update([                    
                'isDell' => 2,
            ]);

            $_keterangan = 'Disable Group -- ID Group : '.$_idGroup;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group';
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
        $_idGroup = $request->id_group;
       
        try {
            DB::beginTransaction();

            DB::table('grup')
            ->where('id_group','=',$request->id_group)
            ->update([                    
                'isDell' => 1,
            ]);

            $_keterangan = 'Active Group -- ID Group : '.$_idGroup;
            // insert history
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='System Utility';
            $_requestValue['module'] = 'Group';
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
