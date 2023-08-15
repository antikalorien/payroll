<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\sysActivityHistory;
use App\periode_jadwal;
use App\gaji_periode;
use App\gaji_periode_status;
use App\gaji_karyawan;
use App\gaji_karyawan_sub_variable;
use Illuminate\Support\Facades\Http;
use PDF;
use Carbon\CarbonPeriod;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Carbon;

class c_penggajian_generateGaji extends Controller
{
    public function index() 
    {
        $data=null;
        $periode=null;
        
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

            // get Data Status Periode
            $data['periode_status'] = DB::table('gaji_periode_status')
            ->select('id_status_gaji as idStatusGaji','status_gaji as statusGaji',
            'status as status','filename_1 as filename1','filename_2 as filename2','url as url','keterangan as keterangan','reff as reff',
            'updated_at as updatedAt')
            ->where('id_periode','=',$_val->idPeriode)
            ->get();
          }

        return view('dashboard.penggajian.generate-gaji.baru')->with('data',$data)->with('periode',$periode);
    }

    public function list() {
        return view('dashboard.penggajian.generate-gaji.list');
    }

    public function listData() {
        
            $data['data'] = DB::table('gaji_periode')
                    ->select('gaji_periode.id as id',
                    'gaji_periode.id_periode as idPeriode',
                    'gaji_periode.periode as periode',
                    'gaji_periode.total_karyawan as totalKaryawan',
                    'gaji_periode.reff as reff',
                    'gaji_periode.pic as pic',
                    'gaji_periode.created_at as createdAt',
                    'gaji_periode.updated_at as updatedAt')
                    ->get();
      
        return json_encode($data);
    }

    public function listPeriodeJadwal(Request $request)
    {

            $c_calass = new c_classApi;
            $_val = $c_calass->getUrlApi(); 
            $_url= $_val.'GetLastPeriode';
            $response = Http::get($_url);
            $jsonData = $response->json();

            foreach($jsonData as $x => $node)
            {
                    $dataListPeriodeJadwal = DB::table('periode_jadwal')
                    ->select('id')
                    ->where('id_periode',$node['id_periode']);
                    if ($dataListPeriodeJadwal->doesntExist()) {  
                        $periode_jadwal = new periode_jadwal();
                        $periode_jadwal->id_periode = $node['id_periode'];
                        $_periode = substr($node['periode'],strpos($node['periode'],"-")+1);
                        $periode_jadwal->periode = $_periode; 
                        $periode_jadwal->tgl_awal = $node['tgl_awal'];
                        $periode_jadwal->tgl_akhir = $node['tgl_akhir'];
                        $periode_jadwal->keterangan = $node['keterangan'];
                        $periode_jadwal->toleransi_keterlambatan = '00:00:00';
                        $periode_jadwal->reff = '-';  
                        $periode_jadwal->save();
                    }
            }
           

        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('periode_jadwal')
                ->select('periode_jadwal.id_periode as id','periode_jadwal.periode as text')
                ->where('periode_jadwal.periode', 'like', '%' . $_GET['search'] . '%')
                ->where('periode_jadwal.reff','-')
                ->orderBy('periode_jadwal.id','desc')
                ->limit(1)
                ->get();
        } else {
            $data['results'] = DB::table('periode_jadwal')
                ->select('periode_jadwal.id_periode as id','periode_jadwal.periode as text')
                ->where('periode_jadwal.reff','-')
                ->orderBy('periode_jadwal.id','desc')
                ->limit(1)
                ->get();
        }
        return $data;
    }


    

    public function generateGajiPeriode(Request $request) {
        $userLogin = request()->session()->get('username');

        $idPeriode = $request->idPeriode;  
        // $idGaji = IdGenerator::generate(['table' => 'gaji_periode', 'field' => 'id_variable', 'length' => 6, 'prefix' => 'GA-']);
        try {
            DB::beginTransaction();

            // cek periode
            $periode = DB::table('periode_jadwal')
            ->select('id_periode as idPeriode','periode as periode','tgl_awal as tglAwal','tgl_akhir as tglAkhir')
            ->where('id_periode','=',$idPeriode)
            ->first();

            // cek user departemen
            $dtUser = DB::table('users')
            ->select('id_departemen as idDepartemen','id_departemen_sub as idDepartemenSub','id_absen as idKaryawan','username as nik',
            'id_skema_hari_kerja as idSkemaHariKerja','tipe_kontrak as tipeKontrak','users.status_skema_gaji as statusSkemaGaji','users.skema_gaji as skemaGaji',
            DB::raw('IFNULL(masa_kerja,0) as masaKerja'),
            DB::raw('IFNULL(usia,0) as usia'),
            'no_rekening as noRekening','tipe_bpjs as tipeBpjs')
            ->where('status','=','1')
            ->get();

            $totalKaryawan =0;
            $keterangan ="";
                foreach($dtUser as $d)
                {
                
                    // add to table gaji karyawan
                    $gajiKaryawan = new gaji_karyawan();
                
                    $gajiKaryawan->id_periode = $periode->idPeriode;
                
                    $gajiKaryawan->id_karyawan = $d->idKaryawan ;
                    $gajiKaryawan->id_departemen = $d->idDepartemen; 
                    $gajiKaryawan->id_departemen_sub = $d->idDepartemenSub ;
                    $gajiKaryawan->nik = $d->nik;
                    $gajiKaryawan->id_skema_hari_kerja = $d->idSkemaHariKerja;
                    $gajiKaryawan->tipe_kontrak = $d->tipeKontrak;
                    $gajiKaryawan->masa_kerja = $d->masaKerja;
                    $gajiKaryawan->usia = $d->usia;     
                    $gajiKaryawan->no_rekening = $d->noRekening;
                    $gajiKaryawan->tipe_bpjs = $d->tipeBpjs; 
                    $gajiKaryawan->status_skema_gaji = $d->statusSkemaGaji; 
                    $gajiKaryawan->skema_gaji = $d->skemaGaji;  
                    $gajiKaryawan->thp = 0;
                    $gajiKaryawan->reff = $userLogin;
                    $gajiKaryawan->save();
                
                    // add to table gaji karyawan sub variable
                        // get variable
                        $karGSV = DB::table('karyawan_group_sub_variable')
                        ->select('id_variable as idVariable','nominal as nominal')
                        ->where('id_karyawan',$d->idKaryawan)
                        ->get();
                        foreach($karGSV as $x)
                        {
                            // add to table gaji karyawan sub variable
                            $gajiKaryawanSubVar = new gaji_karyawan_sub_variable();
                            $gajiKaryawanSubVar->id_periode = $periode->idPeriode;
                            $gajiKaryawanSubVar->id_karyawan = $d->idKaryawan ;
                            $gajiKaryawanSubVar->id_variable = $x->idVariable; 
                            $gajiKaryawanSubVar->nominal = $x->nominal ;
                            $gajiKaryawanSubVar->reff = $userLogin;
                            $gajiKaryawanSubVar->save();
                        }
                    $totalKaryawan++;
                }

                // update table gaji_periode
                $gajiPeriode = new gaji_periode();
                $gajiPeriode->id_periode = $periode->idPeriode;
                $gajiPeriode->periode = $periode->periode ;
                $gajiPeriode->tgl_awal = $periode->tglAwal; 
                $gajiPeriode->tgl_akhir = $periode->tglAkhir ;
                $gajiPeriode->total_karyawan = $totalKaryawan;
                $gajiPeriode->keterangan = '-';
                $gajiPeriode->reff = $userLogin;
                $gajiPeriode->pic = '-';
                $gajiPeriode->save();

                // add table gaji_periode_status
                $dtStatusGaji = DB::table('status_generate_gaji')
                ->select('id_status as idStatus','status as status','filename_1 as filename1','filename_2 as filename2','url as url','keterangan as keterangan')
                ->orderBy('ord','asc')
                ->get();

                foreach($dtStatusGaji as $a)
                {
                  
                    $gajiPeriodeStatus = new gaji_periode_status();
                    $gajiPeriodeStatus->id_periode = $periode->idPeriode;
                    $gajiPeriodeStatus->id_status_gaji = $a->idStatus ;
                    $gajiPeriodeStatus->status_gaji = $a->status; 
                    if($a->idStatus=='GG-001')
                    {
                        $gajiPeriodeStatus->status = 1; 
                        $gajiPeriodeStatus->reff = $userLogin; 
                    }
                    else
                    {
                        $gajiPeriodeStatus->status = 0; 
                        $gajiPeriodeStatus->reff = '-'; 
                    }
                 
                    $gajiPeriodeStatus->filename_1 = $a->filename1; 
                    $gajiPeriodeStatus->filename_2 = $a->filename2; 
                    $gajiPeriodeStatus->url = $a->url; 
                    $gajiPeriodeStatus->keterangan = $a->keterangan; 
                    $gajiPeriodeStatus->pic = '-'; 
                    $gajiPeriodeStatus->save();
                }

                // update
                DB::table('periode_jadwal')
                ->where('id_periode','=',$idPeriode)
                ->update([
                'reff' => $userLogin
                ]);

                // insert history
                $_keterangan = 'Berhasil Generate Periode ' . $periode->periode . ' ('.$periode->idPeriode.')'.'  Total Karyawan : '. $totalKaryawan;
    
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Generate Gaji';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);
            
                DB::commit();
         
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
    
}