<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// model
use App\Exports\export_penggajianPaycheckAllData;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class c_laporan_analisaBpjs extends Controller
{
    public function index() {
        return view('dashboard.laporan.analisa-bpjs.baru');
    }

    public function data($idPeriode) {
        if($idPeriode=='99')
        {
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getLastPeriode(); 
            if( is_null($_val))
            {
            // nothing
            }
            else
            {
                // get Last Periode
                $periode = $_val;
                $idPeriode=$periode->idPeriode;
            }
        }

        $data['data'] =  DB::table('gaji_karyawan')
        ->select(
        'users.id as id',
        'departemen.departemen as id_departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'users.grade as grade',
        'users.doj as doj',
        'gaji_karyawan.id_karyawan as id_absen',
        'gaji_karyawan.nik as username',
        'users.name as name',
        'users.tipe_bpjs as tipeBpjs',
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKes"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTk"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJp"),

         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-017' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKesPerusahaan"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-013' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTkPerusahaan"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-015' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJpPerusahaan"),
         'gaji_karyawan.updated_at as updatedAt')
         
         ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
         ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
         ->where('gaji_karyawan.id_periode',$idPeriode)
         ->get();

         $data['total'] = DB::table('gaji_karyawan_sub_variable')
         ->select(
            'gaji_karyawan_sub_variable.id_karyawan as idKaryawan',

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsTk"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsJp"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsKesehatan"),

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-013' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsTkPerusahaan"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-015' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsJpPerusahaan"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-017' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsKesPerusahaan"),

         )
         ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
         ->groupBy('gaji_karyawan_sub_variable.id_karyawan')
         ->first();

         $data['idPeriode'] = $idPeriode;
      
        return json_encode($data);
    }

    public function actionExport($_typeActionData,$_idData) {
        $userLogin = request()->session()->get('username');
        try {
            DB::beginTransaction();  
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getPeriodeBerjalan(); 
            if( is_null($_val))
            {
            // nothing
            }
            else
            {
                // get Data Periode
                $periode = $_val;
                $idPeriode = $periode->idPeriode;
            }
            return Excel::download(new export_penggajianPaycheckAllData($idPeriode,$_typeActionData,$_idData), 'Laporan-BPJS-'.$_typeActionData.'-'.$periode->periode.'.xlsx');
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function exportUpahKaryawanGajiSelected($idKaryawan) {
    try {
       // get ID Periode
       $dtPeriode = DB::table('gaji_periode')
       ->select('gaji_periode.id_periode as idPeriode', 'gaji_periode.periode as periode')
       ->where('gaji_periode.reff','-')
       ->first();
        $idPeriode = $dtPeriode->idPeriode;

                $trn['groupKonponenGaji'] = DB::table('group_sub')
                ->select(
                    'group_sub.id_sub_group as idSubGroup',
                    'group_sub.sub_group as sub_group')
                    ->orderBy('group_sub.id_sub_group','asc')
                    ->where('isDell','1')
                    ->get();

                    // get data
                    $trn['komponenGaji'] = DB::table('grouping_sub_variable')
                    ->select(
                    'grouping_sub_variable.id_sub_group as idSubGroup',
                    'grouping_sub_variable.id_variable as id_variable',
                    'grouping_sub_variable.variable as variable')
                    ->orderBy('grouping_sub_variable.id_variable','asc')
                    ->where('isDell','1')
                    ->get();
                 
                   // get karyawan
                    $trn['karyawan'] = DB::table('gaji_karyawan')
                    ->select(
                    'gaji_periode.periode as periode',
                    'gaji_karyawan.nik as nik',
                    'users.name as nama',
                    'departemen.departemen as departemen',
                    'departemen_sub.sub_departemen as subDepartemen',
                    'users.pos as jabatan',
                    'gaji_karyawan.no_rekening as noRekening',
                    'gaji_karyawan.thp as thp')
                    ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
                    ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
                    ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
                    ->join('gaji_periode','gaji_periode.id_periode','gaji_karyawan.id_periode')
                    ->where('users.username',$idKaryawan)
                    ->where('gaji_karyawan.id_periode',$idPeriode)
                    ->get();
          
                   // get data
                   $trn['karyawan_gaji'] = DB::table('gaji_karyawan_sub_variable')
                   ->select('gaji_karyawan_sub_variable.id_karyawan as id_karyawan',
                  'gaji_karyawan_sub_variable.id_variable as id_variable',
                  'grouping_sub_variable.variable as variable',
                  'gaji_karyawan_sub_variable.nominal as nominal')
                   ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
                   ->join('users','users.id_absen','gaji_karyawan_sub_variable.id_karyawan')
                   ->where('users.username',$idKaryawan)
                   ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
                   ->orderBy('users.username','asc')
                   ->orderBy('gaji_karyawan_sub_variable.id_variable','asc')
                   ->get();
         
        $pdf = PDF::loadView('dashboard.penggajian.paycheck.slipgaji_paycheck',$trn)->setPaper('b4','portrait');
        return $pdf->stream($idKaryawan.'.pdf');
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }
}
