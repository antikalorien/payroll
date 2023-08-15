<?php

namespace App\Http\Controllers;

use App\karyawan_group;
use App\karyawan_group_sub;
use App\karyawan_group_sub_variable;
use App\karyawan_group_sub_variable_bpjs;
use App\gaji_lembur;
use App\gaji_karyawan;
use App\gaji_karyawan_sub_variable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use Carbon\Carbon;

class c_classPenggajian extends Controller
{
    ///////-------------------------------///////// Master Karyawan Periode
    // Add Data Karyawan Periode Penggajian
    public function addKaryawanMasterPeriode($_idPeriode,$_idKaryawan,$_pic)
    {
        try
        {
            DB::beginTransaction();
            // cek user departemen
            $data = DB::table('users')
            ->select('id_departemen as idDepartemen','id_departemen_sub as idDepartemenSub','id_absen as idKaryawan','username as nik',
            'id_skema_hari_kerja as idSkemaHariKerja','tipe_kontrak as tipeKontrak','users.status_skema_gaji as statusSkemaGaji','users.skema_gaji as skemaGaji',
            DB::raw('IFNULL(masa_kerja,0) as masaKerja'),
            DB::raw('IFNULL(usia,0) as usia'),
            'no_rekening as noRekening','tipe_bpjs as tipeBpjs')
            ->where('id_absen','=',$_idKaryawan)
            ->first();

            // add to table gaji karyawan
            $gajiKaryawan = new gaji_karyawan();
            $gajiKaryawan->id_periode = $_idPeriode;
            $gajiKaryawan->id_karyawan = $data->idKaryawan ;
            $gajiKaryawan->id_departemen = $data->idDepartemen; 
            $gajiKaryawan->id_departemen_sub = $data->idDepartemenSub ;
            $gajiKaryawan->nik = $data->nik;
            $gajiKaryawan->id_skema_hari_kerja = $data->idSkemaHariKerja;
            $gajiKaryawan->tipe_kontrak = $data->tipeKontrak;
            $gajiKaryawan->masa_kerja = $data->masaKerja;
            $gajiKaryawan->usia = $data->usia;     
            $gajiKaryawan->no_rekening = $data->noRekening;
            $gajiKaryawan->tipe_bpjs = $data->tipeBpjs; 
            $gajiKaryawan->status_skema_gaji = $data->statusSkemaGaji; 
            $gajiKaryawan->skema_gaji = $data->skemaGaji;  
            $gajiKaryawan->thp = 0;
            $gajiKaryawan->reff = $_pic;
            $gajiKaryawan->save();
        
                // add to table gaji karyawan sub variable
                // get variable
                $karGSV = DB::table('karyawan_group_sub_variable')
                ->select('id_variable as idVariable','nominal as nominal')
                ->where('id_karyawan',$_idKaryawan)
                ->get();
       
                foreach($karGSV as $x)
                {
                    // add to table gaji karyawan sub variable
                    $gajiKaryawanSubVar = new gaji_karyawan_sub_variable();
                    $gajiKaryawanSubVar->id_periode = $_idPeriode;
                    $gajiKaryawanSubVar->id_karyawan = $_idKaryawan ;
                    $gajiKaryawanSubVar->id_variable = $x->idVariable; 
                    $gajiKaryawanSubVar->nominal = $x->nominal ;
                    $gajiKaryawanSubVar->reff = $_pic;
                    $gajiKaryawanSubVar->save();
             
                }
                $_updateJmlKaryawanperiode= $this->updateJumlahKaryawanPeriodePenggajian($_idPeriode);
            
                DB::commit();   
            } catch (\Exception $ex) {
                DB::rollBack();
                    // insert history
                    $_keterangan = 'Error--addKaryawanMasterPeriode--'.$ex;
                    $_requestValue['tipe'] = 0;
                    $_requestValue['menu'] ='Penggajian';
                    $_requestValue['module'] = 'Class Penggajian';
                    $_requestValue['keterangan'] = $_keterangan;
                    $_requestValue['pic'] = '-';
                    $c_class = new c_classHistory;
                    $c_class = $c_class->insertHistory($_requestValue);  
                return response()->json($ex);
            }                  
    }

