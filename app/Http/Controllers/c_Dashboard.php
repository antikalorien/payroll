<?php

namespace App\Http\Controllers;

use App\msPenumpang;
use App\msTiket;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class c_Dashboard extends Controller
{
    public static function sidebar()
    {
        $username = request()->session()->get('username');

        if ($username == '02-1220-586') {
            $group = DB::table('sys_menus')
                ->select('sys_menu_groups.id', 'sys_menu_groups.name', 'sys_menu_groups.segment_name', 'sys_menu_groups.icon', 'sys_menu_groups.ord', 'sys_menu_groups.status', 'sys_menu_groups.created_at', 'sys_menu_groups.updated_at')
                ->join('sys_menu_groups', 'sys_menus.id_group', '=', 'sys_menu_groups.id')
                ->orderBy('sys_menu_groups.ord', 'asc')
                ->distinct()
                ->get();

            $dtMenu = DB::table('sys_menus')
                ->select('sys_menus.id', 'sys_menus.id_group', 'sys_menus.name', 'sys_menus.segment_name', 'sys_menus.url', 'sys_menus.ord', 'sys_menus.status', 'sys_menus.created_at', 'sys_menus.updated_at')
                ->orderBy('sys_menus.ord', 'asc')
                ->get();

            $menu = [];
            foreach ($dtMenu as $m) {
                $menu[$m->id_group][] = [
                    'id' => $m->id,
                    'id_group' => $m->id_group,
                    'name' => $m->name,
                    'segment_name' => $m->segment_name,
                    'url' => $m->url,
                    'ord' => $m->ord,
                    'created_at' => $m->created_at,
                    'updated_at' => $m->updated_at,
                ];
            }
        } else {
            $group = DB::table('sys_permission')
                ->select('sys_menu_groups.id', 'sys_menu_groups.name', 'sys_menu_groups.segment_name', 'sys_menu_groups.icon', 'sys_menu_groups.ord', 'sys_menu_groups.created_at', 'sys_menu_groups.status', 'sys_menu_groups.updated_at')
                ->join('sys_menus', 'sys_permission.id_menu', '=', 'sys_menus.id')
                ->join('sys_menu_groups', 'sys_menus.id_group', '=', 'sys_menu_groups.id')
                ->where('sys_permission.username', '=', $username)
                ->where('sys_menu_groups.status', '<>', 1)
                ->orderBy('sys_menu_groups.ord', 'asc')
                ->distinct()
                ->get();

            $dtMenu = DB::table('sys_permission')
                ->select('sys_menus.id', 'sys_menus.id_group', 'sys_menus.name', 'sys_menus.segment_name', 'sys_menus.url', 'sys_menus.ord', 'sys_menus.status', 'sys_menus.created_at', 'sys_menus.updated_at')
                ->join('sys_menus', 'sys_permission.id_menu', '=', 'sys_menus.id')
                ->where('sys_permission.username', '=', $username)
                ->where('sys_menus.status', '<>', 1)
                ->orderBy('sys_menus.ord', 'asc')
                ->get();

            $menu = [];
            foreach ($dtMenu as $m) {
                $menu[$m->id_group][] = [
                    'id' => $m->id,
                    'id_group' => $m->id_group,
                    'name' => $m->name,
                    'segment_name' => $m->segment_name,
                    'url' => $m->url,
                    'ord' => $m->ord,
                    'status' => $m->status,
                    'created_at' => $m->created_at,
                    'updated_at' => $m->updated_at,
                ];
            }
        }

        $i = 0;
        $sidebar = [];
        foreach ($group as $g) {
            $sidebar[$i]['group'] = [
                'name' => $g->name,
                'segment_name' => $g->segment_name,
                'icon' => $g->icon,
                'status' => $g->status,
            ];
            $sidebar[$i]['menu'] = $menu[$g->id];
            $i++;
        }
        return $sidebar;
    }

   

    public function listDepartemen(Request $request)
    {
        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('departemen')
                ->select('id_dept as id','departemen as text')
                ->where('departemen', 'like', '%' . $_GET['search'] . '%')
                ->where('isDell','=','1')
                ->orderBy('departemen', 'asc')
                ->get();
        } else {
            $data['results'] = DB::table('departemen')
                ->select('id_dept as id', 'departemen as text')
                ->orderBy('departemen', 'asc')
                ->where('isDell','=','1')
                ->get();
        }
        return $data;
    }

    public function listSubDepartemen($id)
    {
        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('departemen_sub')
                ->select('id_subDepartemen as id','sub_departemen as text')
                ->where('sub_departemen', 'like', '%' . $_GET['search'] . '%')
                ->where('id_departemen',$id)
                ->where('isDell','=','1')
                ->orderBy('sub_departemen', 'asc')
                ->get();
        } else {
            $data['results'] = DB::table('departemen_sub')
                ->select('id_subDepartemen as id', 'sub_departemen as text')
                ->orderBy('sub_departemen', 'asc')
                ->where('id_departemen',$id)
                ->where('isDell','=','1')
                ->get();
        }
       
        return $data;
    }
    
    public function listGrade(Request $request)
    {
        $data = [];
        $_data = DB::table('grade')
        ->select('id_grade as id','level as text')
        ->where('isDell','=','1')
        ->orderBy('id_grade', 'asc');

        if (isset($_GET['search'])) {
            $_data->where('level', 'like', '%' . $_GET['search'] . '%');
        } else {
            // nothing
        }
        
        $data['results'] = $_data->get();
        return $data;
    }

   
    
    public function skemaHariKerja(Request $request)
    {
        $data = [];
        if (isset($_GET['search'])) {
            $data['results'] = DB::table('skema_hari_kerja')
            ->select('id_skema as id', DB::raw('concat("SKEMA " ,skema,"  | ", jml_hari," Hari") as text'))
                ->where('jml_hari', 'like', '%' . $_GET['search'] . '%')
                ->orderBy('skema', 'asc')
                ->where('isDell','=','1')
                ->get();
        } else {
            $data['results'] = DB::table('skema_hari_kerja')
            ->select('id_skema as id', DB::raw('concat("SKEMA " ,skema,"  | ", jml_hari," Hari") as text'))
                ->orderBy('skema', 'asc')
                ->where('isDell','=','1')
                ->get();
        }
        return $data;
    }

    public function listPeriode(Request $request)
    {
        $data = [];
        $_data = DB::table('periode_jadwal')
        ->select('id_periode as id','periode as text')
        ->orderBy('id_periode', 'desc');

        if (isset($_GET['search'])) {
            $_data->where('periode', 'like', '%' . $_GET['search'] . '%');
        } else {
            // nothing
        }
        
        $data['results'] = $_data->get();
        return $data;
    }

    public function listPeriodeSuccess(Request $request)
    {
        $data = [];
        $_data = DB::table('gaji_periode')
        ->select('id_periode as id','periode as text')
        ->orderBy('id_periode', 'desc')
        ->where('reff','!=','-')
        ->where('pic','!=','-');

        if (isset($_GET['search'])) {
            $_data->where('periode', 'like', '%' . $_GET['search'] . '%');
        } else {
            // nothing
        }
        
        $data['results'] = $_data->get();
        return $data;
    }

    
}
