<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// model
use App\Exports\export_penggajianPaycheckAllData;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class c_penggajian_paycheck extends Controller
{
    public function index() {
        $data['periode_status'] = DB::table('gaji_periode_status')
        ->select('id_status_gaji as idStatusGaji','status_gaji as statusGaji','status as status','filename_1 as filename1','filename_2 as filename2')
        ->where('pic','=','-')
        ->get();
        return view('dashboard.penggajian.paycheck.baru')->with('data',$data);
    }

    public function list() {
        return view('dashboard.penggajian.paycheck.list');
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
            $idPeriode = $_val->idPeriode;

            $data['data'] =  DB::table('gaji_karyawan')
            ->select(
            'gaji_karyawan.id as id',
            'gaji_karyawan.reff_paycheck as reffPaycheck',
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
            'gaji_karyawan.thp as thp',
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
            // DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as simpananKoperasi"),
            // DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as hutangKaryawan"),
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
            
            $data['thp'] = DB::table('gaji_karyawan')
            ->select(
                DB::raw("FORMAT(sum(thp),2) as total"),
            )
            ->where('gaji_karyawan.id_periode',$idPeriode)
            ->first();
         }
     
      
        return json_encode($data);
    }

    public function submitModule(Request $request)
    {
        $userLogin = request()->session()->get('username');
        $idModule = $request->idModule;
        $password = $request->password;

        try {

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
                        $idPeriode = $periode->idPeriode;
                    }
                    $c_classPeriode = new c_classPeriode;
                    $c_classPeriode = $c_classPeriode->updateStatusPeriode($idPeriode,$idModule,$userLogin);

                    $c_classPeriode = new c_classPeriode;
                    $c_classPeriode = $c_classPeriode->lockStatusPeriode($idPeriode,$userLogin);

                    $_keterangan = 'Submit Paycheck ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')';
            
                    // insert history        
                    $_requestValue['tipe'] = 0;
                    $_requestValue['menu'] ='Penggajian';
                    $_requestValue['module'] = 'Paycheck';
                    $_requestValue['keterangan'] = $_keterangan;
                    $_requestValue['pic'] = $userLogin;

                    $c_class = new c_classHistory;
                    $c_class = $c_class->insertHistory($_requestValue);
             }
             else
             {
                 return $_credentials;
             }
             return 'success';
           } catch (\Exception $ex) {
               return response()->json($ex);
           }
    }

    // Action Data
    public function exportUpahKaryawanGaji(){
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
              $idPeriode = $_val->idPeriode;
              $periode = $_val->periode;
              return Excel::download(new export_penggajianPaycheckAllData($idPeriode), 'Penggajian-Paycheck-AllKaryawan-'.$periode.'.xlsx');
          }
    
    }

    public function exportUpahKaryawanGajiSelected($idKaryawan) {
        $userLogin = request()->session()->get('username');
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
                $idPeriode = $_val->idPeriode;

                    // get data
                    $trn['komponenGaji_upahTetap'] = DB::table('grouping_sub_variable')
                    ->select(
                    'grouping_sub_variable.id_sub_group as idSubGroup',
                    'grouping_sub_variable.id_variable as id_variable',
                    'grouping_sub_variable.variable as variable')
                    ->orderBy('grouping_sub_variable.id_variable','asc')
                    ->where('grouping_sub_variable.isDell','=','1')
                    ->where('grouping_sub_variable.id_sub_group','=','GS-001')
                    ->get();

                    $trn['komponenGaji_upahVariable'] = DB::table('grouping_sub_variable')
                    ->select(
                    'grouping_sub_variable.id_sub_group as idSubGroup',
                    'grouping_sub_variable.id_variable as id_variable',
                    'grouping_sub_variable.variable as variable')
                    ->orderBy('grouping_sub_variable.id_variable','asc')
                    ->where('grouping_sub_variable.isDell','=','1')
                    ->where('grouping_sub_variable.id_sub_group','=','GS-002')
                    ->get();

                    $trn['komponenGaji_potongan'] = DB::table('grouping_sub_variable')
                    ->select(
                    'grouping_sub_variable.id_sub_group as idSubGroup',
                    'grouping_sub_variable.id_variable as id_variable',
                    'grouping_sub_variable.variable as variable')
                    ->orderBy('grouping_sub_variable.id_variable','asc')
                    ->where('grouping_sub_variable.isDell','=','1')
                    ->where('grouping_sub_variable.id_sub_group','=','GS-003')
                    ->orWhere('grouping_sub_variable.id_sub_group','=','GS-004')
                    ->get();

                    $trn['komponenGaji_bpjsPerusahaan'] = DB::table('grouping_sub_variable')
                    ->select(
                    'grouping_sub_variable.id_sub_group as idSubGroup',
                    'grouping_sub_variable.id_variable as id_variable',
                    'grouping_sub_variable.variable as variable')
                    ->orderBy('grouping_sub_variable.id_variable','asc')
                    ->where('grouping_sub_variable.isDell','=','1')
                    ->where('grouping_sub_variable.id_sub_group','=','GS-006')
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
                    'gaji_karyawan.skema_gaji as skemaGaji',
                    'gaji_karyawan.thp as thp')
                    ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
                    ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
                    ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
                    ->join('gaji_periode','gaji_periode.id_periode','gaji_karyawan.id_periode')
                    ->where('users.username',$idKaryawan)
                    ->where('gaji_karyawan.id_periode',$idPeriode)
                    ->limit(1)
                    ->get();
          
                   // get data
                   $trn['karyawan_gaji'] = DB::table('gaji_karyawan_sub_variable')
                   ->select('gaji_karyawan_sub_variable.id_karyawan as id_karyawan',
                  'gaji_karyawan_sub_variable.id_variable as id_variable',
                  'grouping_sub_variable.variable as variable',
                  'gaji_karyawan_sub_variable.nominal as nominal','gaji_karyawan_sub_variable.keterangan as keterangan')
                   ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
                   ->join('users','users.id_absen','gaji_karyawan_sub_variable.id_karyawan')
                   ->where('users.username',$idKaryawan)
                   ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
                   ->orderBy('users.username','asc')
                   ->orderBy('gaji_karyawan_sub_variable.id_variable','asc')
                   ->get();

                   $getID =  DB::table('users')
                   ->select(
                   'departemen.departemen as departemen',    
                   'users.username as nip',
                   'users.id_absen as idAbsen',
                   'users.name as name')
                    ->join('departemen','departemen.id_dept','=','users.id_departemen')
                    ->where('users.username',$idKaryawan)
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
                    ->where('gaji_kehadiran_absensi.id_karyawan',$getID->idAbsen)
                    ->where('gaji_kehadiran_absensi.id_periode',$idPeriode)
                    ->first();

                   // update status check
                   DB::table('gaji_karyawan')
                   ->where('id_karyawan','=',$getID->idAbsen)
                   ->where('id_periode','=',$idPeriode)
                   ->update([
                       'reff_paycheck' => $userLogin,
                   ]);
            }

            $pdf = PDF::loadView('dashboard.penggajian.paycheck.slipgaji_pdf',$trn)->setPaper('b4','portrait');

            $pdf->output();
            $canvas = $pdf->getDomPDF()->getCanvas();
    
            $height = $canvas->get_height();
            $width = $canvas->get_width();
    
            $canvas->set_opacity(.2,"Multiply");
    
            $canvas->set_opacity(.2);
    
            $canvas->page_text($width/5, $height/2, 'Slip Gaji Sementara', null,
            55, array(0,0,0),2,2,-30);

            return $pdf->stream($getID->nip.'-'.strtoupper($getID->name).'-'.strtoupper($getID->departemen).'.pdf');
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function exportUpahKaryawanGajiCheckBox($_idData)
    {
        try
        {
            $idData=explode(',',$_idData);
            foreach($idData as $v)
            {
                $idKaryawan = DB::table('gaji_karyawan')
                ->select('nik')
                ->where('id',$v)
                ->first();
           
                $pdf = $this->exportUpahKaryawanGajiSelected($idKaryawan->nik);

            }
       
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }



    public function hitungThp()
    {
        try
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
                    $idPeriode = $_val->idPeriode;
               
                    $result=0;
                    $c_classRumus = new c_classPenggajian;
                    $result = $c_classRumus->hitungThpAllPeriode($idPeriode); 
                }
            return $result;
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

}
