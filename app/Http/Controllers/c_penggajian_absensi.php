<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use Session;
// use PDF;
use App\Http\Controllers\Controller;

// model
use App\gaji_kehadiran_absensi;
use App\kehadiran_absensi;
use App\Http\Controllers\c_classRumus;
use App\Http\Controllers\c_classHistory;

class c_penggajian_absensi extends Controller
{
    public function index() {
        return view('dashboard.penggajian.absensi-karyawan.baru');
    }

    public function list() {
        return view('dashboard.penggajian.absensi-karyawan.list');
    }

    public function GetPivotPeriode()
    {
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
       
                $c_calass = new c_classApi;
                $_val = $c_calass->getUrlApi(); 
                $_url= $_val.'GetPivotPeriode?idPeriode='.$periode->idPeriode;
                $response = Http::get($_url);
                $jsonData = $response->json();

             
                // delete data kehadiran Absensi
                DB::table('kehadiran_absensi')
                ->where('id_periode',$periode->idPeriode)
                ->delete();
          
                $totalKaryawan=0;
                foreach($jsonData as $x => $node)
                {
                        $gajiKehadiranAbsensi = new kehadiran_absensi();
                        $gajiKehadiranAbsensi->id_periode = $periode->idPeriode;
                        $gajiKehadiranAbsensi->id_karyawan = $node['idAbsen']; 
                        $gajiKehadiranAbsensi->id_departemen = $node['departemen']; 
                        $gajiKehadiranAbsensi->id_sub_departemen = $node['sub_departemen']; 
                        $gajiKehadiranAbsensi->id_skema = $node['skema']; 
                        $gajiKehadiranAbsensi->tot_hari = $node['tot_hari']; 
                        $gajiKehadiranAbsensi->tot_libur = $node['tot_libur']; 
                        $gajiKehadiranAbsensi->tot_ph = $node['tot_ph']; 
                        $gajiKehadiranAbsensi->tot_izin = $node['tot_izin']; 
                        $gajiKehadiranAbsensi->tot_alfa = $node['tot_alfa']; 
                        $gajiKehadiranAbsensi->tot_sakit = $node['tot_sakit']; 
                        $gajiKehadiranAbsensi->tot_cuti = $node['tot_cuti']; 
                        $gajiKehadiranAbsensi->tot_terlambat = $node['tot_terlambat']; 
                        $gajiKehadiranAbsensi->tot_terlambat_dgn_form = $node['tot_terlambat_dgn_form']; 
                        $gajiKehadiranAbsensi->tot_masuk = $node['tot_masuk'];                
                        $gajiKehadiranAbsensi->reff = $userLogin;     
                        $gajiKehadiranAbsensi->save();
                        $totalKaryawan++;
                }   

              // insert history
              $_keterangan = 'Syncronise Data Absensi ' . $periode->periode . ' ('.$periode->idPeriode.')'.'  Total Data Absensi Karyawan : '. $totalKaryawan;
    
              $_requestValue['tipe'] = 0;
              $_requestValue['menu'] ='Penggajian';
              $_requestValue['module'] = 'Absensi Karyawan';
              $_requestValue['keterangan'] = $_keterangan;
              $_requestValue['pic'] = $userLogin;

              $c_class = new c_classHistory;
              $c_class = $c_class->insertHistory($_requestValue);
            }

            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function data() {
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
           
            $data['data'] =  DB::table('kehadiran_absensi')
            ->select(
            'kehadiran_absensi.id as id',
            'kehadiran_absensi.id_periode as idPeriode',
            'departemen.departemen as departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'users.grade as grade',
            'kehadiran_absensi.id_karyawan as nik',
            'users.name as name',
            'users.tipe_kontrak as tipeKontrak',
            'kehadiran_absensi.id_skema as idSkema',
            'kehadiran_absensi.tot_hari as totHari',
            'kehadiran_absensi.tot_masuk as totMasuk',
            'kehadiran_absensi.tot_libur as totLibur',
            'kehadiran_absensi.tot_ph as totPh',
            'kehadiran_absensi.tot_izin as totIzin',
            'kehadiran_absensi.tot_alfa as totAlfa',
            'kehadiran_absensi.tot_sakit as totSakit',
            'kehadiran_absensi.tot_terlambat as totTerlambat',
            'kehadiran_absensi.tot_terlambat_dgn_form as totTerlambatDgnForm',
            'kehadiran_absensi.reff as reff',
            'kehadiran_absensi.updated_at as updatedAt')
            ->join('users','users.id_absen','=','kehadiran_absensi.id_karyawan')
            ->join('departemen','departemen.id_dept','=','kehadiran_absensi.id_departemen')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','kehadiran_absensi.id_sub_departemen')
            ->where('kehadiran_absensi.id_periode',$periode->idPeriode)
            ->orderBy('kehadiran_absensi.id_karyawan','asc')
            ->get();
       }

