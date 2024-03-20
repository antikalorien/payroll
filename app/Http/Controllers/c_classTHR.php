<?php

namespace App\Http\Controllers;

use App\karyawan_group;
use App\karyawan_group_sub;
use App\karyawan_group_sub_variable;
use App\karyawan_group_sub_variable_bpjs;
use App\gaji_lembur;
use App\gaji_karyawan;
use App\gaji_karyawan_sub_variable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

class c_classTHR extends Controller
{
    // get ID Periode
    public function getPeriodeBerjalan()
    {
        try
        {
            $dtPeriode = DB::table('gaji_thr_periode')
            ->select('gaji_thr_periode.id_periode as idPeriode',
            'gaji_thr_periode.periode as periode')
            ->where('gaji_thr_periode.pic','-')
            ->first();
           
            if( is_null($dtPeriode))
            {
                return $dtPeriode; 
            }
            else
            {
                return $dtPeriode; 
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    // deleteTHR
    public function deleteTHR($idPeriode,$_idKaryawan,$_id)
    {
        try
        {
            DB::table('gaji_thr')
            ->where('id',$_id)
            ->where('id_periode',$idPeriode)
            ->where('id_karyawan',$_idKaryawan)
            ->delete(); 

            DB::table('gaji_thr_variable')
            ->where('id_periode',$idPeriode)
            ->where('id_karyawan',$_idKaryawan)
            ->delete(); 
           
          return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

}
