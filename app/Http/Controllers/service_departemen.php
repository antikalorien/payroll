<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class service_departemen extends Controller
{
    public function update_masterDepartemen()
    {
        try
        {
            $c_calass = new c_classApi;
            $_val = $c_calass->getUrlApi(); 
            $_url= $_val.'get_departemen';

            $client = new \GuzzleHttp\Client();
            $request = $client->get($_url);
            $response = $request->getBody();
            $jsonDecode = json_decode($response);

            $listDepartemen = $jsonDecode->periode;

            // delete Data
            $request=[];
            $request['id_departemen'] = '';
            $c_master_departemen = new c_master_departemen();
            $c_master_departemen->deleteDepartemen($request);

            // insert data
            foreach($listDepartemen as $v)
            {
                $request=[];
                $request['id_departemen'] = $v->id_dept;
                $request['departemen'] = $v->departemen;
                $c_master_subDepartemen = new c_master_departemen();
                $x = $c_master_subDepartemen->insertDepartemen($request);
            }
            return 'success';
            return $jsonDecode;
        } catch (\Exception $ex) {
            return $ex;
        }  
    }
}
