<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class c_Overview_informasiKaryawan extends Controller
{
    public function index($tipe) {
        if($tipe=='total-karyawan-aktif')
        {
            return view('dashboard.overview.status-informasiKaryawan.total-karyawan-aktif');
        }
        elseif($tipe=='total-karyawan-nonAktif')
        {
            return view('dashboard.overview.status-informasiKaryawan.total-karyawan-nonAktif');
        }
    }

    public function listData($tipe) {
        try {
            if($tipe=='karyawan-aktif')
            {
                $data['data'] =  DB::table('users')
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
                 ->orderBy('users.username','asc')
                ->get();
            }
            elseif($tipe=='karyawan-nonAktif')
            {
                $data['data'] =  DB::table('users')
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
                 ->where('users.status','=','2')
                 ->orderBy('users.username','asc')
                ->get();
            }
            return json_encode($data);
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }
       
}