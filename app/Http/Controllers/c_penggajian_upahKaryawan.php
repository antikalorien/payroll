<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use PDF;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\export_penggajianUpahKaryawan;

use Session;


class c_penggajian_upahKaryawan extends Controller
{
    public function index() {
        return view('dashboard.penggajian.upah-karyawan.baru');
    }

    public function addKaryawan() {
        return view('dashboard.penggajian.upah-karyawan.baru_add');
    }

    public function list() {
        return view('dashboard.penggajian.upah-karyawan.list');
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
          $data['data'] =  DB::table('gaji_karyawan')
          ->select(
          'gaji_karyawan.id_karyawan as id',
          'departemen.departemen as id_departemen',
          'departemen_sub.sub_departemen as subDepartemen',
          'users.pos as pos',
          'grade.level as grade',
          'users.doj as doj',
          'gaji_karyawan.id_karyawan as id_absen',
          'gaji_karyawan.nik as username',
          'users.name as name',
          'gaji_karyawan.tipe_kontrak as tieKontrak',
          'gaji_karyawan.masa_kerja as masaKerja',
          'gaji_karyawan.usia as usia',
          'users.no_rekening as noRekening',
          'users.tipe_bpjs as tipeBpjs',
          'gaji_karyawan.status_skema_gaji as statusSkemaGaji',
          'gaji_karyawan.skema_gaji as skemaGaji',
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-001' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as gajiPokok"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-002' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganJabatan"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-003' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKeahlian"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-004' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganTransport"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-005' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKomunikasi"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as lembur"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tambahanLainnya"),
        //    DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKes"),
        //    DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTk"),
        //    DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJp"),
           'gaji_karyawan.updated_at as updatedAt')
           ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
           ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
           ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
           ->join('grade','grade.id_grade','users.grade')
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
            //   DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsKes"),
            //   DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsTk"),
            //   DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsJp"),
            //   DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotSimpananKoperasi"),
            //   DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotHutangKaryawan"),
              DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotLembur"),
              DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotTambahanLainnya"),
           )
           ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
           ->groupBy('gaji_karyawan_sub_variable.id_karyawan')
           ->first();
        }
       
        return json_encode($data);
    }

    public function listData() {
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

                $dataPeriodeKaryawan = DB::table('gaji_karyawan')
                ->select('id_karyawan')
                ->where('id_periode',$idPeriode)
                ->get()->pluck('id_karyawan')->toArray();

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
                 ->whereNotIn('users.id_absen',$dataPeriodeKaryawan)
                 ->orderBy('users.username','asc')
                ->get();                
            }
            return json_encode($data);
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function edit($idKaryawan) {
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
 
         $data['user'] = DB::table('gaji_karyawan')
         ->select('departemen.departemen as departemen',
         'departemen_sub.sub_departemen as subDepartemen',
         'users.pos as pos',
         'users.grade as idGrade',
         'grade.level as grade',
         'gaji_karyawan.id_karyawan as idAbsen',
         'gaji_karyawan.nik as nik',
         'users.name as name',
         'users.email as email',
         'users.no_hp as noHp',
         'skema_hari_kerja.skema',
         'gaji_karyawan.tipe_kontrak as tipeKontrak',
         'users.doj as doj',
         'gaji_karyawan.masa_kerja as masaKerja',
         'gaji_karyawan.usia as usia',
         'gaji_karyawan.no_rekening as noRekening',
         'gaji_karyawan.tipe_bpjs as tipeBpjs',
         'gaji_karyawan.status_skema_gaji as statusSkemaGaji',
         'gaji_karyawan.skema_gaji as skemaGaji',
         'users.created_at as created_at')
         ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
         ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
         ->join('skema_hari_kerja','skema_hari_kerja.id_skema','gaji_karyawan.id_skema_hari_kerja')
         ->join('grade','grade.id_grade','users.grade')
         ->where('gaji_karyawan.id_karyawan','=',$idKaryawan)
         ->where('gaji_karyawan.id_periode','=',$idPeriode)
         ->limit(1)
         ->first();
 
         $dtCheck = DB::table('gaji_karyawan_sub_variable')
         ->select('id_variable')
         ->where('status','1')
         ->where('id_karyawan', $idKaryawan)
         ->where('id_periode',$idPeriode)
         ->get();
       
             $check = [];
             foreach ($dtCheck as $c) {
                 $check[] = $c->id_variable;
             }
 
             $group = DB::table('group_sub')
             ->select('group_sub.id_sub_group as id','group_sub.sub_group as name', 'group_sub.isDell as status')
             ->get();
 
         $dtMenu = DB::table('grouping_sub_variable')
         ->select('grouping_sub_variable.id as id', 'grouping_sub_variable.id_sub_group as idSubGroup','grouping_sub_variable.id_variable as idVariable',
         'grouping_sub_variable.variable as variable','gaji_karyawan_sub_variable.nominal as nominal','gaji_karyawan_sub_variable.keterangan as keterangan')
         ->join('gaji_karyawan_sub_variable','gaji_karyawan_sub_variable.id_variable','grouping_sub_variable.id_variable')
         ->where('gaji_karyawan_sub_variable.id_karyawan',$idKaryawan)
         ->where('gaji_karyawan_sub_variable.id_periode','=',$idPeriode)
         ->get();
 
 
         $menu = [];
         foreach ($dtMenu as $m) {
             $menu[$m->idSubGroup][] = [
                 'id' => $m->id,
                 'id_group' => $m->idSubGroup,
                 'id_variable' => $m->idVariable,
                 'variable' => $m->variable,
                 'nominal' =>$m->nominal,
                 'keterangan' =>$m->keterangan
             ];
         }
 
         $i = 0;
         $sidebar = [];
         foreach ($group as $g) {
             $sidebar[$i]['group'] = [
                 'name' => $g->name,  
                 'status' => $g->status,
             ];
             $sidebar[$i]['menu'] = $menu[$g->id];
             $i++;
         }
 
         $data['profile'] = DB::table('user_profile')->where('username','=',$idKaryawan)->first();
         return view('dashboard.penggajian.upah-karyawan.edit')->with('periode',$periode)->with('data',$data)->with('check',$check)->with('permison',$sidebar);
      }
    }

    public function submitEdit(Request $request) {
        $userLogin = request()->session()->get('username');
        $variabel = $request->variabel;
        $_idPeriode = $request->idPeriode;
        $_idKaryawan = $request->idKaryawan;
        $_noRekening = $request->noRekening;
        $_tipeKontrak = $request->tipeKontrak;
        $_skemaHariKerja = $request->skemaHariKerja;
        $_doj = $request->tanggalBergabung;
        $_tipeBpjs = $request->tipeBpjs;
        $_statusKaryawan = $request->statusSkemaGaji;
        $_tipeGaji = $request->skemaGaji;
        try {
            DB::beginTransaction();

                    if($variabel!='')
                    {
                        $keterangan='-';
                        foreach ($variabel as $x => $val) {

                            // Update Upah Karyawan Master Variable
                            $c_karyawan = new c_classPenggajian;
                            $_status = $c_karyawan->updateUpahkaryawanVariablePeriode($_idPeriode,$_idKaryawan,$x,$val); 
                  
                            $keterangan = 'ID Karyawan : '. $_idKaryawan. ' ID Variable : '. $x. ' Nominal : '. $val.' | '. $keterangan;    
                        }
                        // insert history
                        $_keterangan = 'Update Upah Karyawan Variable Penggajian | ID Periode : '. $_idPeriode.' Data : '. $keterangan;
                                        
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Master Data';
                        $_requestValue['module'] = 'Upah Karyawan';
                        $_requestValue['keterangan'] = $_keterangan;
                        $_requestValue['pic'] = $userLogin;

                        $c_class = new c_classHistory;
                        $c_class = $c_class->insertHistory($_requestValue);   
                    }
                    
                       // Update Upah Karyawan Master Periode
                         $c_penggajian = new c_classPenggajian;
                         $_status = $c_penggajian->updateUpahkaryawanMasterPeriode($_idPeriode,$_idKaryawan,$_tipeBpjs,$_doj,$_tipeKontrak,$_noRekening,$_statusKaryawan,$_tipeGaji); 
            
                         // insert history
                         $_keterangan = 'Update Upah Karyawan Master Penggajian | ID Periode : '. $_idPeriode.
                         ' ID Karyawan : '. $_idKaryawan. 
                         ' Tipe BPJS : '. $_tipeBpjs.
                         ' Tanggal Bergabung : '. $_doj.
                         ' Tipe Kontrak : '. $_tipeKontrak.
                         ' No Rekening : '. $_noRekening.
                         ' Status Karyawan : '. $_statusKaryawan.
                         ' Tipe Gaji : '. $_tipeGaji;
                                                    
                         $_requestValue['tipe'] = 0;
                         $_requestValue['menu'] ='Penggajian';
                         $_requestValue['module'] = 'Upah Karyawan';
                         $_requestValue['keterangan'] = $_keterangan;
                         $_requestValue['pic'] = $userLogin;
            
                         $c_class = new c_classHistory;
                         $c_class = $c_class->insertHistory($_requestValue);  

                DB::commit();
                $result = 'success';
               
            DB::commit();
            return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function submit(Request $request)
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
            $_keterangan = 'Submit Module Upah karyawan ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')';

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

    // Action Data -----------------------------------
    public function actionData(Request $request) {
        $userLogin = request()->session()->get('username');
        $typeActionData = $request->typeActionData;
        $idData = $request->idData;
        $password = $request->password;

        try {
            DB::beginTransaction();  
            // get Credentials
            $c_classCredentials = new c_classCredentials;
            $_credentials = $c_classCredentials->getCredentials($password); 
          
            if($_credentials=='success')
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
                    if($typeActionData=='removeCheckBox')
                    {
                        foreach($idData as $v)
                        {
                            $c_classPenggajian = new c_classPenggajian;
                            $c_classPenggajian = $c_classPenggajian->deleteKaryawanMasterPeriode($periode->idPeriode,$v);
                        }
                        $_keterangan = 'Action-Remove CheckBox Data Karyawan ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')'. ' ID Karyawan : '. json_encode($idData);
                    }
                    elseif($typeActionData=='addKaryawan')
                    {
               
                        foreach($idData as $v)
                        {
                            $c_classPenggajian = new c_classPenggajian;
                            $c_classPenggajian = $c_classPenggajian->addKaryawanMasterPeriode($periode->idPeriode,$v,$userLogin);
                      
                        }
                        $_keterangan = 'Action-Add karyawan ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')'. ' ID Karyawan : '. json_encode($idData);
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
                }
            }
            else
            {
                return $_credentials;
            }
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
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
            return Excel::download(new export_penggajianUpahKaryawan($idPeriode,$_typeActionData,$_idData), 'Penggajian-Upah Karyawan-'.$_typeActionData.'-'.$periode->periode.'.xlsx');
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    // End Action Data ------------------------

    
}
