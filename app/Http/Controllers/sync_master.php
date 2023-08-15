<?php

namespace App\Http\Controllers;

use App\periode_jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class sync_master extends Controller
{   
    public function addPeriodeJadwal($jsonData)
    {
     
        try {
            DB::beginTransaction();

            DB::commit();
            return 'success';

            // $client = new \GuzzleHttp\Client();
            // $url = "http://testmyapi.com/api/blog";
            // $myBody['name'] = "Demo";
            // $request = $client->post($url,  ['body'=>$myBody]);
            // $response = $request->send();
    
            // dd($response);
            

            // $c_calass = new c_classApi;
            // $_val = $c_calass->getUrlApi(); 
            // $_url= $_val.'InsertPeriodeJadwal';

            // $response = Http::get($_url.'?json='.$jsonData);
       
            // $jsonData = $response->json();

            // if($jsonData=='success')
            // {
            //     DB::commit();
            //     return 'success';
            // }
            // else
            // {
            //     DB::rollBack();
            //     return 'failed';
            // }

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
