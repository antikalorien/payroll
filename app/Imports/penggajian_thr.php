<?php

namespace App\Imports;

use App\gaji_thr;
use App\gaji_thr_variable;
use App\Http\Controllers\c_classHistory;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class penggajian_thr implements ToModel,WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    function __construct($idPeriode,$reff) {
        $this->idPeriode = $idPeriode;
        $this->reff = $reff;
    }
    

  public function model(array $row)
    {
        $userLogin = request()->session()->get('username');
        $idPeriode = $this->idPeriode;
        $reff = $this->reff;

        try {
            DB::beginTransaction();
            $data='';
            if($row['id']!='S01')
            {      
                $idPeriode = $row['id_periode']; 
                $nip = $row['nip']; 
                $name = $row['name']; 
                $masaKerja = $row['masa_kerja']; 
                $noRekening = $row['no_rekening'];
                $totalThr = $row['total_thr'];
                $gajiPokok = $row['gaji_pokok']; // VR-001
                $tunjanganJabatan = $row['tunjangan_jabatan']; // VR-002
                $tunjanganKeahlian = $row['tunjangan_keahlian']; // VR-003
                $data=$row;
                // get Data Users
                $dtUser = DB::table('users')
                ->select('id_departemen','id_departemen_sub','id_absen','no_rekening','masa_kerja')
                ->where('username',$nip)
                ->orderBy('id','desc')
                ->first();
                
                $idKaryawan = $dtUser->id_absen;
                $idDepartemen = $dtUser->id_departemen;
                $idDepartemenSub = $dtUser->id_departemen_sub;
                $tipeThr='';
                if($masaKerja<12)
                {
                    $tipeThr='0';// prorate
                }
                else
                {
                    $tipeThr='1';// full
                }

                // insert table gaji_thr
                $gajiThr = new gaji_thr();
                $gajiThr->id_periode = $idPeriode;
                $gajiThr->id_karyawan = $idKaryawan; 
                $gajiThr->id_departemen = $idDepartemen; 
                $gajiThr->id_departemen_sub = $idDepartemenSub; 
                $gajiThr->nik = $nip; 
                $gajiThr->masa_kerja = $masaKerja; 
                $gajiThr->no_rekening = $noRekening; 
                $gajiThr->tipe_thr = $tipeThr; 
                $gajiThr->thr = $totalThr; 
                $gajiThr->reff = $reff; 
                $gajiThr->save();

                // insert table gaji_thr_variable
                $gajiThrVariable = new gaji_thr_variable();
                $gajiThrVariable->id_periode = $idPeriode;
                $gajiThrVariable->id_karyawan = $idKaryawan; 
                $gajiThrVariable->id_variable = 'VR-001'; 
                $gajiThrVariable->nominal = $gajiPokok; 
                $gajiThrVariable->keterangan = '-'; 
                $gajiThrVariable->status = '-'; 
                $gajiThrVariable->reff = $reff; 
                $gajiThrVariable->save();
                
                $gajiThrVariable = new gaji_thr_variable();
                $gajiThrVariable->id_periode = $idPeriode;
                $gajiThrVariable->id_karyawan = $idKaryawan; 
                $gajiThrVariable->id_variable = 'VR-002'; 
                $gajiThrVariable->nominal = $tunjanganJabatan; 
                $gajiThrVariable->keterangan = '-'; 
                $gajiThrVariable->status = '-'; 
                $gajiThrVariable->reff = $reff; 
                $gajiThrVariable->save();

                $gajiThrVariable = new gaji_thr_variable();
                $gajiThrVariable->id_periode = $idPeriode;
                $gajiThrVariable->id_karyawan = $idKaryawan; 
                $gajiThrVariable->id_variable = 'VR-003'; 
                $gajiThrVariable->nominal = $tunjanganKeahlian; 
                $gajiThrVariable->keterangan = '-'; 
                $gajiThrVariable->status = '-'; 
                $gajiThrVariable->reff = $reff; 
                $gajiThrVariable->save();
            }  
        DB::commit();
    } catch (\Exception $ex) {
        DB::rollBack();
        return response()->json($ex);
    }
    }
}