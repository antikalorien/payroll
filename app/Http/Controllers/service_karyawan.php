<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class service_karyawan extends Controller
{
    public function update_masterUser()
    {
        try
        {
            $c_calass = new c_classApi;
            $_val = $c_calass->getUrlApi(); 
            $_url= $_val.'get_all_karyawan';

            $client = new \GuzzleHttp\Client();
            $request = $client->get($_url);
            $response = $request->getBody();
            $jsonDecode = json_decode($response);
   
            if($jsonDecode->status=='success')
            {
                // karyawan Acvie
                $lstKaryawanActive = $jsonDecode->karyawanActive;
                foreach($lstKaryawanActive as $x)
                {
                    $_users['id_departemen'] =  $x->id_departemen;
                    $_users['id_departemen_sub'] =  $x->id_departemen_sub;
                    $_users['pos'] =  $x->pos;
                    $_users['grade'] =  $x->id_grade;
                    $_users['id_absen'] =  $x->id_absen;       
                    $_users['username'] = $x->username;
                    $_users['name'] = $x->name; 
                    $_users['email'] = $x->email;
                    $_users['password'] =$x->id_absen; 
                    $_users['no_hp'] = $x->no_hp;
                    $_users['id_skema_hari_kerja'] = $x->id_skema_hari_kerja;
                    $_users['doj'] = $x->doj;
                    $_users['dob'] = $x->dob;
                    $_users['system'] = 1;
                    $_users['status'] = $x->status; 
                    $this->insertKarywan($_users);
                }

                // karyawan NonActive
                $listKaryawanNonActive = $jsonDecode->karyawanNonActive;
                {
                    foreach($lstKaryawanActive as $x)
                    {
                        $_users['id_departemen'] =  $x->id_departemen;
                        $_users['id_departemen_sub'] =  $x->id_departemen_sub;
                        $_users['pos'] =  $x->pos;
                        $_users['grade'] =  $x->id_grade;
                        $_users['id_absen'] =  $x->id_absen;       
                        $_users['username'] = $x->username;
                        $_users['name'] = $x->name; 
                        $_users['email'] = $x->email;
                        $_users['password'] =$x->id_absen; 
                        $_users['no_hp'] = $x->no_hp;
                        $_users['id_skema_hari_kerja'] = $x->id_skema_hari_kerja;
                        $_users['doj'] = $x->doj;
                        $_users['dob'] = $x->dob;
                        $_users['system'] = 1;
                        $_users['status'] = $x->status; 
                        $this->insertKarywan($_users);
                    }
                }
            }
            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }  
    }

    private function disableKaryawan()
    {
        try
        {

            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }  
    }

    private function insertKarywan($_users)
    {
        // cek data baru atau data lama
           $dtUser = DB::table('users')
           ->where('id_absen','=',$_users['id_absen']);
           if ($dtUser->doesntExist()) {  
            // data baru
            $c_karyawan = new c_classKaryawan;
            $_status = $c_karyawan->insertUsers($_users);
            
            $_nominal=0;
            // insertKaryawanGroupSubVariable($idkaryawan, $nominal)
            $c_karyawan = new c_classKaryawan;
            $_status = $c_karyawan->insertKaryawanGroupSubVariable($_users['id_absen'],$_nominal);   
        
            // insert Tunjangan Transport Karyawan
            $c_karyawan = new c_classPenggajian;
            $_status = $c_karyawan->updateTunjanganTransport($_users['id_absen']);
    
            // insert history
            $_keterangan = 'Menambahkan Karyawan | Data : '. json_encode($_users);

            $_requestValue['tipe'] = 0;
            $_requestValue['menu'] ='Master Data';
            $_requestValue['module'] = 'User Management';
            $_requestValue['keterangan'] = $_keterangan;
            $_requestValue['pic'] = 'System';
            }
            else
            {
                // Update Users
                $c_karyawan = new c_classKaryawan;
                $_status = $c_karyawan->editUsers($_users); 

                // update Tunjangan Transport Karyawan
                $c_karyawan = new c_classPenggajian;
                $_status = $c_karyawan->updateTunjanganTransport($_users['id_absen']);
           
                // insert history
                $_keterangan = 'Edit Karyawan | Data : '. json_encode($_users);
                
                $_requestValue['tipe'] = 1;
                $_requestValue['menu'] ='Master Data';
                $_requestValue['module'] = 'User Management';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = 'System';  
            }
                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);   

        $result = 'success';
        return $result;
    }
}
