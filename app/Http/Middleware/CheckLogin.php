<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('status')) {
            $status = $request->session()->get('status');
            if ($status !== 'logged in') {
                $username = Session::get('id_absen');
                DB::table('login_session')->where('id_karyawan','=',$username)->delete();
                return redirect('login');
            } else {
                return $next($request);
            }
        } else {
            return redirect('login');
        }
    }
}
