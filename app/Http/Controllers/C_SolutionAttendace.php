<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class C_SolutionAttendace extends Controller
{   
    public function getAttendaceToDevice() 
    {      
        try {
            DB::beginTransaction();
            
            $result = [
                'status' => 'success',
                    'users' => DB::table('users')
                    ->select('id_absen','name')
                    ->where('status','<>','0')
                    -orderBy('id','desc')
                    ->get(),
            ];
            return response()->json($result);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
