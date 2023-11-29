<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class service_login extends Controller
{
    public function editPassword(Request $request) {        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        $username = $request->username;
        $lama = $request->password_lama;
        $baru = $request->password_baru;
        try {
            $dtUser = DB::table('users')->where('id_absen','=',$username)->first();
            if (Crypt::decryptString($dtUser->password) == $lama) {
            
                DB::table('users')->where('id_absen','=',$username)
                    ->update([
                        'password' => Crypt::encryptString($baru)
                    ]);
                    $result=response()->json([
                        'status' => 'success',
                        'message' => 'Update Password User Successfuly',
                    ]);
            } else {
                $result=response()->json([
                    'status' => 'failed',
                    'message' => 'Password Lama Anda Salah'
                ]);
            }
            return $result;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
}