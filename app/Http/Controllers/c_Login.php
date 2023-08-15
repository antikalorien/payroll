<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class c_Login extends Controller
{
    public function index() {
        if (session()->has('status')) {
            if (session()->get('status') == 'logged in') {
                return redirect('/');
            } else {
                return view('dashboard.login');
            }
        } else {
            return view('dashboard.login');
        }
    }

    public function submit(Request $request) {
        $username = $request->username;
        $password = $request->password;

        try {
            // cek akses
            $dtPermission = DB::table('sys_permission')
            ->select('sys_permission.id')
            ->join('users','users.username','sys_permission.username')
            ->where('users.id_absen','=',$username);

            if ($dtPermission->exists()) {
                
                // cek login
                $dtUser = DB::table('users')
                ->where('id_absen','=',$username)
                ->orderBy('id','desc');
            if ($dtUser->exists()) {
                $user = $dtUser->first();
                    if (Crypt::decryptString($user->password) == $password) {
                        $request->session()->put([
                            'id' => $user->id,
                            'status' => 'logged in',
                            'username' => $user->username,
                            'name' => $user->name,
                            'id_absen' =>$user->id_absen,
                            'system' => $user->system,
                            'created_at' => $user->created_at
                        ]);
                    
    
                        $result = 'success';
                        } else {
                        $result = 'Password salah.';
                        }
                } else {
                    $result = 'Username tidak terdaftar.';
                }

            }
            else
            {
                $result = 'Anda Tidak Mempunyai Akses Ke Aplikasi !!!';
            }

            return $result;
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function logout(Request $request) {
        try {
            $username = Session::get('id_absen');

            $request->session()->flush();
     
            return 'success';
        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }

    public function resetPassword() {
        if (Session::exists('username')) {
            return view('dashboard.reset-password');
        } else {
            return redirect('/');
        }
    }

    public function resetPasswordSubmit(Request $request) {
        $username = Session::get('username');
        $lama = $request->password_lama;
        $baru = $request->password_baru;

        try {
            DB::beginTransaction();
            $dtUser = DB::table('users')->where('username','=',$username)->first();
            if (Crypt::decryptString($dtUser->password) == $lama) {
                DB::table('users')->where('username','=',$username)
                    ->update([
                        'password' => Crypt::encryptString($baru)
                    ]);
                $result = 'success';
            } else {
                $result = 'password salah';
            }
            DB::commit();
            Session::flush();
            return $result;
        } catch (\Exception $ex) {
            $err = [$ex];
            return response()->json($err);
        }
    }
}
