<?php

namespace App\Http\Controllers;

use App\sysPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class c_classPermissionAccess extends Controller
{
    public function insertPermissionAccess($permission,$username)
    {
        $_permission = $permission;
        try
        {
            DB::table('sys_permission')->where('username',$username)->delete();
         
            foreach ($_permission as $p) 
            {
                $userPermission = new sysPermission();
                $userPermission->username = $username;
                $userPermission->id_menu = $p;
                $userPermission->save(); 
            }
            DB::commit(); 
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            $err = [$ex];
            return response()->json($ex);
        }
    }
}
