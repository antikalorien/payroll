<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class c_classApi extends Controller
{
    public function getUrlApi()
    {
        try {
            $_value;
            $urlApi = DB::table('utility_api')
            ->select('utility_api.url_api as url')
            ->first();

            $_value=$urlApi->url;
            return $_value; 

           } catch (\Exception $ex) {
               return response()->json($ex);
           }
    }
}
