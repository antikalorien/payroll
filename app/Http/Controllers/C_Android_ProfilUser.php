<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class C_Android_ProfilUser extends Controller
{
    public function getUserProfil(Request $request) {
        $username = $request->username;
   
        try {
            $result = [];
       
                        $result = [
                            'status' => 'success',
                            'data' => DB::table('users')
                                ->select('id','username','name','no_hp')
                                ->where('username','=',$username)->first()
                        ];
           
            return response()->json($result);
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function updateUserProfil(Request $request) {
        $username = $request->username;
        $password = $request->password;
        $nama = $request->nama;
        $telephone = $request->telephone;
        try {
            $result = [];

            $stringLength = Str::length($password);

            if($stringLength>0)
            {
                DB::table('users')
                ->where('username','=',$username)
                ->update([
                    'name' => $nama,  
                    'no_hp' => $telephone,
                    'password' => Crypt::encryptString($password),
                ]);
            }
            else
            {
                DB::table('users')
                ->where('username','=',$username)
                ->update([
                    'name' => $nama,  
                    'no_hp' => $telephone,
                ]);
            }
     
                        $result = [
                            'status' => 'success',
                            'data' => 'Berhasil Update Data',
                        ];
           
            return response()->json($result);
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }
}
