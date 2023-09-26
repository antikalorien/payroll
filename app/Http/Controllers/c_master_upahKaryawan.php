<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Exports\export_userUpahKaryawan;
use App\Exports\export_userUpahKaryawanGaji;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersUpahKaryawan;

use PDF;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

// model
use App\User;

class c_master_upahKaryawan extends Controller
{
    public function index() {
        return view('dashboard.master-data.upah-karyawan.baru');
    }

    public function data() {
        $data['data'] =  DB::table('users')
        ->select('users.id as id',
        'departemen.departemen as id_departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'users.grade as idGrade',
        'grade.level as grade',
        'users.id_absen as id_absen','users.username as username',
        'users.name as name',
        'users.tipe_kontrak as tieKontrak',
        'users.doj as doj',
        'users.masa_kerja as masaKerja',
        'users.no_rekening as noRekening',
        'users.tipe_bpjs as tipeBpjs',
        'users.status_skema_gaji as statusSkemaGaji',
        'users.skema_gaji as skemaGaji',
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-001' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as gajiPokok"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-002' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as tunjanganJabatan"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-003' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as tunjanganKeahlian"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-004' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as tunjanganTransport"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-005' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as tunjanganKomunikasi"), 
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-007' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as tambahanLainnya"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-018' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as bpjsKes"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-014' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as bpjsTk"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-016' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as bpjsJp"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-008' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as simpananKoperasi"),
         DB::raw("(select karyawan_group_sub_variable.nominal as nominal from karyawan_group_sub_variable where karyawan_group_sub_variable.id_variable='VR-009' and karyawan_group_sub_variable.id_karyawan=users.id_absen limit 1)as hutangKaryawan"),
        'users.status as status',
        'users.updated_at as updatedAt')
         ->join('departemen','departemen.id_dept','=','users.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','=','users.id_departemen_sub')
         ->join('grade','grade.id_grade','users.grade') 
         ->where('users.status','1')
        ->get();
      
        return json_encode($data);
    }

