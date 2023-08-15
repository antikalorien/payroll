<?php

namespace App\Imports;
use App\mod_user;
use App\Http\Controllers\c_classKaryawan;
use App\Http\Controllers\c_classHistory;

use App\Http\Controllers\c_classPermissionAccess;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class UsersImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $userLogin = request()->session()->get('username');
        
        try {
            DB::beginTransaction();

            if($row['id']!='S01')
            {
                $_idDepartemen =  $row['id_departemen'];
                $_idDepartemenSub =  $row['id_departemen_sub'];
                $_pos =  $row['pos'];
                $_grade =  $row['grade'];
                $_idAbsen =  $row['id_absen'];       
                $_username = $row['nip'];
                $_name = $row['name']; 
                $_email = $row['email'];
                $_password = $_username; 
                $_idSkemaHariKerja = $row['id_skema_hari_kerja'];
                $_noHp = $row['no_hp'];
                $_tanggalBergabung = $row['tanggal_bergabung'];
                $_tanggalLahir = $row['tanggal_lahir'];
                $_system = $row['system'];
                
                    $_users['id_departemen'] =  $_idDepartemen;
                    $_users['id_departemen_sub'] =  $_idDepartemenSub;
                    $_users['pos'] =  $_pos;
                    $_users['grade'] =  $_grade;
                    $_users['id_absen'] =  $_idAbsen;       
                    $_users['username'] = $_username;
                    $_users['name'] = $_name; 
                    $_users['email'] = $_email;
                    $_users['password'] =$_password; 
                    $_users['no_hp'] = $_noHp;
                    $_users['id_skema_hari_kerja'] = $_idSkemaHariKerja;
                    $_users['doj'] = $_tanggalBergabung;
                    $_users['dob'] = $_tanggalLahir;
                    $_users['system'] = $_system;
                    $_users['status'] = '1';
               
                    // insert users
                    $c_karyawan = new c_classKaryawan;
                    $_status = $c_karyawan->insertUsers($_users);

                    $_nominal=0;
                    // insertKaryawanGroupSubVariable($idkaryawan, $nominal)
                    $c_karyawan = new c_classKaryawan;
                    $_status = $c_karyawan->insertKaryawanGroupSubVariable($_idAbsen,$_nominal);   

                     // insert history
                     $_keterangan = 'Menambahkan Karyawan - Import Excel | Data : '. json_encode($_users);
                    
                     $_requestValue['tipe'] = 0;
                     $_requestValue['menu'] ='Master Data';
                     $_requestValue['module'] = 'User Management';
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
