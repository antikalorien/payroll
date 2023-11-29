<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use Carbon\Carbon;
use DateTime;

use App\Http\Controllers\c_classPenggajian;

class c_Overview extends Controller
{
    public function totalKaryawanAktif() {
       
        try {
            $total=0;
              
                $dt= DB::table('users')
                ->select(DB::raw('COUNT(id) AS total'))
                ->where('users.status','=','1')
                ->first(); 
     
                $total=$dt->total; 
                return $total;    
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function totalKaryawnNonAktif() {
      
        try {
            $total=0;
              
            $dt= DB::table('users')
            ->select(DB::raw('COUNT(id) AS total'))
            ->where('users.status','=','2')
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    // ----------------------------------------------------------------
    public function totalKaryawanPenggajianAktif($idPeriode) {
        try {

     

            $total=0;
              
            $dt= DB::table('gaji_karyawan')
            ->select(DB::raw('COUNT(id_karyawan) AS total'))
            ->where('id_periode','=',$idPeriode)
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function karyawanGajiNormal($idPeriode) {
        try {

            $total=0;
              
            $dt= DB::table('gaji_karyawan')
            ->select(DB::raw('COUNT(id_karyawan) AS total'))
            ->where('id_periode','=',$idPeriode)
            ->where('skema_gaji','1')
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function karyawanGajiHarian($idPeriode) {
        try {

            $total=0;
              
            $dt= DB::table('gaji_karyawan')
            ->select(DB::raw('COUNT(id_karyawan) AS total'))
            ->where('id_periode','=',$idPeriode)
            ->where('skema_gaji','2')
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function karyawanGajiSetengah($idPeriode) {
        try {

            $total=0;
              
            $dt= DB::table('gaji_karyawan')
            ->select(DB::raw('COUNT(id_karyawan) AS total'))
            ->where('id_periode','=',$idPeriode)
            ->where('skema_gaji','3')
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }


    public function karyawanTidakTerdaftarPenggajian($idPeriode) {
        try {

            $total=0;

            $dtUsersActive = DB::table('gaji_karyawan')
            ->select('id_karyawan')
            ->where('id_periode',$idPeriode)
            ->get()->pluck('id_karyawan')->toArray();
              
            $dt= DB::table('users')
            ->select(DB::raw('COUNT(id) AS total'))
            ->whereNotIn('id_absen',$dtUsersActive)
            ->where('users.status','=','1')
            ->first(); 
 
            $total=$dt->total; 
            return $total;    
       
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
    }

    public function listData() {
        $data['data'] = DB::table('gaji_karyawan')
        ->select(
            'gaji_karyawan.id_periode as id_periode',
            'gaji_periode.keterangan as keterangan',
            'gaji_periode.periode as periode',
            'gaji_periode.total_karyawan as totalKaryawan',
            DB::raw('sum(gaji_karyawan.thp) as thp'))
        ->join('gaji_periode','gaji_periode.id_periode','gaji_karyawan.id_periode')
        ->groupBy('gaji_karyawan.id_periode')
        ->orderBy('gaji_periode.created_at','desc')
        ->get();    
        return json_encode($data);        
    }

    public function updateStatusPayslip(Request $request)
    {
        $idPeriode = $request->id;
        $tipe = $request->tipe;
        
        try {
            $keterangan = '';
            if($tipe=='1')
            {
                $keterangan = 'Active Payslip';
            }
            elseif($tipe=='0')
            {
                $keterangan = '-';
            }
            DB::table('gaji_periode')->where('id_periode','=',$idPeriode)
                ->update([
                    'keterangan' => $keterangan
                ]);
             
            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function listDataBpjs($idPeriode) {
        $data= DB::table('gaji_karyawan_sub_variable')
        ->select(
            // bpjs kesehatan perusahaan
            DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-017' and x.id_periode='".$idPeriode."' limit 1)as bpjsKesehatanPerusahaan"),
            DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-017' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsKesehatanPerusahaan"),
            // bpjs tk perusahaan
            DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-013' and x.id_periode='".$idPeriode."' limit 1)as bpjsTkPerusahaan"),
            DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-013' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsTkPerusahaan"),
            // bpjs jp perusahaan
            DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-015' and x.id_periode='".$idPeriode."' limit 1)as bpjsJpPerusahaan"),
            DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-015' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsJpPerusahaan"),
             // bpjs kesehatan karyawan
             DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-018' and x.id_periode='".$idPeriode."' limit 1)as bpjsKesehatanKaryawan"),
             DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-018' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsKesehatanKaryawan"),
             // bpjs tk karyawan
             DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-014' and x.id_periode='".$idPeriode."' limit 1)as bpjsTkKaryawan"),
             DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-014' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsTkKaryawan"),
             // bpjs jp karyawan
             DB::raw("(select sum(x.nominal) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-016' and x.id_periode='".$idPeriode."' limit 1)as bpjsJpKaryawan"),
             DB::raw("(select count(x.id) as nominal from gaji_karyawan_sub_variable x where x.id_variable='VR-016' and x.id_periode='".$idPeriode."' and nominal !=0 limit 1)as countBpjsJpKaryawan")
            
            )
        ->groupBy('gaji_karyawan_sub_variable.id_periode')

        ->first();
   
         
        return $data;        
    }
 
    public function index() {
            $userLogin = request()->session()->get('username');
            $data['totalKaryawanAktif'] = $this->totalKaryawanAktif();
            $data['totalKaryawanNonAktif'] = $this->totalKaryawnNonAktif();
        
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getPeriodeBerjalan(); 

            if (is_null($_val)) 
            {
                $data['periode'] ='';
                $data['dataBpjs'] = '';
                $data['periodeBpjs'] ='';
             
            }
            else
            {
                $idPeriode = $_val->idPeriode;
                $data['periode'] =$_val->periode;
                $data['totalKaryawanPenggajianAktif'] = $this->totalKaryawanPenggajianAktif($idPeriode);
                $data['karyawanGajiNormal'] = $this->karyawanGajiNormal($idPeriode);
                $data['karyawanGajiHarian'] = $this->karyawanGajiHarian($idPeriode);
                $data['karyawanGajiSetengah'] = $this->karyawanGajiSetengah($idPeriode);
                $data['karyawanTidakTerdaftarPenggajian'] = $this->karyawanTidakTerdaftarPenggajian($idPeriode);
                $data['dataBpjs'] = $this->listDataBpjs($idPeriode);
                
                // BPJS
                // get ID Last Periode
                $c_classPenggajian = new c_classPenggajian;
                $_val=  $c_classPenggajian->getLastPeriode();
                if(is_null($_val))
                {
                    $data['dataBpjs'] = '';
                    $data['periodeBpjs'] ='';
                 
                }
                else
                {
                    $idPeriode = $_val->idPeriode;
                    $data['dataBpjs'] = $this->listDataBpjs($idPeriode);
                  
                    $data['periodeBpjs'] =$_val->periode;
                }
             
            }
       
            return view('dashboard.overview.index')->with($data);

    }
}
