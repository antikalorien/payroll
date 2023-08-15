<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class c_classPeriode extends Controller
{
    public function updateStatusPeriode($_idPeriode,$_idModule,$_pic)
    {
        try {
            // Update Module
            DB::table('gaji_periode_status')
            ->where('id_periode',$_idPeriode)
            ->where('id_status_gaji',$_idModule)
            ->update([
                'status' => 1,
                'reff' => $_pic,
            ]);
            $result='success';
            return $result;
           } catch (\Exception $ex) {
                // insert history
                $_keterangan = 'Error--updateStatusPeriode--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Periode';
                $_requestValue['module'] = 'Class Periode';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $_pic;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
               return response()->json($ex);
           }
    }

    public function lockStatusPeriode($_idPeriode,$_pic)
    {
        try {
            // Update Status All Module
            DB::table('gaji_periode_status')
            ->where('id_periode',$_idPeriode)
            ->update([
                'status' => 1,
                'pic' => $_pic,
            ]);
            // Update Table gaji_periode
            DB::table('gaji_periode')
            ->where('id_periode',$_idPeriode)
            ->update([
                'pic' => $_pic,
            ]);
            // Update Table gaji_periode
            DB::table('gaji_karyawan')
            ->where('id_periode',$_idPeriode)
            ->update([
                'reff_closing' => $_pic,
            ]);
            $result='success';
            return $result;
           } catch (\Exception $ex) {
                 // insert history
                 $_keterangan = 'Error--updatePeriode--'.$ex;
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Periode';
                 $_requestValue['module'] = 'Class Periode';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $_pic;
 
                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
               return response()->json($ex);
           }
    }
}
