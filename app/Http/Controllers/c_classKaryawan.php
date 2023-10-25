<?php

namespace App\Http\Controllers;

use App\karyawan_group;
use App\karyawan_group_sub;
use App\karyawan_group_sub_variable;
use App\mod_user;
use App\karyawan_group_sub_variable_bpjs;
use Session;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

class c_classKaryawan extends Controller
{
       
    // get Masa Kerja Karyawan
    public function getMasaKerja($tanggalMasuk)
    {
            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d");
            $toDate = Carbon::parse($date);
            $fromDate = Carbon::parse($tanggalMasuk);
            $bulan = $toDate->diffInMonths($fromDate);
            return $bulan;
    }

    // get Usia Karyawan
    public function getUsia($tanggalLahir)
    {
            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d");
            $toDate = Carbon::parse($date);
            $fromDate = Carbon::parse($tanggalLahir);
            $tahun = $toDate->diffInYears($fromDate);
            return $tahun;
    }

    // add user karyawan 
    public function insertUsers($request)
    {
        $_idDepartemen = $request['id_departemen'];
        $_idDepartemenSub = $request['id_departemen_sub'];
        $_pos = $request['pos'];
        $_grade = $request['grade'];
        $_idAbsen = $request['id_absen'];
        $_username = $request['username'];
        $_name = $request['name'];
        $_email = $request['email'];
        $_password = Crypt::encryptString($request['password']);
        $_noHp = $request['no_hp'];
        $_idSkemaHariKerja = $request['id_skema_hari_kerja'];
        $_tanggalBergabung = $request['doj'];
        $_tanggalLahir = $request['dob'];
        $_system = $request['system'];
        $_status = $request['status'];
        try
        {
            // cek double data
            $dtUser = DB::table('users')
            ->where('id_absen','=',$_idAbsen);
            if ($dtUser->doesntExist()) {  
                $insertData = new mod_user();
                $insertData->id_departemen =  $_idDepartemen;
                $insertData->id_departemen_sub =  $_idDepartemenSub;
                $insertData->pos =  $_pos;
                $insertData->grade =  $_grade;
                $insertData->id_absen =  $_idAbsen;       
                $insertData->username = $_username;
                $insertData->name = $_name; 
                $insertData->email = $_email;
                $insertData->password =$_password; 
                $insertData->no_hp = $_noHp;
                $insertData->id_skema_hari_kerja = $_idSkemaHariKerja;
                $insertData->doj = $_tanggalBergabung;
                $insertData->masa_kerja = $this->getMasaKerja($request['doj']);
                $insertData->dob = $_tanggalLahir;
                $insertData->usia = $this->getUsia($request['dob']);
                $insertData->system = $_system;
                $insertData->status = $_status;
                $insertData->save();
                $result='success';
            }
            else
            {
                $result= $this->editUsers($request);
            }
            return $result;
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    // Edit Data user
    public function editUsers($request)
    {
        $_idDepartemen = $request['id_departemen'];
        $_idDepartemenSub = $request['id_departemen_sub'];
        $_pos = $request['pos'];
        $_grade = $request['grade'];
        $_idAbsen = $request['id_absen'];
        $_username = $request['username'];
        $_name = $request['name'];
        $_email = $request['email'];
        $_password = Crypt::encryptString($request['password']);
        $_noHp = $request['no_hp'];
        $_idSkemaHariKerja = $request['id_skema_hari_kerja'];
        $_tanggalBergabung = $request['doj'];
        $_tanggalLahir = $request['dob'];
        $_system = $request['system'];
        $_status =  $request['status'];
        try
        {
            DB::table('users')
            ->where('id_absen',$_idAbsen)
            ->update([
                'id_departemen' => $_idDepartemen,
                'id_departemen_sub' => $_idDepartemenSub,
                'pos' => $_pos,
                'grade' => $_grade,
                'username' => $_username,
                'name' => $_name,
                'email' => $_email,
                'no_hp'=> $_noHp,
                'id_skema_hari_kerja' => $_idSkemaHariKerja,
                'doj' => $_tanggalBergabung,
                'masa_kerja' => $this->getMasaKerja($request['doj']),
                'dob' => $_tanggalLahir,
                'usia' => $this->getUsia($request['dob']),
                'system' => $_system,   
                'status'=> $_status     
            ]);
               
            // Update Grade Tunjangan Transport
            $c_classKaryawan = new c_classPenggajian();     
            $_tunjanganTransport = $c_classKaryawan->updateTunjanganTransport($_idAbsen);

            $result='success';
            return $result;
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    // Non Aktif User
    public function disableUsers($idKaryawan)
    {
        try
        {
            DB::table('users')->where('username','=',$idKaryawan)
            ->update([
                'status' => 2
            ]);

            return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function activeUsers($idKaryawan)
    {
        try
        {
            DB::table('users')->where('username','=',$idKaryawan)
            ->update([
                'status' => 1
            ]);

            return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function insertKaryawanGroupSubVariable($idKaryawan,$nominal)
    {
        $userLogin = request()->session()->get('username');

        $_idKaryawan = $idKaryawan;
        $_nominal =$nominal;

        try
        {
              $groupSubVariable = DB::table('group_sub_variable')
              ->select('group_sub_variable.id as id','group_sub_variable.id_variable as idVariable','group_sub_variable.variable as variable')
              ->where('group_sub_variable.isDell','1')
              ->get();

              foreach($groupSubVariable as $x)
              {
                // cek double data
                $dtUser = DB::table('karyawan_group_sub_variable')
                ->where('id_karyawan','=',$_idKaryawan)
                ->where('id_variable','=',$x->idVariable);
                if ($dtUser->doesntExist()) {   

                  $karyawanGroupSubVariable = new karyawan_group_sub_variable();
                  $karyawanGroupSubVariable->id_karyawan = $_idKaryawan;
                  $karyawanGroupSubVariable->id_variable = $x->idVariable;
                  $karyawanGroupSubVariable->nominal = $_nominal;
                  $karyawanGroupSubVariable->isDell = '1';
                  $karyawanGroupSubVariable->save();

                   // insert history
                   $_keterangan = 'Menambahkan Group Sub Variable Karyawan | Data : '. json_encode($karyawanGroupSubVariable);
                   $_requestValue['tipe'] = 0;
                   $_requestValue['menu'] ='Karyawan';
                   $_requestValue['module'] = 'Class Karyawan';
                   $_requestValue['keterangan'] = $_keterangan;
                   $_requestValue['pic'] = $userLogin;

                   $c_class = new c_classHistory;
                   $c_class = $c_class->insertHistory($_requestValue);    

                   $result='success';
                }
                else
                {
                    DB::table('karyawan_group_sub_variable')
                    ->where('id_karyawan','=',$_idKaryawan)
                    ->where('id_variable','=',$idVariable)
                    ->update([
                        'nominal' =>$_nominal
                    ]);

                   // insert history
                   $_keterangan = 'Edit Group Sub Variable Karyawan | ID Karyawan : '. $_idKaryawan." ID Variable : ". $idVariable. " Nominal : ".$_nominal;
                   
                   $_requestValue['tipe'] = 0;
                   $_requestValue['menu'] ='Karyawan';
                   $_requestValue['module'] = 'Class Karyawan';
                   $_requestValue['keterangan'] = $_keterangan;
                   $_requestValue['pic'] = $userLogin;

                   $c_class = new c_classHistory;
                   $c_class = $c_class->insertHistory($_requestValue);  

                    $result='success';
                }
              }      
                return $result;
          } catch (\Exception $ex) {
                 // insert history
                 $_keterangan = 'Error--insertKaryawanGroupSubVariable--'.$ex;
                   
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Karyawan';
                 $_requestValue['module'] = 'Class Karyawan';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;

                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
                return response()->json($ex);
          }
    }

    // update Master Upah Karyawan
    // -->> update juga Variable BPJS Karyawan Master
    public function updateUpahkaryawanMaster($_idKaryawan,$_tipeBpjs,$_tanggalBergabung,$_tipeKontrak,$_noRekening,$_statusKaryawan,$_tipeGaji)
    {
        $userLogin = request()->session()->get('username');

        try
        {
            DB::beginTransaction();
                // cek masa kerja
                $_masaKerja = $this->getMasaKerja($_tanggalBergabung);

                    DB::table('users')
                    ->where('id_absen','=',$_idKaryawan)
                    ->update([
                        'tipe_kontrak' => $_tipeKontrak,
                        'doj' =>$_tanggalBergabung,
                        'masa_kerja' => $_masaKerja,
                        'no_rekening' => $_noRekening,
                        'tipe_bpjs' => $_tipeBpjs,
                        'status_skema_gaji'=> $_statusKaryawan,
                        'skema_gaji'=> $_tipeGaji
                    ]);

                // update variable BPJS Karayawan
                $this->updateVariableBPJSKaryawan($_idKaryawan, $_tipeBpjs);
                
            $result='success'; 
            DB::commit();   
            return $result;

        } catch (\Exception $ex) {
            DB::rollBack();
                // insert history
                $_keterangan = 'Error--updateUpahkaryawanMaster--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Karyawan';
                $_requestValue['module'] = 'Class Karyawan';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

     // update Variable BPJS Karyawan Master
     public function updateVariableBPJSKaryawan($_idKaryawan, $_tipeBpjs)
     {
        $userLogin = request()->session()->get('username');
         try
         {
             DB::beginTransaction();
                 // delete group_sub_variable
             
                 DB::table('karyawan_group_sub_variable_bpjs')->where('id_karyawan','=',$_idKaryawan)->delete();
         
                 // get variable bpjs
                 $varBpjs = DB::table('grouping_sub_variable_bpjs')
                 ->select('id_variable_bpjs as idVariableBpjs','id_bpjs as idBpjs',
                 'bpjs as bpjs','id_variable as idVariable','variable as variable','tipe_potongan as tipePotongan','tot_presentase as totPresentase',
                 'presentase as presentase','max_value as maxValue','max_value_nominal as maxValueNominal','nominal as nominal'
                 )
                 ->where('tipe_potongan','=',$_tipeBpjs)
                 ->where('isDell','=', '1')
                 ->get();
             
                 
                 $_nominal=0;
                 // get rumus (UPAH TETAP) code GS-001
                 $c_classRumus = new c_classRumus;
                 $_nominal = $c_classRumus->getRumus('GS-001',$_idKaryawan); 
         
                 foreach($varBpjs as $x)
                 {
                         $karGroupSubVarBpjs = new karyawan_group_sub_variable_bpjs();
                         $karGroupSubVarBpjs->id_karyawan = $_idKaryawan;
                         $karGroupSubVarBpjs->id_variable_bpjs = $x->idVariableBpjs; 
                         $karGroupSubVarBpjs->id_variable = $x->idVariable; 
                         $karGroupSubVarBpjs->variable = $x->variable; 
                         $karGroupSubVarBpjs->tipe_potongan = $x->tipePotongan; 
                     
                         $karGroupSubVarBpjs->tot_presentase = $x->totPresentase; 
                         $karGroupSubVarBpjs->presentasi = $x->presentase; 
                         $karGroupSubVarBpjs->max_value = $x->maxValue; 
                         $karGroupSubVarBpjs->max_value_nominal = $x->maxValueNominal; 
                         // nominal upah tetap
                         $karGroupSubVarBpjs->nominal = $_nominal; 
                         $karGroupSubVarBpjs->save();
                     
                         // nominal bpjs
                         $_val_bpjs=0;
                         if($_nominal >= $x->maxValue)
                         {
                             $_val_bpjs=$x->maxValueNominal;
                         }
                         else
                         {
                            $_presentase=0;
                            $_presentase = $x->presentase/100;
                            $_val_bpjs = ($_nominal*$_presentase);
                         }
                         
                         DB::table('karyawan_group_sub_variable')
                         ->where('id_karyawan','=',$_idKaryawan)
                         ->where('id_variable','=',$x->idVariable)
                         ->update([
                             'nominal' => $_val_bpjs
                         ]);
                 }
 
                 DB::commit();
                 return 'success';
             } catch (\Exception $ex) {
                 DB::rollBack();
                 // insert history
                 $_keterangan = 'Error--updateVariableBPJSKaryawan--'.$ex;
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Karyawan';
                 $_requestValue['module'] = 'Class Karyawan';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;
 
                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
             return response()->json($ex);
         }                  
     }


    // update Master Variable Upah Karyawan
    public function updateUpahkaryawanVariable($idKaryawan,$idVariable,$nominal)
    {
        $userLogin = request()->session()->get('username');

        try
        {

            DB::table('karyawan_group_sub_variable')
            ->where('id_karyawan','=',$idKaryawan)
            ->where('id_variable','=',$idVariable)
            ->update([
                'nominal' => $nominal
            ]);

            $result='success';   
            return $result;
        } catch (\Exception $ex) {
                // insert history
                $_keterangan = 'Error--updateUpahkaryawanVariable--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Karyawan';
                $_requestValue['module'] = 'Class Karyawan';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

    // public function insertGroupSub()
    // {
    //     try
    //     {
    //         DB::beginTransaction();
    //             $grupSub = DB::table('group_sub')
    //                 ->select('group_sub.id as id','group_sub.id_sub_group as idSubGroup','group_sub.sub_group as subGroup')
    //                 ->where('group_sub.isDell','1')
    //                 ->get();

    //             foreach($grupSub as $v)
    //             {
    //                     $karyawanGroupSub = new karyawan_group_sub();
    //                     $karyawanGroupSub->id_karyawan = $idAbsen;
    //                     $karyawanGroupSub->id_sub_group = $v->idSubGroup;
    //                     $karyawanGroupSub->nominal = 0;
    //                     $karyawanGroupSub->isDell = '1';
    //                     $karyawanGroupSub->save();
    //             }
    //         DB::commit(); 
    //         return 'success';
    //     } catch (\Exception $ex) {
    //         DB::rollBack();
    //         $err = [$ex];
    //         return response()->json($ex);
    //     }
    // }

    // public function insertGroup()
    // {
    //     try
    //     {
    //         DB::beginTransaction();
    //         $grup = DB::table('grup')
    //                 ->select('grup.id as id','grup.id_group as idGroup','grup.group as grup')
    //                 ->where('grup.isDell','1')
    //                 ->get();
                    
    //         foreach($grup as $x)
    //         {
    //             $karyawanGroup = new karyawan_group();
    //             $karyawanGroup->id_karyawan = $idAbsen;
    //             $karyawanGroup->id_group = $x->idGroup;
    //             $karyawanGroup->nominal = 0;
    //             $karyawanGroup->isDell = '1';
    //             $karyawanGroup->save();
    //         }
    //         DB::commit(); 
    //         return 'success';
    //     } catch (\Exception $ex) {
    //         DB::rollBack();
    //         $err = [$ex];
    //         return response()->json($ex);
    //     }
    // }

}
