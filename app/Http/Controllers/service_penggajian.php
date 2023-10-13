<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class service_penggajian extends Controller
{
    public function getPenggajian(Request $request) {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        $username = $request->username;
        $password = $request->password;
        $idKaryawan = $request->id_karyawan;
        $idPeriode = $request->id_periode;
        try {
             $dtUser = DB::table('users')
             ->where('id_absen','=',$username)
             ->where('username','=',$idKaryawan)
             ->orderBy('id','desc');
                if ($dtUser->exists()) {
                    $user = $dtUser->first();
                    if (Crypt::decryptString($user->password) == $password) {

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
                        'gaji_karyawan.skema_gaji as skemaGaji',
                        'gaji_karyawan.thp as thp')
                        ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
                        ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
                        ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
                        ->join('gaji_periode','gaji_periode.id_periode','gaji_karyawan.id_periode')
                        ->where('gaji_karyawan.id_karyawan',$username)
                        ->where('gaji_karyawan.nik',$idKaryawan)
                        ->where('gaji_karyawan.id_periode',$idPeriode)
                        ->first();

                        // kehadiran
                        $trn['kehadiran_karyawan'] = DB::table('gaji_kehadiran_absensi')
                        ->select(
                            'gaji_kehadiran_absensi.tot_libur as totLibur',
                            'gaji_kehadiran_absensi.tot_ph as totPh',
                            'gaji_kehadiran_absensi.tot_izin as totIzin',
                            'gaji_kehadiran_absensi.tot_alfa as totAlfa',
                            'gaji_kehadiran_absensi.tot_sakit as totSakit',
                            'gaji_kehadiran_absensi.tot_cuti as totCuti',
                            'gaji_kehadiran_absensi.tot_masuk as totMasuk'
                        )
                        ->where('gaji_kehadiran_absensi.id_karyawan',$username)
                        ->where('gaji_kehadiran_absensi.id_periode',$idPeriode)
                        ->first();
            
                        // get data
                        $trn['karyawan_gaji'] = DB::table('gaji_karyawan_sub_variable')
                        ->select(
                        'grouping_sub_variable.variable as variable',
                        'gaji_karyawan_sub_variable.nominal as nominal','gaji_karyawan_sub_variable.keterangan as keterangan')
                        ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
                        ->where('gaji_karyawan_sub_variable.id_karyawan',$username)
                        ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
                        ->orderBy('gaji_karyawan_sub_variable.id_variable','asc')
                        ->get();

                        $result=response()->json([
                            'status' => 'success',
                            'message' => 'Get Data Payroll Successfuly',
                            'gajiku' => $trn
                        ]);
                      
                        } else {
                        $result = 'Password salah.';
                        }
                } else {
                    $result = 'Username / ID Karyawan tidak terdaftar.';
                }
                return $result;
                // return Crypt::encryptString($result);
                    
        } catch (\Exception $ex) {
            return $ex;
        }
    }   
}
