<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sysActivityHistory;

class c_classHistory extends Controller
{
    public function insertHistory($request)
    {
        try {
            $_tipe = $request['tipe'];
            $_menu = $request['menu'];
            $_module = $request['module'];
            $_keterangan = $request['keterangan'];
            $_pic = $request['pic'];
           

            // add to table log activity
            $activity = new sysActivityHistory();
            $activity->tipe = $_tipe;
            $activity->menu = $_menu;
            $activity->module = $_module; 
            $activity->keterangan = $_keterangan;
            $activity->pic = $_pic;
            $activity->save();

        } catch (\Exception $ex) {
            return response()->json($ex);
        }
    }
}
