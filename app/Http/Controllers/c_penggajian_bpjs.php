<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// model
use App\Exports\export_penggajianBpjsAllData;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class c_penggajian_bpjs extends Controller
{
    public function index() {
        return view('dashboard.penggajian.bpjs.baru');
    }

    public function list() {
        return view('dashboard.penggajian.bpjs.list');
    }

    public function data() {
    // get ID Periode
    $c_classPenggajian = new c_classPenggajian;
    $_val = $c_classPenggajian->getPeriodeBerjalan(); 
    if( is_null($_val))
    {
    // nothing

    }
    else
    {
        // get Data Periode
        $periode = $_val;
        $idPeriode=$periode->idPeriode;
        $data['data'] =  DB::table('gaji_karyawan')
        ->select(
        'gaji_karyawan.id_karyawan as id',
        'departemen.departemen as id_departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'grade.level as grade',
        'users.doj as doj',
        'gaji_karyawan.id_karyawan as id_absen',
        'gaji_karyawan.nik as username',
        'users.name as name',
        'users.tipe_bpjs as tipeBpjs',
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKes"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTk"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJp"),

         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-017' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKesPerusahaan"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-013' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTkPerusahaan"),
         DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-015' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJpPerusahaan"),
         'gaji_karyawan.updated_at as updatedAt')
         
         ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
         ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
         ->join('grade','grade.id_grade','users.grade')
         ->where('gaji_karyawan.id_periode',$idPeriode)
         ->get();

         $data['total'] = DB::table('gaji_karyawan_sub_variable')
         ->select(
            'gaji_karyawan_sub_variable.id_karyawan as idKaryawan',

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsTk"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsJp"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsKesehatan"),

            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-013' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsTkPerusahaan"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-015' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsJpPerusahaan"),
            DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-017' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotalBpjsKesPerusahaan"),

         )
         ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
         ->groupBy('gaji_karyawan_sub_variable.id_karyawan')
         ->first();
      
    }
        return json_encode($data);
    }

    public function dataEdit($idKaryawan) {
       // get ID Periode
       $c_classPenggajian = new c_classPenggajian;
       $_val = $c_classPenggajian->getPeriodeBerjalan(); 
       if( is_null($_val))
       {
       // nothing
       }
       else
       {
         // get Data Periode
         $periode = $_val;
         $idPeriode=$periode->idPeriode;

        $data['user'] = DB::table('gaji_karyawan')
        ->select('departemen.departemen as departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'users.grade as idGrade',
        'grade.level as grade',
        'gaji_karyawan.id_karyawan as idAbsen',
        'gaji_karyawan.nik as nik',
        'users.name as name',
        'users.email as email',
        'users.no_hp as noHp',
        'skema_hari_kerja.skema',
        'gaji_karyawan.tipe_kontrak as tipeKontrak',
        'users.doj as doj',
        'gaji_karyawan.masa_kerja as masaKerja',
        'gaji_karyawan.usia as usia',
        'gaji_karyawan.no_rekening as noRekening',
        'gaji_karyawan.tipe_bpjs as tipeBpjs',
        'gaji_karyawan.status_skema_gaji as statusSkemaGaji',
        'gaji_karyawan.skema_gaji as skemaGaji',
        'users.created_at as created_at')
        ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
        ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
        ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
        ->join('skema_hari_kerja','skema_hari_kerja.id_skema','gaji_karyawan.id_skema_hari_kerja')
        ->join('grade','grade.id_grade','users.grade')
        ->where('gaji_karyawan.id_karyawan','=',$idKaryawan)
        ->where('gaji_karyawan.id_periode','=',$idPeriode)
        ->limit(1)
        ->first();
        }

        $dtCheck = DB::table('gaji_karyawan_sub_variable')
        ->select('id_variable')
        ->where('status','1')
        ->where('id_karyawan', $idKaryawan)
        ->where('id_periode',$idPeriode)
        ->get();
      
            $check = [];
            foreach ($dtCheck as $c) {
                $check[] = $c->id_variable;
            }

            $group = DB::table('group_sub')
            ->select('group_sub.id_sub_group as id','group_sub.sub_group as name', 'group_sub.isDell as status')
            ->where('group_sub.id_sub_group','GS-001')
            ->orWhere('group_sub.id_sub_group','GS-004')
            ->orWhere('group_sub.id_sub_group','GS-006')
            ->get();
       

        $dtMenu = DB::table('grouping_sub_variable')
        ->select('grouping_sub_variable.id as id', 'grouping_sub_variable.id_sub_group as idSubGroup','grouping_sub_variable.id_variable as idVariable',
        'grouping_sub_variable.variable as variable','gaji_karyawan_sub_variable.nominal as nominal')
        ->join('gaji_karyawan_sub_variable','gaji_karyawan_sub_variable.id_variable','grouping_sub_variable.id_variable')
        ->where('gaji_karyawan_sub_variable.id_karyawan',$idKaryawan)
        ->where('gaji_karyawan_sub_variable.id_periode','=',$idPeriode)
        ->get();


        $menu = [];
        foreach ($dtMenu as $m) {
            $menu[$m->idSubGroup][] = [
                'id' => $m->id,
                'id_group' => $m->idSubGroup,
                'id_variable' => $m->idVariable,
                'variable' => $m->variable,
                'nominal' =>$m->nominal
            ];
        }

        $i = 0;
        $sidebar = [];
        foreach ($group as $g) {
            $sidebar[$i]['group'] = [
                'name' => $g->name,  
                'status' => $g->status,
            ];
            $sidebar[$i]['menu'] = $menu[$g->id];
            $i++;
        }

        $data['profile'] = DB::table('user_profile')->where('username','=',$idKaryawan)->first();
        return view('dashboard.penggajian.bpjs.edit')->with('periode',$periode)->with('data',$data)->with('check',$check)->with('permison',$sidebar);
    }

    // mengedit tipe bpjs karyawan
    public function submit(Request $request)
    {
        $userLogin = request()->session()->get('username');
        $_idPeriode = $request->idPeriode;
        $_idKaryawan = $request->idKaryawan; 
        $_tipeBpjs = $request->tipeBpjs; 
        try {
            DB::beginTransaction();
         
             // Update Bpjs Karyawan Periode Penggajian
             $c_penggajian = new c_classPenggajian;
             $_status = $c_penggajian->updateBpjsKaryawanPeriode($_idPeriode,$_idKaryawan,$_tipeBpjs); 
     
             // insert history
             $_keterangan = 'Update BPJS | ID Karyawan : '. $_idKaryawan.
             ' Tipe BPJS : '. $_tipeBpjs;
             $_requestValue['tipe'] = 1;
             $_requestValue['menu'] ='Penggajian';
             $_requestValue['module'] = 'Bpjs';
             $_requestValue['keterangan'] = $_keterangan;
             $_requestValue['pic'] = $userLogin;

             $c_class = new c_classHistory;
             $c_class = $c_class->insertHistory($_requestValue);   
             
      
             $result = 'success';
            
             DB::commit();
            return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function updateVariable(Request $request) {
        $userLogin = request()->session()->get('username');
        $id = $request->id;
        $tipePotongan = $request->tipePotongan;
        $idPeriode = $request->idPeriode;
     
        try {
            DB::beginTransaction();

            // get data idVariable 
            $_idVar = DB::table('karyawan_group_sub_variable_bpjs')
            ->select('id_variable','id_karyawan')
            ->where('id',$id)
            ->first();

            // getData from table Master grouping sub variable bpjs
            $_dataVar = DB::table('grouping_sub_variable_bpjs')
            ->where('id_variable',$_idVar->id_variable)
            ->where('tipe_potongan',$tipePotongan)
            ->first();

                $_nominal=0;
                // get rumus (UPAH TETAP) code GS-001
                $c_classRumus = new c_classRumus;
                $_nominal = $c_classRumus->getRumusPenggajianPeriode('GS-001',$_idVar->id_karyawan,$idPeriode); 
                
                // nominal bpjs
                $_val_bpjs=0;
                if($_nominal > $_dataVar->max_value)
                {
                    $_val_bpjs=$_dataVar->max_value_nominal;
                }
                else
                {
              
                    $_val_bpjs = ($_nominal*($_dataVar->presentase/100));
                }
               
                // master karyawan group sub variable 
                DB::table('gaji_karyawan_sub_variable')
                ->where('id_periode','=',$idPeriode)
                ->where('id_karyawan','=',$_idVar->id_karyawan)
                ->where('id_variable','=',$_idVar->id_variable)
                ->update([
                    'nominal' => $_val_bpjs
                ]);

                // update table karyawan_group_sub_variable_bpjs
                DB::table('karyawan_group_sub_variable_bpjs')
                ->where('id','=',$id)
                ->update([
                    'tipe_potongan' => $tipePotongan,
                    'tot_presentase' => $_dataVar->tot_presentase,
                    'presentasi' => $_dataVar->presentase,
                    'max_value' => $_dataVar->max_value,
                    'max_value_nominal' => $_dataVar->max_value_nominal,
                    'nominal' => $_nominal
                ]);

            $_keterangan = 'Update Variable BPJS Periode : ' . $idPeriode . ' ID Variable : '. $_idVar->id_variable.' Nominal : '. $_val_bpjs. ' ID Karyawan : '. $_idVar->id_karyawan . ' Tipe Potongan : '. $tipePotongan;
            // insert history        
            $_requestValue['tipe'] = 1;
            $_requestValue['menu'] ='Penggajian';
            $_requestValue['module'] = 'BPJS';
            $_requestValue['keterangan'] = $_keterangan;
            $_requestValue['pic'] = $userLogin;

            $c_class = new c_classHistory;
            $c_class = $c_class->insertHistory($_requestValue);

            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([$ex]);
        }
    }
    
    public function listDataBpjs($_idKaryawan) {
        return json_encode($this->dataset($_idKaryawan));
    }

    public function dataset($_idKaryawan) {
        return DB::table('karyawan_group_sub_variable_bpjs')
            ->select('karyawan_group_sub_variable_bpjs.id as id',
            'karyawan_group_sub_variable_bpjs.id_variable as idVariable',
            'karyawan_group_sub_variable_bpjs.variable as variable',
            'karyawan_group_sub_variable_bpjs.tipe_potongan as tipePotongan',
            'karyawan_group_sub_variable_bpjs.tot_presentase as totPresentase',
            'karyawan_group_sub_variable_bpjs.presentasi as presentasi',
            'karyawan_group_sub_variable_bpjs.max_value as maxValue',
            'karyawan_group_sub_variable_bpjs.max_value_nominal as maxValueNominal',
            'karyawan_group_sub_variable_bpjs.nominal as nominal')
            ->where('karyawan_group_sub_variable_bpjs.id_karyawan',$_idKaryawan)
            ->get();
    }

    public function actionExport($_typeActionData,$_idData) {
        $userLogin = request()->session()->get('username');
        try {
            DB::beginTransaction();  
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getPeriodeBerjalan(); 
            if( is_null($_val))
            {
            // nothing
            }
            else
            {
                // get Data Periode
                $periode = $_val;
                $idPeriode = $periode->idPeriode;
            }
          
            return Excel::download(new export_penggajianBpjsAllData($idPeriode,$_typeActionData,$_idData), 'Penggajian-BPJS-'.$_typeActionData.'-'.$periode->periode.'.xlsx');
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }


    public function submitModule(Request $request)
    {
        $userLogin = request()->session()->get('username');
        $idModule = $request->idModule;

        try {

             // get ID Periode
             $c_classPenggajian = new c_classPenggajian;
             $_val = $c_classPenggajian->getPeriodeBerjalan(); 
             if( is_null($_val))
             {
             // nothing
             }
             else
             {
                 // get Data Periode
                 $periode = $_val;
                 $idPeriode = $periode->idPeriode;
             }
            $c_classPeriode = new c_classPeriode;
            $c_classPeriode = $c_classPeriode->updateStatusPeriode($idPeriode,$idModule,$userLogin);
            $_keterangan = 'Submit Module BPJS karyawan ID Periode : ' . $periode->idPeriode . ' ('.$periode->periode.')';

            $c_classPenggajian = new c_penggajian_paycheck;
            $c_classPenggajian = $c_classPenggajian->hitungThp();
       
             // insert history        
             $_requestValue['tipe'] = 0;
             $_requestValue['menu'] ='Penggajian';
             $_requestValue['module'] = 'Upah Karyawan';
             $_requestValue['keterangan'] = $_keterangan;
             $_requestValue['pic'] = $userLogin;

             $c_class = new c_classHistory;
             $c_class = $c_class->insertHistory($_requestValue);
             return 'success';
           } catch (\Exception $ex) {
               return response()->json($ex);
           }
    }
 

}
