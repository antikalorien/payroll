<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class c_laporan_analisaPph extends Controller
{
    public function index() {
        return view('dashboard.laporan.analisa-pph21.baru');
    }

    public function data() {
         // get ID Periode
         $dtPeriode = DB::table('gaji_periode')
         ->select('gaji_periode.id_periode as idPeriode')
         ->where('gaji_periode.reff','-')
         ->first();
         $idPeriode = $dtPeriode->idPeriode;

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
        'gaji_karyawan.tipe_kontrak as tieKontrak',
        'gaji_karyawan.masa_kerja as masaKerja',
        'gaji_karyawan.usia as usia',
        'users.no_rekening as noRekening',
        'users.tipe_bpjs as tipeBpjs',
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-001' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as gajiPokok"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-002' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganJabatan"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-003' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKeahlian"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-004' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganTransport"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-005' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKomunikasi"),
         
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as lembur"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tambahanLainnya"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-010' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as alfa"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-011' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as ijin"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-012' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as potonganLainnya"),
         
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKes"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTk"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJp"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as simpananKoperasi"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as hutangKaryawan"),
         'gaji_karyawan.updated_at as updatedAt')
         
         ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
         ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
         ->where('gaji_karyawan.id_periode',$idPeriode)
         ->get();

         $data['total'] = DB::table('gaji_karyawan_sub_variable')
         ->select(
            'gaji_karyawan_sub_variable.id_karyawan as idKaryawan',
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-001'  and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotGajiPokok"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-002' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotJabatan"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-003' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotKeahlian"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-004' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotTransport"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-005' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotKomunikasi"),

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iLembur"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTambahanLainnya"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-010' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iAlfa"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-011' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iIjin"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-012' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iPotonganLainnya"),

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsKes"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsTk"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsJp"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotSimpananKoperasi"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotHutangKaryawan"),
         )
         ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
         ->groupBy('gaji_karyawan_sub_variable.id_karyawan')
         ->first();
      
        return json_encode($data);
    }

    public function exportUpahKaryawanGaji(){
        return Excel::download(new export_penggajianPaycheckAllData(), 'Penggajian-Paycheck-AllKaryawan.xlsx');
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