    public function edit($username) {
        $data['user'] = DB::table('users')
        ->select('departemen.departemen as departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'users.grade as idGrade',
        'grade.level as grade',
        'users.id_absen as idAbsen',
        'users.username as username',
        'users.name as name',
        'users.email as email',
        'users.no_hp as noHp',
        'skema_hari_kerja.skema',
        'users.tipe_kontrak as tipeKontrak',
        'users.doj as doj',
        'users.masa_kerja as masaKerja',
        'users.usia as usia',
        'users.no_rekening as noRekening',
        'users.tipe_bpjs as tipeBpjs',
        'users.status_skema_gaji as statusSkemaGaji',
        'users.skema_gaji as skemaGaji',
        'users.created_at as created_at')
        ->join('departemen','departemen.id_dept','users.id_departemen')
        ->join('departemen_sub','departemen_sub.id_subDepartemen','users.id_departemen_sub')
        ->join('skema_hari_kerja','skema_hari_kerja.id_skema','users.id_skema_hari_kerja')
        ->join('grade','grade.id_grade','users.grade') 
        ->where('users.username','=',$username)
        ->first();

            $dtCheck = DB::table('karyawan_group_sub_variable')
            ->select('id_variable')
            ->where('isDell','1')
            ->where('id_karyawan', $data['user']->idAbsen)
            ->get();
      
            $check = [];
            foreach ($dtCheck as $c) {
                $check[] = $c->id_variable;
            }

            $group = DB::table('group_sub')
            ->select('group_sub.id_sub_group as id','group_sub.sub_group as name', 'group_sub.isDell as status')
            ->get();

            $dtMenu = DB::table('grouping_sub_variable')
            ->select('grouping_sub_variable.id as id', 'grouping_sub_variable.id_sub_group as idSubGroup','grouping_sub_variable.id_variable as idVariable',
            'grouping_sub_variable.variable as variable','karyawan_group_sub_variable.nominal as nominal','karyawan_group_sub_variable.keterangan as keterangan')
            ->join('karyawan_group_sub_variable','karyawan_group_sub_variable.id_variable','grouping_sub_variable.id_variable')
            ->where('karyawan_group_sub_variable.id_karyawan',$data['user']->idAbsen)
            ->get();


                $menu = [];
                foreach ($dtMenu as $m) {
                    $menu[$m->idSubGroup][] = [
                        'id' => $m->id,
                        'id_group' => $m->idSubGroup,
                        'id_variable' => $m->idVariable,
                        'variable' => $m->variable,
                        'nominal' =>$m->nominal,
                        'keterangan' =>$m->keterangan
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

        $data['profile'] = DB::table('user_profile')->where('username','=',$username)->first();
        return view('dashboard.master-data.upah-karyawan.edit')->with('data',$data)->with('check',$check)->with('permison',$sidebar);
    }

    public function submit(Request $request) {
       
        $userLogin = request()->session()->get('username');
        $variabel = $request->variabel;
        $_idKaryawan = $request->idKaryawan;
        $_noRekening = $request->noRekening;
        $_tipeKontrak = $request->tipeKontrak;
        $_skemaHariKerja = $request->skemaHariKerja;
        $_doj = $request->tanggalBergabung;
        $_tipeBpjs = $request->tipeBpjs;
        $_statusKaryawan = $request->statusSkemaGaji;
        $_tipeGaji = $request->skemaGaji;
  
        try {
            DB::beginTransaction();
          
             // Update Upah Karyawan Master
             $c_karyawan = new c_classKaryawan;
             $_status = $c_karyawan->updateUpahkaryawanMaster($_idKaryawan,$_tipeBpjs,$_doj,$_tipeKontrak,$_noRekening,$_statusKaryawan,$_tipeGaji); 

             // insert history
             $_keterangan = 'Update Upah Karyawan Master | ID Karyawan : '. $_idKaryawan. 
             ' Tipe BPJS : '. $_tipeBpjs.
             ' Tanggal Bergabung : '. $_doj.
             ' Tipe Kontrak : '. $_tipeKontrak.
             ' No Rekening : '. $_noRekening.
             ' Status Karyawan : '. $_statusKaryawan.
             ' Tipe Gaji : '. $_tipeGaji;
                                        
             $_requestValue['tipe'] = 0;
             $_requestValue['menu'] ='Master Data';
             $_requestValue['module'] = 'Upah Karyawan';
             $_requestValue['keterangan'] = $_keterangan;
             $_requestValue['pic'] = $userLogin;

             $c_class = new c_classHistory;
             $c_class = $c_class->insertHistory($_requestValue);   

                    if($variabel!='')
                    {
                        $keterangan='-';
                        foreach ($variabel as $x => $val) {

                            // Update Upah Karyawan Master Variable
                            $c_karyawan = new c_classKaryawan;
                            $_status = $c_karyawan->updateUpahkaryawanVariable($_idKaryawan,$x,$val); 
                            $keterangan = 'ID Karyawan : '. $_idKaryawan. ' ID Variable : '. $x. ' Nominal : '. $val.' | '. $keterangan;    
                        }
                        // insert history
                        $_keterangan = 'Update Upah Karyawan Variable | Data : '. $keterangan;
                                        
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Master Data';
                        $_requestValue['module'] = 'Upah Karyawan';
                        $_requestValue['keterangan'] = $_keterangan;
                        $_requestValue['pic'] = $userLogin;

                        $c_class = new c_classHistory;
                        $c_class = $c_class->insertHistory($_requestValue);   
                    }

                DB::commit();
                $result = 'success';
               
            DB::commit();
            return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
   
    public function exportUpahKaryawan(){

      return Excel::download(new export_userUpahKaryawan(), 'Data-User-UpahKaryawan.xlsx');
    }

    public function exportUpahKaryawanGaji(){
        return Excel::download(new export_userUpahKaryawanGaji(), 'Data-User-UpahKaryawan-Gaji.xlsx');
    }

    public function importUpahKaryawan(Request $request) 
	{
        $username = \request()->session()->get('username');
        try{
	    // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
     
		// menangkap file excel
		$file = $request->file('file');
		
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
        Storage::putFile('file_siswa', $file);

        if(!Storage::disk('public_uploads')->put($nama_file, $file)) {
            return false;
        }

        Excel::import(new UsersUpahKaryawan,$file);
     
		return redirect('master-data-upah-karyawan');
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
	}



}
