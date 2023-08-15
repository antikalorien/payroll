<?php

namespace App\Http\Controllers;

use App\grouping_sub_variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class c_Sys_GroupingSubVariable extends Controller
{
    public function index() {
        return view('dashboard.system-utility.grouping-sub-variable.baru');
    }

    public function list() {
        return view('dashboard.system-utility.grouping-sub-variable.list');
    }

    public function spGroup(Request $request)
    {
        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('grup')
                ->select('id_group as id','group as text')
                ->where('group', 'like', '%' . $_GET['search'] . '%')
                ->where('isDell','<>','0')
                ->orderBy('group', 'asc')
                ->get();
        } else {
            $data['results'] = DB::table('grup')
                ->select('id_group as id', 'group as text')
                ->orderBy('group', 'asc')
                ->where('isDell','<>','0')
                ->get();
        }
        return $data;
    }

    public function spGroupSub(Request $request)
    {
        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('group_sub')
                ->select('id_sub_group as id','sub_group as text')
                ->where('sub_group', 'like', '%' . $_GET['search'] . '%')
                ->where('isDell','<>','0')
                ->orderBy('sub_group', 'asc')
                ->get();
        } else {
            $data['results'] = DB::table('group_sub')
                ->select('id_sub_group as id', 'sub_group as text')
                ->orderBy('sub_group', 'asc')
                ->where('isDell','<>','0')
                ->get();
        }
        return $data;
    }

    public function listDataVariable($idGroup,$idSubGroup) {
        $data['data']= DB::table('group_sub_variable')
        ->select('group_sub_variable.id as id','group_sub_variable.id_variable as idVariable',
        'group_sub_variable.variable as variable','group_sub_variable.isDell as status')
        ->get();

        return json_encode($data);
    }

    public function listData() {
        $data['data']= DB::table('grouping_sub_variable')
        ->select('grouping_sub_variable.id as id','grouping_sub_variable.id_grouping_sub_variable as idGroupingSubVariable','grouping_sub_variable.id_group as idGroup',
        'grouping_sub_variable.id_sub_group as idSubGroup','grouping_sub_variable.sub_group as subGroup','grouping_sub_variable.id_variable as idVariable',
        'grouping_sub_variable.variable as variable','grouping_sub_variable.isDell as status')
        ->get();

        return json_encode($data);
    }

    public function submit(Request $request) {
        $type = $request->type;
        $id_group = $request->id_group;
        $id_sub_group = $request->id_sub_group;
        $id_array = $request->id;
      
        try {
            DB::beginTransaction();
          
            foreach($id_array as $id_variable)
            {
                $id_grouping_sub_variable = IdGenerator::generate(['table' => 'grouping_sub_variable', 'field' => 'id_grouping_sub_variable', 'length' => 6, 'prefix' => 'GV-']);
                
                $dataSubGroup = DB::table('group_sub')
                ->select('sub_group')
                ->where('id_sub_group',$id_sub_group)
                ->first();

                $dataGroupSubVariable = DB::table('group_sub_variable')
                ->select('variable')
                ->where('id_variable',$id_variable)
                ->first();

                $val = new grouping_sub_variable();
                $val->id_grouping_sub_variable = $id_grouping_sub_variable;
                $val->id_group = $id_group;
                $val->id_sub_group = $id_sub_group;
                $val->sub_group = $dataSubGroup->sub_group;
                $val->id_variable = $id_variable;
                $val->variable = $dataGroupSubVariable->variable;
                // 0= disable, 1=acive
                $val->isDell=1;
                $val->save();
            }
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