    // Hapus Data Karyawan dari Periode Penggajian
    public function deleteKaryawanMasterPeriode($_idPeriode,$_idKaryawan)
    {
       
        $idKaryawan = $_idKaryawan;
        $idPeriode = $_idPeriode;
        try
        {
            DB::beginTransaction();

            // (1) Delete From gaji_karyawan
                DB::table('gaji_karyawan')
                ->where('id_periode',$idPeriode)
                ->where('id_karyawan',$idKaryawan)->delete();
            // (2) Delete From gaji_karyawan_sub_variable
                DB::table('gaji_karyawan_sub_variable')
                ->where('id_periode',$idPeriode)
                ->where('id_karyawan',$idKaryawan)->delete();
            // (3) Delete From gaji_kehadiran_absensi
                DB::table('gaji_kehadiran_absensi')
                ->where('id_periode',$idPeriode)
                ->where('id_karyawan',$idKaryawan)->delete();
            // (4) Delete From gaji_lembur
                DB::table('gaji_lembur')
                ->where('id_periode',$idPeriode)
                ->where('id_karyawan',$idKaryawan)->delete();
            // (5) Update From gaji_periode
               $_updateJmlKaryawanperiode= $this->updateJumlahKaryawanPeriodePenggajian($idPeriode);
            // (6) Update From users
                 DB::table('users')
                    ->where('id_absen','=',$idKaryawan)
                    ->update([
                        'status' => '2',
                    ]);
      
            DB::commit();   
         
        } catch (\Exception $ex) {
            DB::rollBack();
                // insert history
                $_keterangan = 'Error--deleteKaryawanMasterPeriode--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Class Penggajian';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = '-';

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

    // update Jumlah Karyawan Periode Penggajian
    public function updateJumlahKaryawanPeriodePenggajian($_idPeriode)
    {
        $idPeriode = $_idPeriode;
        try
        {
            $_totKaryawanPeriodePenggajian=0;
            // calculate data from table gaji_karyawan
            $_data = DB::table('gaji_karyawan')
            ->select(DB::raw('COUNT(id) as totData'))
            ->where('id_periode',$idPeriode)
            ->first();
            $_totKaryawanPeriodePenggajian = $_data->totData;
            // update data from table gaji-periode
            DB::table('gaji_periode')
            ->where('id_periode','=',$idPeriode)
            ->update([
                'total_karyawan' => $_totKaryawanPeriodePenggajian,
            ]);

            return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }         
    }

    // update Data Master Upah Karyawan Periode
    // -->> update juga Variable BPJS Karyawan Master
    public function updateUpahkaryawanMasterPeriode($_idPeriode,$_idKaryawan,$_tipeBpjs,$_tanggalBergabung,$_tipeKontrak,$_noRekening,$_statusKaryawan,$_tipeGaji)
    {
        $userLogin = request()->session()->get('username');

        try
        {
            DB::beginTransaction();
                // cek masa kerja
                $c_classKaryawan = new c_classKaryawan();
                $_masaKerja = $c_classKaryawan->getMasaKerja($_tanggalBergabung);
             
                    DB::table('gaji_karyawan')
                    ->where('id_karyawan','=',$_idKaryawan)
                    ->where('id_periode','=',$_idPeriode)
                    ->update([
                        'tipe_kontrak' => $_tipeKontrak,        
                        'masa_kerja' => $_masaKerja,
                        'no_rekening' => $_noRekening,
                        'tipe_bpjs' => $_tipeBpjs,
                        'status_skema_gaji'=> $_statusKaryawan,
                        'skema_gaji'=> $_tipeGaji
                    ]);

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

                // update variable BPJS Karayawan Master
                $this->updateVariableBPJSKaryawanPeriode($_idPeriode,$_idKaryawan, $_tipeBpjs);
                
            $result='success'; 
            DB::commit();   
            return $result;

        } catch (\Exception $ex) {
            DB::rollBack();
                // insert history
                $_keterangan = 'Error--updateUpahkaryawanMasterPeriode--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Class Penggajian';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

    // update Variable BPJS Karyawan Master
    public function updateVariableBPJSKaryawanMaster($_idKaryawan, $_tipeBpjs)
    {
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
                        if($_nominal > $x->maxValue)
                        {
                            $_val_bpjs=$x->maxValueNominal;
                        }
                        else
                        {
                            $_val_bpjs = ($_nominal*($x->presentase/100));
                        }
                        
                        // master karyawan group sub variable 
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
                $_keterangan = 'Error--updateVariableBPJSKaryawanMaster--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Class Penggajian';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = '-';

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

    // update Data Bpsj Karyawan Periode
    // -->> update juga Variable BPJS Karyawan Periode
    public function updateBpjsKaryawanPeriode($_idPeriode,$_idKaryawan,$_tipeBpjs)
    {
        $userLogin = request()->session()->get('username');

        try
        {
            DB::beginTransaction();

                    DB::table('gaji_karyawan')
                    ->where('id_karyawan','=',$_idKaryawan)
                    ->where('id_periode','=',$_idPeriode)
                    ->update([
                        'tipe_bpjs' => $_tipeBpjs
                    ]);

                    DB::table('users')
                    ->where('id_absen','=',$_idKaryawan)
                    ->update([         
                        'tipe_bpjs' => $_tipeBpjs,
                    ]);

                // update variable BPJS Karayawan Periode
                $this->updateVariableBPJSKaryawanPeriode($_idPeriode,$_idKaryawan, $_tipeBpjs);

                // update vairalbe BPJS Karyawan Master
                $this->updateVariableBPJSKaryawanMaster($_idPeriode,$_idKaryawan, $_tipeBpjs);
                
            $result='success'; 
            DB::commit();   
            return $result;

        } catch (\Exception $ex) {
            DB::rollBack();
                // insert history
                $_keterangan = 'Error--updateUpahkaryawanMasterPeriode--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Class Penggajian';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

    // update bpjs periode 
    public function updateVariableBPJSKaryawanPeriode($_idPeriode,$_idKaryawan, $_tipeBpjs)
    {
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
                $_nominal = $c_classRumus->getRumusPenggajianPeriode('GS-001',$_idKaryawan,$_idPeriode); 
                
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
                        if($_nominal > $x->maxValue)
                        {
                            $_val_bpjs=$x->maxValueNominal;
                        }
                        else
                        {
                            $_val_bpjs = ($_nominal*($x->presentase/100));
                        }
                        
    
                        DB::table('gaji_karyawan_sub_variable')
                        ->where('id_periode','=',$_idPeriode)
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
                $_keterangan = 'Error--updateVariableBPJSKaryawanPeriode--'.$ex;
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Penggajian';
                $_requestValue['module'] = 'Class Penggajian';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = '-';

                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);  
            return response()->json($ex);
        }                  
    }

     // update Master Variable Upah Karyawan Periode
     public function updateUpahkaryawanVariablePeriode($idPeriode,$idKaryawan,$_idVariable,$nominal)
     {
         $userLogin = request()->session()->get('username');
       
         try
         {
            // cek keterangan
            if(substr($_idVariable,0,3)=='ket')
            {
                $idVariable=substr($_idVariable,4,6);
         
                $keterangan = $nominal;

                    DB::table('gaji_karyawan_sub_variable')
                    ->where('id_periode','=',$idPeriode)
                    ->where('id_karyawan','=',$idKaryawan)
                    ->where('id_variable','=',$idVariable)
                    ->update([
                        'keterangan' => $keterangan
                    ]);
            }
            else
            {
                $idVariable=$_idVariable;

                    DB::table('gaji_karyawan_sub_variable')
                    ->where('id_periode','=',$idPeriode)
                    ->where('id_karyawan','=',$idKaryawan)
                    ->where('id_variable','=',$idVariable)
                    ->update([
                        'nominal' => $nominal,
                    ]);

                    // DB::table('karyawan_group_sub_variable')
                    // ->where('id_karyawan','=',$idKaryawan)
                    // ->where('id_variable','=',$idVariable)
                    // ->update([
                    //     'nominal' => $nominal
                    // ]);
            }

             $result='success';   
             return $result;
         } catch (\Exception $ex) {
                 // insert history
                 $_keterangan = 'Error--updateUpahkaryawanVariablePeriode--'.$ex;
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Penggajian';
                 $_requestValue['module'] = 'Class Penggajian';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;
 
                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
             return response()->json($ex);
         }                  
     }

    // update Grade Transport Master Karyawan
    public function updateTunjanganTransport($idKaryawan)
    {
        $_dataUser = DB::table('users')
        ->select('users.id_absen as idAbsen','users.name as name','users.doj as doj','grade.nominal_tnj_transport as nominalTnjTransport','grade.interval_bln as intervalBln')
        ->join('grade','grade.id_grade','users.grade')
        ->where('users.id_absen',$idKaryawan)
        ->first();
       
         try
         {
             // cek masa kerja
             $c_classKaryawan = new c_classKaryawan();
             $_masaKerja = $c_classKaryawan->getMasaKerja($_dataUser->doj);

             if($_masaKerja >= $_dataUser->intervalBln)
             {
                DB::table('karyawan_group_sub_variable')
                ->where('id_karyawan','=',$idKaryawan)
                ->where('id_variable','=','VR-004')
                ->update([
                    'nominal' => $_dataUser->nominalTnjTransport
                ]);
             }
    
             $result='success';   
             return $result;
         } catch (\Exception $ex) {
                 // insert history
                 $_keterangan = 'Error--updateTunjanganTransport--'.$ex;
                 $_requestValue['tipe'] = 0;
                 $_requestValue['menu'] ='Penggajian';
                 $_requestValue['module'] = 'Class Penggajian';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = '-';
 
                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
             return response()->json($ex);
         }                  
    }


    ///////-------------------------------///////// GAJI
    // get ID Periode
    public function getPeriodeBerjalan()
    {
        try
        {
            $dtPeriode = DB::table('gaji_periode')
            ->select('gaji_periode.id_periode as idPeriode','gaji_periode.periode as periode','gaji_periode.total_karyawan as totalKaryawan')
            ->where('gaji_periode.pic','-')
            ->first();
           
            if( is_null($dtPeriode))
            {
                return $dtPeriode; 
            }
            else
            {
                return $dtPeriode; 
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

      // get ID Last Periode
      public function getLastPeriode()
      {
          try
          {
              $dtPeriode = DB::table('gaji_periode')
              ->select('gaji_periode.id_periode as idPeriode','gaji_periode.periode as periode','gaji_periode.total_karyawan as totalKaryawan')
              ->orderBy('gaji_periode.id_periode','desc')
              ->first();
             
              if( is_null($dtPeriode))
              {
                  return $dtPeriode; 
              }
              else
              {
                  return $dtPeriode; 
              }
          } catch (\Exception $ex) {
              DB::rollBack();
              return response()->json($ex);
          }
      }

    // calculate Tunjangan Transport 
    public function getTunjanganTransport($idKaryawan)
    {
        try
        {
          // get nominal Tunjangan Transport 
          $data =  DB::table('karyawan_group_sub_variable')
          ->select('karyawan_group_sub_variable.nominal as nominal')
          ->where('karyawan_group_sub_variable.id_karyawan',$idKaryawan)
          // code variable tunjangan Transport VR-004
          ->where('karyawan_group_sub_variable.id_variable','VR-004')
          ->first(); 
          return $data;
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    // calculate Data Lebur
    public function tambahLembur($idPeriode,$_idKaryawan,$_tglLembur,$_jamLembur,$_keterangan)
    {
        $userLogin = request()->session()->get('username');
        try
        {
            $karyawanMstGaji = DB::table('gaji_karyawan')
            ->select(
            'gaji_karyawan.id_departemen as idDepartemen',
            'gaji_karyawan.id_departemen_sub as idDepartemenSub',
            'gaji_karyawan.id_karyawan as idKaryawan')
            ->where('gaji_karyawan.id_karyawan',$_idKaryawan)
            ->where('gaji_karyawan.id_periode',$idPeriode)
            ->first();
            
            $_totUpah =0;
            $_jam = 0;
            $_jam = (float)$_jamLembur;
            $_totJam = 0;
            $_nomina = 0;
            if ($this->is_decimal($_jam)) {
                // decimal
                // jam lembur aktual - 1 = (hasil * 2(angka pasti)) + 1,5(angka pasti)
                $_totJam = (($_jam -1) *2)+1.5;
            } else {
                // not decimal
                // jam lembur aktual - 1 = (hasil * 2(angka pasti)) + 1,5(angka pasti) 
                $_totJam = (($_jam -1) *2)+1.5;
            }   

            // get rumus (Total Upah) code GS-001
            $_totalUpah=0;
            $c_classRumus = new c_classRumus;
            $_totalUpah = $c_classRumus->getRumus('GS-001',$_idKaryawan); 
       

            $_nominalLembur=0;
            $_batasNominalLembur=0;
            $_batasNominalLembur = $this->getNominalLembur();
            if($_totalUpah < $_batasNominalLembur || $_totalUpah == $_batasNominalLembur)
            {
                // get rumus (Nominal Lembur) code LM-001
                $_nominal=0;
                $c_classRumus = new c_classRumus;
                $_nominal = $c_classRumus->getRumus('LM-001',$_idKaryawan); 
                $_nominalLembur = $_nominal*$_totJam;
            }
            else
            {
                $_nominalLembur=0;
            }
         
            $dataLembur = new gaji_lembur();
            $dataLembur->id_periode = $idPeriode;
            $dataLembur->id_dept = $karyawanMstGaji->idDepartemen;
            $dataLembur->id_sub_dept = $karyawanMstGaji->idDepartemenSub; 
            $dataLembur->id_karyawan = $karyawanMstGaji->idKaryawan;
            $dataLembur->tgl = $_tglLembur;
            $dataLembur->jam_lembur = $_jamLembur;
            $dataLembur->total_upah = $_totalUpah;
            $dataLembur->total_jam =$_totJam;
            $dataLembur->nominal = $_nominalLembur;
            $dataLembur->keterangan = $_keterangan;
            $dataLembur->pic = $userLogin;
            $dataLembur->save();

            $result = $this->updateDataLemburKaryawanPeriode($idPeriode,$karyawanMstGaji->idKaryawan);
        
          return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    // get value max nominal lembur
    public function getNominalLembur()
    {
        $nominal =0;
        $_nominal = DB::table('utility_variable')
        ->select('nominal')
        ->where('id_variable','UV-002')
        ->first();
        $nominal = $_nominal->nominal;
        return $nominal;
    }

    public function deleteLembur($idPeriode,$_idKaryawan,$_id)
    {
        $userLogin = request()->session()->get('username');
        try
        {
            DB::table('gaji_lembur')
            ->where('id',$_id)
            ->where('id_periode',$idPeriode)
            ->where('id_karyawan',$_idKaryawan)
            ->delete(); 

            $this->updateDataLemburKaryawanPeriode($idPeriode,$_idKaryawan);
           
          return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function updateDataLemburKaryawanPeriode($idPeriode,$_idKaryawan)
    {
      
        try
        {
            $listLemburPeriode= DB::table('gaji_lembur')
            ->select('nominal as nominal')
            ->where('id_periode',$idPeriode)
            ->where('id_karyawan',$_idKaryawan)
            ->get();

            $_valLembur=0;
            foreach($listLemburPeriode as $v)
            {
                $_valLembur = $v->nominal+$_valLembur; 
            }
          
            // update nominal variable lembur karyawan
            DB::table('gaji_karyawan_sub_variable')
            ->where('id_periode',$idPeriode)
            ->where('id_karyawan',$_idKaryawan)
            // code variable lembur VR-006
            ->where('id_variable','VR-006')
            ->update([
                'nominal' => $_valLembur,
            ]);
            return 'success';

        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    function is_decimal($n) {
        // Note that floor returns a float 
        return is_numeric($n) && floor($n) != $n;
    }

    // calculate Take Home Pay (THP) Periode
    public function hitungThpAllPeriode($idPeriode)
    {
        try
        {
            DB::beginTransaction();
            // thp = bruto - total potongan - koperasi
            // *bruto = upah tetap + upah variable
            // *total potongan = potongan bpjs, absensi + hutang + lain-lain

            // upah tetap = GS-001, upah variable = GS-002, potongan = GS-003, potongan BPJS = GS-004, Potongan Koperasi = GS-005
                // getAll karyawan
                $listKaryawanGaji = DB::table('gaji_karyawan')
                ->select('gaji_karyawan.id_karyawan as idKaryawan','gaji_karyawan.skema_gaji as skemaGaji')
                ->where('gaji_karyawan.id_periode',$idPeriode)
                ->get();
      
                // get bruto
                foreach($listKaryawanGaji as $v)
                {

                    $_bruto=0;
                    $bruto=0;
                    $thp=0;

                    $c_classRumus = new c_classRumus;
                    $_bruto = $c_classRumus->getRumusPenggajianPeriode('GR-001',$v->idKaryawan,$idPeriode); 
               
                    // skema Normal
                    if($v->skemaGaji=='1')
                    {$bruto=$_bruto;}
                    // skema Harian (Prorate)
                    elseif($v->skemaGaji=='2')
                    {
                        // cek gaji harian
                        $dtGajiProrate = DB::table('gaji_kehadiran_absensi')
                        ->select('gaji_kehadiran_absensi.upah_harian as upahHarian','gaji_kehadiran_absensi.tot_masuk as totMasuk','gaji_kehadiran_absensi.tot_cuti as totCuti')
                        ->where('gaji_kehadiran_absensi.id_periode',$idPeriode)
                        ->where('gaji_kehadiran_absensi.id_karyawan',$v->idKaryawan);
                        if ($dtGajiProrate->doesntExist()){
                            // tidak ada data absen
                            
                        }  
                        else
                        {
                            $_dtGajiProrate=$dtGajiProrate->first();
                            $_gajiHarian=0;
                            $_totMasuk=0;
                            $bruto1=0;
                            $bruto2=0;
                            $bruto=0;
                            $_upahVariable=0;
                            $_gajiHarian = $_dtGajiProrate->upahHarian;
                            $_totMasuk = $_dtGajiProrate->totMasuk;
                            $_totCuti = $_dtGajiProrate->totCuti;

                            // Upah Variable
                            $c_classRumus = new c_classRumus;
                            $_upahVariable = $c_classRumus->getRumusPenggajianPeriode('GS-002',$v->idKaryawan,$idPeriode);
    
                            $bruto1 = ($_gajiHarian*$_totMasuk);
                            $bruto2 = ($_gajiHarian*$_totCuti);
                            $bruto = $bruto1+$bruto2+$_upahVariable;
                            
                    
    
                               DB::table('gaji_karyawan_sub_variable')
                               ->where('id_periode',$idPeriode)
                               ->where('id_karyawan',$v->idKaryawan)
                               // code variable Alfa VR-010
                               ->where('id_variable','VR-010')
                               ->update([
                                       'nominal' => 0,
                               ]);
                       
                               DB::table('gaji_karyawan_sub_variable')
                               ->where('id_periode',$idPeriode)
                               ->where('id_karyawan',$v->idKaryawan)
                               // code variable Ijin VR-011
                               ->where('id_variable','VR-011')
                               ->update([
                                       'nominal' => 0,
                               ]);
                            
      
                        }
                    }
                    // sekam 50%
                    elseif($v->skemaGaji=='3')
                    {
            
                            $_bruto=0;
                            $c_classRumus = new c_classRumus;
                            $_upahTetap = $c_classRumus->getRumusPenggajianPeriode('GS-001',$v->idKaryawan,$idPeriode);
                            
                              // Upah Variable
                            $c_classRumus = new c_classRumus;
                            $_upahVariable = $c_classRumus->getRumusPenggajianPeriode('GS-002',$v->idKaryawan,$idPeriode);
                            $_bruto=($_upahTetap/2);
                         
                            $bruto=$_bruto+$_upahVariable;
                
                   
                    }
                 
                    $_totalPotongan=0;
                    $c_classRumus = new c_classRumus;
                    $_totalPotongan = $c_classRumus->getRumusPenggajianPeriode('GR-002',$v->idKaryawan,$idPeriode); 
                    
                    $thp=$bruto-$_totalPotongan;
                    // update thp
                    DB::table('gaji_karyawan')
                    ->where('id_periode','=',$idPeriode)
                    ->where('id_karyawan','=',$v->idKaryawan)
                    ->update([
                        'thp' => $thp
                    ]);
          
                }
             
                $result='success';
                DB::commit();
                return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

     // calculate Gaji Harian
     public function hitungGajiHarianKaryawan($idKaryawan,$totHariKerja)
     {
         try
         {
            $result=0;
            $c_classRumus = new c_classRumus;
            $_upahTetap = $c_classRumus->getRumus('GS-001',$idKaryawan);
            $_totSkemaHari=$totHariKerja; 
            $result = $_upahTetap/$_totSkemaHari;

            return $result;
         } catch (\Exception $ex) {
             return response()->json($ex);
         }
     }
}
