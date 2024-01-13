<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class service_subDepartemen extends Controller
{
    public function update_masterSubDepartemen()
    {
        try
        {
            $c_calass = new c_classApi;
            $_val = $c_calass->getUrlApi(); 
            $_url= $_val.'get_sub_departemen';

            $client = new \GuzzleHttp\Client();
            $request = $client->get($_url);
            $response = $request->getBody();
            $jsonDecode = json_decode($response);
        
            $listSubDepartemen = $jsonDecode->periode;
            // delete Data
            $request=[];
            $request['id_departemen'] = '';
            $request['id_subDepartemen'] = '';
            $c_master_subDepartemen = new c_master_subDepartemen();
            $c_master_subDepartemen->deleteSubDepartemen($request);

            // insert data
            foreach($listSubDepartemen as $v)
            {
                $request=[];
                $request['id_departemen'] = $v->id_dept;
                $request['id_subDepartemen'] = $v->id_subDepartemen;
                $request['sub_departemen'] = $v->sub_departemen;
                $c_master_subDepartemen = new c_master_subDepartemen();
                $c_master_subDepartemen->insertSubDepartemen($request);
            }
            return 'success';
        } catch (\Exception $ex) {
            return $ex;
        }  
    }
}
