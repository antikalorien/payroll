<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Session;
// use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\penggajian_dataLembur_lemburKaryawan;
use App\Exports\export_penggajianLembur;
use App\Http\Controllers\Controller;

class c_penggajian_dataLembur extends Controller
{
    public function index() {
        return view('dashboard.penggajian.data-lembur.baru');
    }

    public function addLembur() {
        return view('dashboard.penggajian.data-lembur.baru_add');
    }

    public function importLembur() {
        return view('dashboard.penggajian.data-lembur.baru_importExcel');
    }

    public function list() {
        return view('dashboard.penggajian.data-lembur.list');
    }

    public function getKaryawanGajiPeriode(Request $request)
    {
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

           $data = [];
           if (isset($_GET['search'])) {
               $data['results'] = DB::table('gaji_karyawan')
               ->select('gaji_karyawan.id_karyawan as id',DB::raw('concat(users.username," | ",users.name, " --> Dept.",departemen.departemen," | Sub Dept.",departemen_sub.sub_departemen) as text'))
               ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
               ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
               ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
                   ->where('gaji_karyawan.id_karyawan', 'like', '%' . $_GET['search'] . '%')
                   ->orWhere('users.name', 'like', '%' . $_GET['search'] . '%')
                   ->where('gaji_karyawan.id_periode',$idPeriode)
                   ->orderBy('users.name','asc')
                   ->get();
           } else {
               $data['results'] = DB::table('gaji_karyawan')
               ->select('gaji_karyawan.id_karyawan as id',DB::raw('concat(users.username," | ",users.name, " --> Dept.",departemen.departemen," | Sub Dept.",departemen_sub.sub_departemen) as text'))
               ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
               ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
               ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
               ->where('gaji_karyawan.id_periode',$idPeriode)
               ->orderBy('users.name','asc')
               ->get();
           }
       }
        return $data;
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
           $idPeriode=$periode->idPeriode;

           $data['data'] =  DB::table('gaji_lembur')
           ->select(
           'gaji_lembur.id as id',
           'gaji_lembur.id_periode as idPeriode',
           'departemen.departemen as id_departemen',
           'departemen_sub.sub_departemen as subDepartemen',
           'users.pos as pos',
           'grade.level as grade',
           'gaji_lembur.id_karyawan as id_absen',
           'users.username as username',
           'users.name as name',
           'users.tipe_kontrak as tieKontrak',
           'gaji_lembur.updated_at as updatedAt',
           'gaji_lembur.tgl as tanggal',
           'gaji_lembur.jam_lembur as jamLembur',
            DB::raw('(FORMAT((gaji_lembur.total_upah),2)) as totalUpah'),
            'gaji_lembur.total_jam as totalJam',
            DB::raw('(FORMAT((gaji_lembur.nominal),2)) as nominal'),
            'gaji_lembur.keterangan as keterangan',
            'gaji_lembur.pic as pic')
            ->join('users','users.id_absen','=','gaji_lembur.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_lembur.id_dept')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_lembur.id_sub_dept')
            ->join('grade','grade.id_grade','users.grade')
            ->where('gaji_lembur.id_periode',$idPeriode)
            ->orderBy('gaji_lembur.tgl','asc')
            ->get();
   
            $data['total'] = DB::table('gaji_lembur')
            ->select(
               DB::raw("(FORMAT(SUM(gaji_lembur.nominal),2)) as nominal")
            )
            ->where('gaji_lembur.id_periode',$idPeriode)
            ->first();
       
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
           $idPeriode=$periode->idPeriode;
       
           $data['data'] =  DB::table('gaji_lembur')
            ->select(
            'gaji_lembur.id as id',
            'gaji_lembur.id_periode as idPeriode',
            'departemen.departemen as id_departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'users.grade as grade',
            'gaji_lembur.id_karyawan as id_absen',
            'users.username as username',
            'users.name as name',
            'users.tipe_kontrak as tieKontrak',
            'gaji_lembur.updated_at as updatedAt',
            DB::raw('(sum(gaji_lembur.jam_lembur)) as jamLembur'),
            DB::raw('(FORMAT(gaji_lembur.total_upah,2)) as totalUpah'),
            DB::raw('(sum(gaji_lembur.total_jam)) as totalJam'),
            DB::raw('(FORMAT(sum(gaji_lembur.nominal),2)) as nominal'),
            'gaji_lembur.pic as pic')
            ->join('users','users.id_absen','=','gaji_lembur.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_lembur.id_dept')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_lembur.id_sub_dept')
            ->where('gaji_lembur.id_periode',$idPeriode)
            ->orderBy('gaji_lembur.id_karyawan','asc')
            ->groupBy('gaji_lembur.id_karyawan')
            ->get();

         $data['total'] = DB::table('gaji_lembur')
         ->select(
            DB::raw("(FORMAT(SUM(gaji_lembur.nominal),2)) as nominal")
         )
         ->where('gaji_lembur.id_periode',$idPeriode)
         ->first();
        }
        
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

        public function imporDataLembur(Request $request) 
        {
            $username = request()->session()->get('username');
            try{
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

                    // validasi
                    $this->validate($request, [
                        'file' => 'required|mimes:csv,xls,xlsx'
                    ]);
                
                    // menangkap file excel
                    $file = $request->file('file');
                
                    // membuat nama file unik
                    $nama_file = rand().$file->getClientOriginalName();

                    Excel::import(new penggajian_dataLembur_lemburKaryawan($idPeriode),$file);
                }
            
            return redirect('dashboard/penggajian/data-lembur');
            } catch (\Exception $ex) {
                return response()->json([$ex]);
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
                
                    $tglAwal = $periode->tgl_awal;
                    $tglAkhir = $periode->tgl_akhir;
                  
                    $c_calass = new c_classApi;
                    $_val = $c_calass->getUrlApi(); 
                    $_url= 'https://servicelokaryawan.salokapark.app/api/get_request_overtime_karyawan?tanggal_awal='.$tglAwal.'&tanggal_akhir='.$tglAkhir.'&status=1';
                    // $_url= 'http://192.168.0.75:8092/api/get_request_overtime_karyawan?tanggal_awal='.$tglAwal.'&tanggal_akhir='.$tglAkhir;
                    $response = Http::get($_url);
                    $jsonData = $response->json();
               
                    $totalKaryawan=0;
                    foreach($jsonData['data'] as $x => $node)
                    {
                  
                        // "id_overtime" => "OT-9525-000000"
                        // "departemen" => "Finance & Accounting"
                        // "sub_departemen" => "Finance"
                        // "grade" => "Officer"
                        // "name" => "Sri Wahyuningsih"
                        // "nik" => "02-0121-006"
                        // "no_telephone" => "6285740112428"
                        // "id_karyawan" => "9525"
                        // "nip" => "-"
                        // "tgl_pengajuan" => "2024-02-05 12:50:24"
                        // "tgl_lembur" => "2024-02-05"
                        // "jam_lembur" => "1.00"
                        // "total_jam" => "0.00"
                        // "status" => "1"
                        // "keterangan" => "-"
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