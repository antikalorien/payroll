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
            $request['id_departemen'] = $idDepartemen;
            $request['departemen'] = $departemen;
            
            if ($type == 'baru') {
                $result['insert_departemen'] = $this->insertDepartemen($request);
            } elseif ($type == 'edit') {
                $request['id'] = $request->id;
                $result['update_departemen'] = $this->updateDepartemen($request);
            }
            DB::commit();
            
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($request);
        }
    }

    public function insertDepartemen($request)
    {
        $idDepartemen = $request['id_departemen'];
        $departemen = $request['departemen'];
        try
        {
            $data_ = DB::table('departemen')
            ->select('id')
            ->where('id_dept',$idDepartemen)
            ->where('departemen',$departemen);
            if($data_->exists())
            {
                return null;
            }
            else
            {
                $dpt = new departemen();
                $dpt->id_dept = $idDepartemen;
                $dpt->departemen = $departemen; 
                $dpt->isDell = '1'; 
                $dpt->save();
                return 'success';
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function updateDepartemen($request)
    {
        $id = $request['id'];
        $departemen = $request['departemen'];
        try
        {
            $data_ = DB::table('departemen')
            ->select('id')
            ->where('id',$id);
            if($data_->exists())
            {
                DB::table('departemen')
                ->where('id','=',$request->id)
                ->update([
                    'departemen' => $departemen
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

    public function deleteDepartemen($request)
    {
        $idDepartemen = $request['id_departemen'];
        try
        {
            if($idDepartemen!='')
            {
                // delete by idDepartemen
                DB::table('departemen')
                ->where('id_dept',$idDepartemen)
                ->delete(); 
            }
            if($idDepartemen =='')
            {
                // delete all departemen
                DB::table('departemen')
                ->delete(); 
            }
            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}