        return json_encode($data);
    }

    public function listData() {
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

            $data['data'] =  DB::table('gaji_kehadiran_absensi')
            ->select(
            'gaji_kehadiran_absensi.id as id',
            'gaji_kehadiran_absensi.id_periode as idPeriode',
            'departemen.departemen as departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'users.grade as grade',
            'gaji_kehadiran_absensi.id_karyawan as nik',
            'users.name as name',
            'users.tipe_kontrak as tipeKontrak',
            'skema_hari_kerja.skema as skema',
            'gaji_kehadiran_absensi.tot_hari as totHari',
            'gaji_kehadiran_absensi.upah_harian as upahHarian',
            'gaji_kehadiran_absensi.tot_masuk as totMasuk',
            'gaji_kehadiran_absensi.tot_libur as totLibur',
            DB::raw('(select nominal from gaji_karyawan_sub_variable where id_periode="'.$periode->idPeriode.'" and id_karyawan=gaji_kehadiran_absensi.id_karyawan and id_variable="VR-001" limit 1) as gajiPokok'),

            'gaji_kehadiran_absensi.tot_ph as totPh',
            'gaji_kehadiran_absensi.tot_izin as totIzin',
            'gaji_kehadiran_absensi.tot_alfa as totAlfa',
            'gaji_kehadiran_absensi.tot_sakit as totSakit',
            
            'gaji_kehadiran_absensi.reff as reff',
            'gaji_kehadiran_absensi.updated_at as updatedAt')
            ->join('users','users.id_absen','=','gaji_kehadiran_absensi.id_karyawan')
            ->join('gaji_karyawan','gaji_karyawan.id_karyawan','gaji_kehadiran_absensi.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
            ->join('skema_hari_kerja','skema_hari_kerja.id_skema','gaji_karyawan.id_skema_hari_kerja')
            ->where('gaji_kehadiran_absensi.id_periode',$periode->idPeriode)
            ->where('gaji_karyawan.id_periode',$periode->idPeriode)
            ->orderBy('gaji_kehadiran_absensi.id_karyawan','asc')
            ->get();
       }
        return json_encode($data);
    }

    public function submit(Request $request) {
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
                    // get kehadiran absensi
                    $dtKaryawanListGaji = DB::table('gaji_karyawan')
                    ->select('gaji_karyawan.id_karyawan as idKaryawan','skema_hari_kerja.jml_hari as jmlHari','gaji_karyawan.skema_gaji as skemaGaji')
                    ->join('skema_hari_kerja','skema_hari_kerja.id_skema','gaji_karyawan.id_skema_hari_kerja')
                    ->where('gaji_karyawan.id_periode',$idPeriode)
                    ->get();
                
              
                    foreach($dtKaryawanListGaji as $x)
                    {
                            $_idKaryawan=$x->idKaryawan;

                            // get rumus Harian =  (GAJI POKOK + TUNJ TETAP) / Skema hari kerja (21 atau 25)
                            $c_classPenggajian = new c_classPenggajian;

                            $_upahHarian = $c_classPenggajian->hitungGajiHarianKaryawan($x->idKaryawan,$x->jmlHari);
                        
                        
                            // get absensi
                            $_dtAbsensiHarian = DB::table('kehadiran_absensi')
                            ->select(
                            'kehadiran_absensi.id_karyawan as idKaryawan',
                            'kehadiran_absensi.tot_hari as tot_hari',
                            'kehadiran_absensi.tot_libur as tot_libur',
                            'kehadiran_absensi.tot_ph as tot_ph',
                            'kehadiran_absensi.tot_izin as tot_izin',
                            'kehadiran_absensi.tot_alfa as tot_alfa',
                            'kehadiran_absensi.tot_sakit as tot_sakit',
                            'kehadiran_absensi.tot_cuti as tot_cuti',
                            'kehadiran_absensi.tot_masuk as tot_masuk')
                            ->where('kehadiran_absensi.id_periode',$idPeriode)
                            ->where('kehadiran_absensi.id_karyawan',$x->idKaryawan);
                     
                            if ($_dtAbsensiHarian->doesntExist()) 
                            {
                                // dd('ID Karyawan : '. $x->idKaryawan .' Tidak Mempunyai Kehadiran Absensi Periode : '. $idPeriode);
                                // insert history
                                $_keterangan = 'Warning--ID Karyawan : '.$x->idKaryawan .' Tidak Mempunyai Kehadiran Absensi Periode : '. $idPeriode;
                        
                                $_requestValue['tipe'] = 0;
                                $_requestValue['menu'] ='Penggajian';
                                $_requestValue['module'] = 'Absensi Karyawan';
                                $_requestValue['keterangan'] = $_keterangan;
                                $_requestValue['pic'] = $userLogin;

                                $c_class = new c_classHistory;
                                $c_class = $c_class->insertHistory($_requestValue);                                                                                   
                            }
                            else
                            {
                              
                                $dtAbsensiHarian =  $_dtAbsensiHarian->first();
                                $dataListPeriodeJadwal = DB::table('gaji_kehadiran_absensi')
                                ->select('id')
                                ->where('id_periode',$idPeriode)
                                ->where('id_karyawan',$x->idKaryawan);
                          
                                if ($dataListPeriodeJadwal->doesntExist()) {  
                        
                                    $gajiKehadiranAbsensi = new gaji_kehadiran_absensi();
                                    $gajiKehadiranAbsensi->id_periode = $idPeriode;
                                    $gajiKehadiranAbsensi->id_karyawan = $x->idKaryawan;
                                  
                                    $gajiKehadiranAbsensi->tot_hari = $dtAbsensiHarian->tot_hari;
                                  
                                    $gajiKehadiranAbsensi->upah_harian = $_upahHarian;
                                    $gajiKehadiranAbsensi->tot_libur = $dtAbsensiHarian->tot_libur;
                                    $gajiKehadiranAbsensi->tot_ph = $dtAbsensiHarian->tot_ph;
                                    $gajiKehadiranAbsensi->tot_izin = $dtAbsensiHarian->tot_izin;
                                    $gajiKehadiranAbsensi->tot_alfa = $dtAbsensiHarian->tot_alfa;
                                    $gajiKehadiranAbsensi->tot_sakit = $dtAbsensiHarian->tot_sakit;
                                    $gajiKehadiranAbsensi->tot_cuti = $dtAbsensiHarian->tot_cuti;
                                    $gajiKehadiranAbsensi->tot_masuk = $dtAbsensiHarian->tot_masuk;
                                    $gajiKehadiranAbsensi->reff = $userLogin;
                                    $gajiKehadiranAbsensi->save();
                              
                                }
                                else
                                {
                                    DB::table('gaji_kehadiran_absensi')
                                    ->where('id_periode',$idPeriode)
                                    ->where('id_karyawan',$x->idKaryawan)
                                    ->delete();
                                    
                                    $gajiKehadiranAbsensi = new gaji_kehadiran_absensi();
                                    $gajiKehadiranAbsensi->id_periode = $idPeriode;
                                    $gajiKehadiranAbsensi->id_karyawan = $x->idKaryawan;
                                    $gajiKehadiranAbsensi->tot_hari = $dtAbsensiHarian->tot_hari;
        
                                    $gajiKehadiranAbsensi->upah_harian = $_upahHarian;
                                    $gajiKehadiranAbsensi->tot_libur = $dtAbsensiHarian->tot_libur;
                                    $gajiKehadiranAbsensi->tot_ph = $dtAbsensiHarian->tot_ph;
                                    $gajiKehadiranAbsensi->tot_izin = $dtAbsensiHarian->tot_izin;
                                    $gajiKehadiranAbsensi->tot_alfa = $dtAbsensiHarian->tot_alfa;
                                    $gajiKehadiranAbsensi->tot_sakit = $dtAbsensiHarian->tot_sakit;
                                    $gajiKehadiranAbsensi->tot_cuti = $dtAbsensiHarian->tot_cuti;
                                    $gajiKehadiranAbsensi->tot_masuk = $dtAbsensiHarian->tot_masuk;
                                    $gajiKehadiranAbsensi->reff = $userLogin;
                                    $gajiKehadiranAbsensi->save();
                                }
                            // get nominal Tunjangan Transport 
                            $c_classPenggajian = new c_classPenggajian;
                          
                            $_val = $c_classPenggajian->getTunjanganTransport($x->idKaryawan); 
                            $_valTransport = $_val;
                     
                            $_tnjTranposrt=0;

                            // cek skema 5-1 & 6-61
                            if($x->jmlHari =='25')
                            {
                                // set maksimal 26 hari
                                if($dtAbsensiHarian->tot_masuk > $x->jmlHari)
                                {
                                    $_tnjTranposrt= ($_valTransport->nominal) * ($x->jmlHari+1);
                                }
                                else
                                {
                                    $_tnjTranposrt= ($_valTransport->nominal) * $dtAbsensiHarian->tot_masuk;
                                }
                            }
                            elseif($x->jmlHari =='21')
                            {
                                // set maksimal 21 hari
                                if($dtAbsensiHarian->tot_masuk > $x->jmlHari)
                                {
                                    $_tnjTranposrt= ($_valTransport->nominal) * ($x->jmlHari);
                                }
                                else
                                {
                                    $_tnjTranposrt= ($_valTransport->nominal) * $dtAbsensiHarian->tot_masuk;
                                }
                            }
                        
                            
                           
                            // update Tunjangan Transport & Alfa/ Ijin
                             DB::table('gaji_karyawan_sub_variable')
                            ->where('id_periode',$idPeriode)
                            ->where('id_karyawan',$x->idKaryawan)
                            // code variable tunjangan Transport VR-004
                            ->where('id_variable','VR-004')
                            ->update([
                                       'nominal' => $_tnjTranposrt,
                            ]);

                            // Cek Skema Gaji (Harian = 2)
                            if($x->skemaGaji=='2')
                            {
                                // nothing
                                $_nominalAlfa =0;
                                $_nominalIjin =0;
                            }
                            else
                            {
                                // update  Alfa
                                $_nominalAlfa =0;
                                $_nominalAlfa=$dtAbsensiHarian->tot_alfa*$_upahHarian;

                                // update  Ijin
                                $_nominalIjin =0;
                                $_nominalIjin=$dtAbsensiHarian->tot_izin*$_upahHarian;
                            }
                              DB::table('gaji_karyawan_sub_variable')
                              ->where('id_periode',$idPeriode)
                              ->where('id_karyawan',$x->idKaryawan)
                              // code variable tunjangan Transport VR-010
                              ->where('id_variable','VR-010')
                              ->update([
                                      'nominal' => $_nominalAlfa,
                              ]);
                              
                              DB::table('gaji_karyawan_sub_variable')
                              ->where('id_periode',$idPeriode)
                              ->where('id_karyawan',$x->idKaryawan)
                              // code variable tunjangan Transport VR-011
                              ->where('id_variable','VR-011')
                              ->update([
                                      'nominal' => $_nominalIjin,
                              ]);
                        }
                            
                    }

                    // update Status Periode gaji
                        DB::table('gaji_periode_status')
                        ->where('id_periode',$idPeriode)
                        ->where('id_status_gaji','GG-003')
                        ->update([
                            'status' => '1',
                            'reff' => $userLogin,
                        ]);

                    DB::table('kehadiran_absensi')
                    ->where('id_periode',$idPeriode)
                    ->delete();

                    $c_classPenggajian = new c_penggajian_paycheck;
                    $c_classPenggajian = $c_classPenggajian->hitungThp();

                DB::commit();
          
                return 'success';
            } catch (\Exception $ex) {
                DB::rollBack();
                return response()->json($ex);
            }
        }
        // Action Data -----------------------------------
        public function actionData(Request $request) {
            $userLogin = request()->session()->get('username');
            $typeActionData = $request->typeActionData;
            $idData = $request->idData;
   
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

                    $_totData = DB::table('kehadiran_absensi')
                    ->select(DB::raw('COUNT(id) as totData'));

                    if($typeActionData=='removeAll')
                    {
                        $_totData->where('id_periode',$periode->idPeriode);
                        $totData = $_totData->first();

                        DB::table('kehadiran_absensi')
                        ->where('id_periode',$periode->idPeriode)
                        ->delete();
                        $_keterangan = 'Action-Remove All Data Absensi ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.') Total Data Absensi Karyawan : '. $totData->totData;
                    }
                    elseif($typeActionData=='removeCheckBox')
                    {
            
                        // $_totData->where('id_periode',$periode->idPeriode);
                        $_totData->whereIn('id',$idData);
                        $totData = $_totData->first();

                        DB::table('kehadiran_absensi')
                        // ->where('id_periode',$periode->idPeriode)
                        ->whereIn('id',$idData)
                        ->delete();
                        $_keterangan = 'Action-Remove CheckBox Data Absensi ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.') Total Data Absensi Karyawan : '. $totData->totData .' ID : {'. $idData.'}';
                    }
                    // insert history
                   
                    $_requestValue['tipe'] = 0;
                    $_requestValue['menu'] ='Penggajian';
                    $_requestValue['module'] = 'Absensi Karyawan';
                    $_requestValue['keterangan'] = $_keterangan;
                    $_requestValue['pic'] = $userLogin;
           
                    $c_class = new c_classHistory;
                    $c_class = $c_class->insertHistory($_requestValue);
                }
                DB::commit();
                return 'success';
            } catch (\Exception $ex) {
                DB::rollBack();
                return json_encode([$ex]);
            }
        }

    
}