<?php

namespace App\Imports;

use App\mod_user;
use App\Http\Controllers\c_classKaryawan;
use App\Http\Controllers\c_classHistory;
use App\Http\Controllers\c_classPenggajian;

use App\Http\Controllers\c_classPermissionAccess;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class penggajian_dataLembur_lemburKaryawan implements ToModel,WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    function __construct($idPeriode) {
        $this->idPeriode = $idPeriode;
    }
    

  public function model(array $row)
    {
        $userLogin = request()->session()->get('username');
        $idPeriode = $this->idPeriode;
        
        try {
            DB::beginTransaction();

            if($row['id']!='S01')
            {      
                $_jamLembur=0;
                $_idKaryawan = $row['id_absen']; 
                $_tglLembur = $row['tanggal_lembur']; 
                $_jamLembur = (float)$row['jam_lembur']; 
                $_keterangan = $row['keterangan']; 
   
                    // Hitung Lembur Karyawan
                    $c_classPenggajian = new c_classPenggajian;
                    $_val = $c_classPenggajian->tambahLembur($idPeriode,$_idKaryawan,$_tglLembur,$_jamLembur, $_keterangan);
                
                        // insert history
                        $_keterangan = 'Tambah Lembur-Import Excel ID Periode : ' . $idPeriode . ' ID Karyawan : '. $_idKaryawan . ' Tanggal : '. $_tglLembur. ' Jam Lembur : '. $_jamLembur. ' Keterangan : '. $_keterangan;
            
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Penggajian';
                        $_requestValue['module'] = 'Data Lembur';
                        $_requestValue['keterangan'] = $_keterangan;
                        $_requestValue['pic'] = $userLogin;

                        $c_class = new c_classHistory;
                        $c_class = $c_class->insertHistory($_requestValue);
            }  

        DB::commit();
      
    } catch (\Exception $ex) {
        DB::rollBack();
        dd($ex);
        return response()->json($ex);
    }
    }
}