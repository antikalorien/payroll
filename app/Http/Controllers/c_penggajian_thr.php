<?php

namespace App\Http\Controllers;

use App\Http\Controllers\c_classRumus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Session;
// use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\penggajian_thr;
use App\Exports\export_penggajianLembur;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class c_penggajian_thr extends Controller
{
    public function index() {
        return view('dashboard.thr.input-thr.baru');
    }

    public function addLembur() {
        return view('dashboard.thr.input-thr.baru_add');
    }

    public function importLembur() {
        return view('dashboard.thr.input-thr.baru_importExcel');
    }

    public function list() {
        return view('dashboard.thr.input-thr.list');
    }

    public function data() {
        // get ID Periode
        $yearsNow = Carbon::now()->format('Y');
        
        $data['data'] =  DB::table('gaji_thr')
           ->select(
           'gaji_thr.id as id',
           'gaji_thr.id_periode as id_periode',
           'departemen.departemen as departemen',
           'departemen_sub.sub_departemen as sub_departemen',
           'users.pos as pos',
           'grade.level as grade',
           'users.id_absen as id_absen',
           'users.username as nik',
           'users.name as name',
           'users.masa_kerja as masa_kerja',
           'users.no_rekening',
           'gaji_thr.tipe_thr',
           DB::raw('(FORMAT((gaji_thr.thr),2)) as thr'),
           'gaji_thr.reff',
           'gaji_thr.updated_at as updatedAt')
            ->join('users','users.id_absen','gaji_thr.id_karyawan')
            ->join('departemen','departemen.id_dept','users.id_departemen')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','users.id_departemen_sub')
            ->join('grade','grade.id_grade','users.grade')
            ->where('gaji_thr.id_periode',$yearsNow)
            ->orderBy('gaji_thr.id_karyawan','asc')
            ->get();
   
            $data['total'] = DB::table('gaji_thr')
            ->select(
               DB::raw("(FORMAT(SUM(gaji_thr.thr),2)) as nominal")
            )
            ->where('gaji_thr.id_periode',$yearsNow)
            ->first();
        return json_encode($data);
    }

    public function submit(Request $request) {
            $userLogin = request()->session()->get('username');
           
            $_idKaryawan = $request->idKaryawan;
            $_tglLembur = date('Y-m-d',strtotime($request->tglLembur));
            $_jamLembur = $request->jamLembur;
            $_keterangan = $request->keterangan;
    
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
                    $idPeriode=$periode->idPeriode;

                    // Hitung Lembur Karyawan
                    $c_classPenggajian = new c_classPenggajian;
                    $_val = $c_classPenggajian->tambahLembur($idPeriode,$_idKaryawan,$_tglLembur,$_jamLembur, $_keterangan);

                        // insert history
                        $_keterangan = 'Tambah Lembur ID Periode : ' . $idPeriode . ' ID Karyawan : '. $_idKaryawan . ' Tanggal : '. $_tglLembur. ' Jam Lembur : '. $_jamLembur. ' Keterangan : '. $_keterangan;
            
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Penggajian';
                        $_requestValue['module'] = 'Data Lembur';
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

        public function imporDataThr(Request $request) 
        {
            $username = request()->session()->get('username');
            $yearsNow = Carbon::now()->format('Y');
            try{
                // validasi
                $this->validate($request, [
                    'file' => 'required|mimes:csv,xls,xlsx'
                ]);
            
                // menangkap file excel
                $file = $request->file('file');
            
                // membuat nama file unik
                $nama_file = rand().$file->getClientOriginalName();

                Excel::import(new penggajian_thr($yearsNow,$username),$file);
                return redirect('dashboard/thr/input-thr');
            } catch (\Exception $ex) {
                return $ex;
            }
        }

        public function actionData (Request $request)
        {
            $userLogin = request()->session()->get('username');
            $typeActionData = $request->typeActionData;
            $idData = $request->idData;
            try {
                DB::beginTransaction();  

                        if($typeActionData=='removeCheckBox')
                        {
                            $_kar='-';
                            foreach($idData as $v)
                            {
                                $dataKaryawan = DB::table('gaji_lembur')
                                ->where('id',$v)
                                ->first();
                          
                                $c_classPenggajian = new c_classPenggajian;
                                $c_classPenggajian = $c_classPenggajian->deleteLembur($dataKaryawan->id_periode,$dataKaryawan->id_karyawan,$v);
                        
                                $_kar = 'ID Karyawan : '. $dataKaryawan->id_karyawan.' Tanggal : '. $dataKaryawan->tgl.' Jam Lembur : '.$dataKaryawan->jam_lembur.'-'. $_kar;
                            }
                            
                            $_keterangan = 'Action-Remove CheckBox Data Lembur | Data : '.$_kar;
                        }
                        // insert history
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Penggajian';
                        $_requestValue['module'] = 'Upah Karyawan';
                        $_requestValue['keterangan'] = $_keterangan;
                        $_requestValue['pic'] = $userLogin;
    
                        $c_class = new c_classHistory;
                        $c_class = $c_class->insertHistory($_requestValue);
                      
                        DB::commit();
        
                return 'success';
            } catch (\Exception $ex) {
                return response()->json($ex);
            }
        }

        public function actionSyncronise()
        {
            try
            {
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
                  
                    // $tglAwal = $periode->tgl_awal;
                    $tglAkhir = $periode->tgl_akhir;
                    $tglAwal = '2024-02-01';
                    $tglAkhir = '2024-02-28';
                  
                    // $c_calass = new c_classApi;
                    // $_val = $c_calass->getUrlApi(); 
                    // $_url= $_val.'get_request_overtime_karyawan?tanggal_awal='.$tglAwal.'&tanggal_akhir='.$tglAkhir;
                    $_url= 'http://192.168.0.75:8092/api/get_request_overtime_karyawan?tanggal_awal='.$tglAwal.'&tanggal_akhir='.$tglAkhir;
                    $response = Http::get($_url);
                    $jsonData = $response->json();
                
                    $totalKaryawan=0;
                    foreach($jsonData['data'] as $x => $node)
                    {
                        $jamLembur=0;
                        $idOvertime = $node['id_overtime'];
                        $nik = $node['nik'];
                        $idKaryawan = $node['id_karyawan'];
                        $tglLembur = $node['tgl_lembur'];
                        $jamLembur = $node['jam_lembur'];
                        $keterangan = $node['keterangan'];
   
                        // Hitung Lembur Karyawan
                        $c_classPenggajian = new c_classPenggajian;
                        $_val = $c_classPenggajian->tambahLembur($idPeriode,$idKaryawan,$tglLembur,$jamLembur, $keterangan);
                    }

                     // insert history
                     $_keterangan = 'Tambah Lembur-Syncrinse From LOKARYAWAN ID Periode : ' . $idPeriode .' Periode : '. $periode->periode.' Tanggal Awal : '. $tglAwal. ' Tanggal Akhir : '. $tglAkhir;
            
                     $_requestValue['tipe'] = 0;
                     $_requestValue['menu'] ='Penggajian';
                     $_requestValue['module'] = 'Data Lembur';
                     $_requestValue['keterangan'] = $_keterangan;
                     $_requestValue['pic'] = 'system';
                    
                     $c_class = new c_classHistory;
                     $c_class = $c_class->insertHistory($_requestValue);
                    
                     DB::commit();
                    return 'success';
                }   
            } catch (\Exception $ex) {
                return response()->json($ex);
            }
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
                return Excel::download(new export_penggajianLembur($idPeriode,$_typeActionData,$_idData), 'Penggajian-Lembur-'.$_typeActionData.'-'.$periode->periode.'.xlsx');
                DB::commit();
                return 'success';
            } catch (\Exception $ex) {
                DB::rollBack();
                return json_encode([$ex]);
            }
        }

        public function submitModule(Request $request)
        {
            $userLogin = request()->session()->get('username');
            $idModule = $request->idModule;
    
            try {
    
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
                $c_classPeriode = new c_classPeriode;
                $c_classPeriode = $c_classPeriode->updateStatusPeriode($idPeriode,$idModule,$userLogin);
                $_keterangan = 'Submit Module Lembur karyawan ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')';

                $c_classPenggajian = new c_penggajian_paycheck;
                $c_classPenggajian = $c_classPenggajian->hitungThp();
           
                 // insert history        
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Penggajian';
                 $_requestValue['module'] = 'Upah Karyawan';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;
    
                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);
                 return 'success';
               } catch (\Exception $ex) {
                   return response()->json($ex);
               }
        }
     
}