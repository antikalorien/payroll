<?php

namespace App\Http\Controllers;

use App\grouping_sub_variable_bpjs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class c_Sys_GroupinSubVariableBpjs extends Controller
{
    public function index() {
        return view('dashboard.system-utility.grouping-sub-variable-bpjs.baru');
    }

    public function list() {
        return view('dashboard.system-utility.grouping-sub-variable-bpjs.list');
    }

    public function listData() {
        $data['data']= DB::table('grouping_sub_variable_bpjs')
        ->select('grouping_sub_variable_bpjs.id as id',
        'grouping_sub_variable_bpjs.id_variable_bpjs as idVariableBpjs',
        'grouping_sub_variable_bpjs.id_bpjs as idBpjs',
        'grouping_sub_variable_bpjs.bpjs as bpjs',
        'grouping_sub_variable_bpjs.id_variable as idVariable',
        'grouping_sub_variable_bpjs.variable as variable',
        'grouping_sub_variable_bpjs.tipe_potongan as tipePotongan',
        'grouping_sub_variable_bpjs.tot_presentase as totPresentase',
        'grouping_sub_variable_bpjs.presentase as presentase',
        'grouping_sub_variable_bpjs.max_value as maxValue',
        'grouping_sub_variable_bpjs.max_value_nominal as maxValueNominal',
        'grouping_sub_variable_bpjs.nominal as nominal',
        'grouping_sub_variable_bpjs.isDell as status',
        'grouping_sub_variable_bpjs.updated_at as updatedAt'
        )
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
