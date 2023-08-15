<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;

class c_classCredentials extends Controller
{
    public function getCredentials($password)
    {
        $userLogin = request()->session()->get('username');
        try {
            // cek login
            $dtUser = DB::table('users')
            ->where('username','=',$userLogin)
            ->orderBy('id','asc');
            if ($dtUser->exists()) {
                $user = $dtUser->first();
                    if (Crypt::decryptString($user->password) == $password) {
                        $result = 'success';
                        } else {
                        $result = 'Password Salah.';
                        }
            } else {
                $result = 'Username tidak terdaftar.';
            }
            return $result;
           } catch (\Exception $ex) {
               return response()->json($ex);
           }
    }
}
