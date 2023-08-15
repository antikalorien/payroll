<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use App\Http\Controllers\Controller;

class c_classRumus extends Controller
{
    public function getRumus($_idRumus,$_idKaryawan)
    {
        try {
         $_nominal=0;
         $_nominal_val=0;
       
         $getRumus = DB::table('group_rumus')
         ->select('group_rumus.id_rumus as idRumus','group_rumus_detail.id_variable as idVariable','group_rumus_detail.variable as variable')
         ->join('group_rumus_detail','group_rumus_detail.id_rumus','group_rumus.id_rumus')
         ->where('group_rumus.id_group','=',$_idRumus)
         ->orderBy('group_rumus_detail.ord','asc')
         ->get();

         // parse rumus
         $_firstLoad=true;
      
         $_operation;
         foreach($getRumus as $r)
         {
          
             $_isOperation=false;
             $_var = $r->idVariable;
    
             // select table karyawan_group_sub_variable (Code VR)
             if(substr($_var,0,2)=='VR')
             {
                 $_valVar = DB::table('karyawan_group_sub_variable')
                 ->select('id_variable as idVariable','nominal as nominal');
 
                 $_valVar->where('id_variable',$_var)
                 ->where('id_karyawan',$_idKaryawan);
                 $_val=$_valVar->first();
                
                 $_nominal_val=$_val->nominal;
             }
             // select table karyawan_group_sub_variable (Code GS)
             elseif(substr($_var,0,2)=='GS')
             {
                 $_valVar = DB::table('karyawan_group_sub')
                 ->select('id_sub_group as idSubGroup','nominal as nominal');
 
                 $_valVar->where('id_variable',$_var)
                 ->where('id_karyawan',$_idKaryawan);
                 $_val=$_valVar->first();
                
                 $_nominal_val=$_val->nominal;
             }
             // select table karyawan_group_sub_variable (Code UV)
             elseif(substr($_var,0,2)=='UV')
             {
                 $_valVar = DB::table('utility_variable')
                 ->select('id_variable as idVariable','nominal as nominal')
                 ->where('id_variable',$_var)
                 ->first();
                
                 $_nominal_val=$_valVar->nominal;
             }
             elseif(substr($_var,0,2)=='OP')
             {
                 $_isOperation=true;
                 $_operation=$r->variable;
             
             }
         
           
            
             if($_firstLoad==true)
             {
                 $_nominal=$_nominal_val;
                 $_firstLoad=false;
              
             }
             else
             {
             
              
                 if($_isOperation==true)
                 {
                     $_isOperation=false;
                 }
                 else
                 {
                 // penjumlahan
                 if($_operation=='+')
                 {
                     $_nominal=$_nominal + $_nominal_val;
                 }
                 // pengurangan
                 elseif($_operation=='-')
                 {
                     $_nominal=$_nominal - $_nominal_val;
                 }
                 // pembagian
                 elseif($_operation=='/')
                 {
                   $_nominal=$_nominal / $_nominal_val;
                 }
                 // perkalian
                 elseif($_operation=='*')
                 {
                     $_nominal=$_nominal * $_nominal_val;
                 }
                 
                 }
            }
        }
        return $_nominal; 
        } catch (\Exception $ex) {
     
            return response()->json($ex);
        }
    }

    public function getRumusPenggajianPeriode($_idRumus,$_idKaryawan,$_idPeriode)
    {
        try {
         $_nominal=0;
         $_nominal_val=0;
       
         $getRumus = DB::table('group_rumus')
         ->select('group_rumus.id_rumus as idRumus','group_rumus_detail.id_variable as idVariable','group_rumus_detail.variable as variable')
         ->join('group_rumus_detail','group_rumus_detail.id_rumus','group_rumus.id_rumus')
         ->where('group_rumus.id_group','=',$_idRumus)
         ->get();

         // parse rumus
         $_firstLoad=true;
      
         $_operation;
         foreach($getRumus as $r)
         {
          
             $_isOperation=false;
             $_var = $r->idVariable;
    
             // select table karyawan_group_sub_variable (Code VR)
             if(substr($_var,0,2)=='VR')
             {
                 $_valVar = DB::table('gaji_karyawan_sub_variable')
                 ->select('id_variable as idVariable','nominal as nominal');
 
                 $_valVar->where('id_variable',$_var)
                 ->where('id_karyawan',$_idKaryawan)
                 ->where('id_periode',$_idPeriode);
                 $_val=$_valVar->first();
                
                 $_nominal_val=$_val->nominal;
             }
             // select table karyawan_group_sub_variable (Code GS)
             elseif(substr($_var,0,2)=='GS')
             {
                 $_valVar = DB::table('karyawan_group_sub')
                 ->select('id_sub_group as idSubGroup','nominal as nominal');
 
                 $_valVar->where('id_variable',$_var)
                 ->where('id_karyawan',$_idKaryawan);
                 $_val=$_valVar->first();
                
                 $_nominal_val=$_val->nominal;
             }
             // select table karyawan_group_sub_variable (Code UV)
             elseif(substr($_var,0,2)=='UV')
             {
                 $_valVar = DB::table('utility_variable')
                 ->select('id_variable as idVariable','nominal as nominal')
                 ->where('id_variable',$_var)
                 ->first();
                
                 $_nominal_val=$_valVar->nominal;
             }
             elseif(substr($_var,0,2)=='OP')
             {
                 $_isOperation=true;
                 $_operation=$r->variable;
             
             }
         
           
            
             if($_firstLoad==true)
             {
                 $_nominal=$_nominal_val;
                 $_firstLoad=false;
              
             }
             else
             {
             
              
                 if($_isOperation==true)
                 {
                     $_isOperation=false;
                 }
                 else
                 {
                 // penjumlahan
                 if($_operation=='+')
                 {
                     $_nominal=$_nominal + $_nominal_val;
                 }
                 // pengurangan
                 elseif($_operation=='-')
                 {
                     $_nominal=$_nominal - $_nominal_val;
                 }
                 // pembagian
                 elseif($_operation=='/')
                 {
                   $_nominal=$_nominal / $_nominal_val;
                 }
                 // perkalian
                 elseif($_operation=='*')
                 {
                     $_nominal=$_nominal * $_nominal_val;
                 }
                 
                 }
            }
        }
        return $_nominal; 
        } catch (\Exception $ex) {
     
            return response()->json($ex);
        }
    }
}
