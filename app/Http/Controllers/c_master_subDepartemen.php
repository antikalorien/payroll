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
        $idDepartemen = $request->departemen;
        $idSubDepartemen = $request->idSubDepartemen;
        $subDepartemen = $request->subDepartemen;
     
        try {
            DB::beginTransaction();
                $request['id_departemen'] = $idDepartemen;
                $request['id_subDepartemen'] = $idSubDepartemen;
                $request['sub_departemen'] = $subDepartemen;
                
            if ($type == 'baru') {
                $result['insert_subDepartemen'] = $this->insertSubDepartemen($request);
            } elseif ($type == 'edit') {
                $request['id'] = $request->id;
                $result['update_subDepartemen'] = $this->updateSubDepartemen($request);
            }
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function insertSubDepartemen($request)
    {
        $idDepartemen = $request['id_departemen'];
        $idSubDepartemen = $request['id_subDepartemen'];
        $subDepartemen = $request['sub_departemen'];
        try
        {
            $data_ = DB::table('departemen_sub')
            ->select('id')
            ->where('id_departemen',$idDepartemen)
            ->where('id_subDepartemen',$idSubDepartemen)
            ->where('sub_departemen',$subDepartemen);
            if($data_->exists())
            {
                return null;
            }
            else
            {
                $dpt = new departemen_sub();
                $dpt->id_departemen = $idDepartemen;
                $dpt->id_subDepartemen = $idSubDepartemen; 
                $dpt->sub_departemen = $subDepartemen; 
                $dpt->isDell = 1; 
                $dpt->save();
                return 'success';
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function updateSubDepartemen($request)
    {
        $id = $request['id'];
        $idDepartemen = $request['id_departemen'];
        $idSubDepartemen = $request['id_subDepartemen'];
        $subDepartemen = $request['sub_departemen'];
        try
        {
            $data_ = DB::table('departemen_sub')
            ->select('id')
            ->where('id',$id);
            if($data_->exists())
            {
                DB::table('departemen_sub')
                ->where('id','=',$id)
                ->update([
                    'id_departemen' => $idDepartemen,
                    'id_subDepartemen' => $idSubDepartemen,
                    'sub_departemen' => $subDepartemen,
                ]);
                return 'success';
            }
            else
            {
                return null;
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function deleteSubDepartemen($request)
    {
        $idDepartemen = $request['id_departemen'];
        $idSubDepartemen = $request['id_subDepartemen'];
        try
        {
            if($idDepartemen!='')
            {
                // delete by idDepartemen
                DB::table('departemen_sub')
                ->where('id_departemen',$idDepartemen)
                ->delete(); 
            }
            if($idSubDepartemen !='')
            {
                // delete by idSubDepartemen
                DB::table('departemen_sub')
                ->where('id_subDepartemen',$idSubDepartemen)
                ->delete(); 

            }
            if($idDepartemen =='' && $idSubDepartemen =='')
            {
                // delete all sub Departemen
                DB::table('departemen_sub')
                ->delete(); 
            }
            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
