<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\c_classPenggajian;

class c_Overview_informasiPenggajian extends Controller
{
    public function index($tipe) {
    
        if($tipe=='total-karyawan-all-periode')
        {
            return view('dashboard.overview.status-informasiPenggajian.total-karyawan');
        }
        elseif($tipe=='total-karyawan-skema-normal')
        {
            return view('dashboard.overview.status-informasiPenggajian.skema-gaji-normal');
        }
        elseif($tipe=='total-karyawan-skema-setengah')
        {
            return view('dashboard.overview.status-informasiPenggajian.skema-gaji-setengah');
        }
        elseif($tipe=='total-karyawan-skema-harian')
        {
            return view('dashboard.overview.status-informasiPenggajian.skema-gaji-harian');
        }
        elseif($tipe=='total-karyawan-tidakTerdaftar')
        {
            return view('dashboard.overview.status-informasiPenggajian.total-karyawan-tidakTerdaftar');
        }
    }

    public function listData($tipe) {
        try {
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getPeriodeBerjalan(); 
            if( is_null($_val))
            {
                return 'nothing periode';
            }
            else
            {
                // get Data
                $idPeriode = $_val->idPeriode;
                $_data = DB::table('gaji_karyawan')
                ->select(
                'users.id as id',
                'gaji_karyawan.reff_paycheck as reffPaycheck',
                'departemen.departemen as id_departemen',
                'departemen_sub.sub_departemen as subDepartemen',
                'users.pos as pos',
                'users.grade as grade',
                'users.doj as doj',
                'gaji_karyawan.id_karyawan as id_absen',
                'gaji_karyawan.nik as username',
                'users.name as name',
                'gaji_karyawan.tipe_kontrak as tieKontrak',
                'gaji_karyawan.masa_kerja as masaKerja',
                'gaji_karyawan.usia as usia',
                'users.no_rekening as noRekening',
                'users.tipe_bpjs as tipeBpjs')
                ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
                ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
                ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub');

                if($tipe=='karyawan-all-periode')
                {
                    $_data->where('gaji_karyawan.id_periode',$idPeriode);
                }
                elseif($tipe=='karyawan-skema-normal')
                {
                   
                    $_data->where('gaji_karyawan.id_periode',$idPeriode);
                    $_data->where('gaji_karyawan.skema_gaji','1');
                }
                elseif($tipe=='karyawan-skema-harian')
                {
                    $_data->where('gaji_karyawan.id_periode',$idPeriode);
                    $_data->where('gaji_karyawan.skema_gaji','2');
                }
                elseif($tipe=='karyawan-skema-setengah')
                {
                   
                    $_data->where('gaji_karyawan.id_periode',$idPeriode);
                    $_data->where('gaji_karyawan.skema_gaji','3');
                }
                elseif($tipe=='karyawan-tidakTerdaftar')
                {
                    $karyawan = DB::table('gaji_karyawan')
                    ->select('id_karyawan')
                    ->where('id_periode',$idPeriode)
                    ->get()->pluck('id_karyawan')->toArray();

                    $_data = DB::table('users')
                    ->select('users.id as id',
                    'departemen.departemen as id_departemen',
                    'departemen_sub.sub_departemen as subDepartemen',
                    'users.pos as pos',
                    'users.grade as grade',
                    'users.id_absen as id_absen','users.username as username',
                    'users.name as name',
                    'users.tipe_kontrak as tieKontrak',
                    'users.system as system',
                    'skema_hari_kerja.skema as id_skema_hari_kerja',
                    'skema_hari_kerja.jml_hari as jml_hari',
                    'skema_hari_kerja.jam_kerja as jam_kerja',
                    'users.doj as doj',
                    'users.masa_kerja as masaKerja',
                    'users.dob as dob',
                    'users.usia as usia',
                    'users.status as status')
                    ->join('departemen','departemen.id_dept','=','users.id_departemen')
                    ->join('departemen_sub','departemen_sub.id_subDepartemen','=','users.id_departemen_sub')
                    ->join('skema_hari_kerja','skema_hari_kerja.id_skema','=','users.id_skema_hari_kerja') 
                    ->where('users.status','=','1')
                    ->whereNotIn('users.id_absen',$karyawan)
                    ->orderBy('users.username','asc');
                }
                $data['data'] = $_data->get();
            }
            return json_encode($data);
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }
       
}