<?php

namespace App\Http\Controllers;

use App\sysPermission;
use App\User;
use App\mod_users;
use App\karyawan_group;
use App\karyawan_group_sub;
use App\karyawan_group_sub_variable;
use App\sysActivityHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use App\Exports\export_userManagement;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Illuminate\Support\Facades\Storage;

use PDF;
use App\Http\Controllers\Controller;

use App\Http\Controllers\c_classApi;
use App\Http\Controllers\c_classKaryawan;
use App\Http\Controllers\c_classPermissionAccess;

use Illuminate\Support\Facades\Http;

class c_MasterUserManagement extends Controller
{
    public function index() {
        return view('dashboard.master-data.user-management.baru');
    }

    public function list() {
        return view('dashboard.master-data.user-management.list');
    }

    // select table karyawan ------------------------------------
    public function getTableDatakaryawan()
    {
        $_data =  DB::table('users')
        ->select('users.id as id',
        'users.id_departemen as idDepartemen',
        'departemen.departemen as departemen',
        'users.id_departemen_sub as idDepartemenSub',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'users.grade as idGrade',
        'grade.level as grade',
        'users.id_absen as idAbsen',
        'users.username as nip',
        'users.name as name',
        'users.email as email',
        'users.system as system',
        'users.id_skema_hari_kerja as idSkemaHariKerja',
        'skema_hari_kerja.skema as skema',
        'skema_hari_kerja.jml_hari as jmlHari',
        'skema_hari_kerja.jam_kerja as jamKerja',
        'users.doj as doj',
        'users.masa_kerja as masaKerja',
        'users.dob as dob',
        'users.usia as usia',
        'users.status as status')
         ->join('departemen','departemen.id_dept','=','users.id_departemen')
         ->join('departemen_sub','departemen_sub.id_subDepartemen','=','users.id_departemen_sub')
         ->join('skema_hari_kerja','skema_hari_kerja.id_skema','=','users.id_skema_hari_kerja')
         ->join('grade','grade.id_grade','users.grade');
        return $_data;
    }
    //-----------end table karyawan -----------------------

    public function edit($username) {
        // get data table karyawan
        $_data = $this->getTableDatakaryawan();
        $_data->where('username','=',$username);
        $data= $_data->first();

        $dtCheck = DB::table('sys_permission')->select('id_menu')->where('username','=',$username)->get();
        $check = [];
        foreach ($dtCheck as $c) {
            $check[] = $c->id_menu;
        }
        return view('dashboard.master-data.user-management.edit')->with('data',$data)->with('check',$check);
    }

    public function data() {
         // get data table karyawan
        $_data = $this->getTableDatakaryawan()
        ->get();
        $data['data'] = $_data;
        return json_encode($data);
    }

    public function submit(Request $request) {
        $userLogin = request()->session()->get('username');

        $result = '';
        $type = $request->type;

        $_idDepartemen = $request->departemen;
        $_idDepartemenSub = $request->subDepartemen;
        $_pos = $request->pos;
        $_grade = $request->grade;
        $_idAbsen = $request->idAbsen;
        $_username = $request->username;
        $_name = $request->name;
        $_email = $request->email;
        $_idSkemaHariKerja = $request->skemaHariKerja;
        $_tanggalBergabung = date('Y-m-d',strtotime($request->tanggalBergabung));
        $_tanggalLahir = date('Y-m-d',strtotime($request->tanggalLahir));;
        $_system = $request->system;
        $_noHp='-';
        $_status='1';
        $_permission = $request->permission;
   
        $keterangan="";

        try {
            DB::beginTransaction();
            $_users['id_departemen'] =  $_idDepartemen;
            $_users['id_departemen_sub'] =  $_idDepartemenSub;
            $_users['pos'] =  $_pos;
            $_users['grade'] =  $_grade;
            $_users['id_absen'] =  $_idAbsen;       
            $_users['username'] = $_username;
            $_users['name'] = $_name; 
            $_users['email'] = $_email;
            $randomNumber = random_int(100000, 999999);
            $_users['password'] =$randomNumber; 
            $_users['no_hp'] = $_noHp;
            $_users['id_skema_hari_kerja'] = $_idSkemaHariKerja;
            $_users['doj'] = $_tanggalBergabung;
            $_users['dob'] = $_tanggalLahir;
            $_users['system'] = $_system;
            $_users['status'] = $_status;

            if ($type == 'baru') {

                        // insertUsers
                        $c_karyawan = new c_classKaryawan;
                        $_status = $c_karyawan->insertUsers($_users);
                         
                        $_nominal=0;
                        // insertKaryawanGroupSubVariable($idkaryawan, $nominal)
                        $c_karyawan = new c_classKaryawan;
                        $_status = $c_karyawan->insertKaryawanGroupSubVariable($_idAbsen,$_nominal);   
                     
                        // insert Tunjangan Transport Karyawan
                        $c_karyawan = new c_classPenggajian;
                        $_status = $c_karyawan->updateTunjanganTransport($_idAbsen);
                 
                        // insert history
                        $_keterangan = 'Menambahkan Karyawan | Data : '. json_encode($_users);
                
                        $_requestValue['tipe'] = 0;
                        $_requestValue['menu'] ='Master Data';
                        $_requestValue['module'] = 'User Management';
                        $_requestValue['keterangan'] = $_keterangan;
                        $_requestValue['pic'] = $userLogin;

                        $c_class = new c_classHistory;
                        $c_class = $c_class->insertHistory($_requestValue);   
                        
                        // cek permission
                        if($_permission!='')
                        {
                            // insertUsers($permission)
                            $c_permissionAccess = new c_classPermissionAccess;
                            $_status = $c_permissionAccess->insertPermissionAccess($_permission,$_username);

                    
                            // insert history
                            $_keterangan = 'Menambahkan Akses Permission | ID Karyawan : '. $_username .' Permission : '.json_encode($_permission);

                            $_requestValue['tipe'] = 0;
                            $_requestValue['menu'] ='Master Data';
                            $_requestValue['module'] = 'User Management';
                            $_requestValue['keterangan'] = $_keterangan;
                            $_requestValue['pic'] = $userLogin;

                            $c_class = new c_classHistory;
                            $c_class = $c_class->insertHistory($_requestValue);   
                        }       

                        $result = 'success';

            } elseif ($type == 'edit') { 

                    // Update Users
                    $c_karyawan = new c_classKaryawan;
                    $_status = $c_karyawan->editUsers($_users); 

                     // update Tunjangan Transport Karyawan
                     $c_karyawan = new c_classPenggajian;
                     $_status = $c_karyawan->updateTunjanganTransport($_idAbsen);
           
                   // insert history
                   $_keterangan = 'Edit Karyawan | Data : '. json_encode($_users);
                
                   $_requestValue['tipe'] = 1;
                   $_requestValue['menu'] ='Master Data';
                   $_requestValue['module'] = 'User Management';
                   $_requestValue['keterangan'] = $_keterangan;
                   $_requestValue['pic'] = $userLogin;

                   $c_class = new c_classHistory;
                   $c_class = $c_class->insertHistory($_requestValue);   
               
                if($_permission!='')
                {
                    // insertUsers($permission)
                    $c_permissionAccess = new c_classPermissionAccess;
                    $_status = $c_permissionAccess->insertPermissionAccess($_permission,$_username);

                     // insert history
                     $_keterangan = 'Update Akses Permission | ID Karyawan : '. $_username .' Permission : '.json_encode($_permission);

                     $_requestValue['tipe'] = 1;
                     $_requestValue['menu'] ='Master Data';
                     $_requestValue['module'] = 'User Management';
                     $_requestValue['keterangan'] = $_keterangan;
                     $_requestValue['pic'] = $userLogin;

                     $c_class = new c_classHistory;
                     $c_class = $c_class->insertHistory($_requestValue);  
                  
                }

                    $result = 'success';
            }
            DB::commit();
            return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }

    public function resetPassword(Request $request) {
        $username = $request->username;
        try {
            DB::beginTransaction();
            $randomNumber = random_int(100000, 999999);
            DB::table('users')->where('username','=',$username)
                ->update([
                    'password' => Crypt::encryptString($randomNumber)
                ]);
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function resetPasswordAllUser(Request $request) {
        try {
            DB::beginTransaction();

            $listUser = DB::table('users')
            ->select('username','password')
            ->where('status','1')
            ->get();

            foreach($listUser as $v)
            {
           
                $randomNumber = random_int(100000, 999999);
          
                // cek jika password belum di ganti
                // if($v->username ==Crypt::decryptString($v->password))
                // {
                    DB::table('users')->where('username','=',$v->username)
                    ->update([
                        'password' => Crypt::encryptString($randomNumber)
                    ]);
                // }
            }
    
            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function disable(Request $request) {
        $userLogin = request()->session()->get('username');

        $id_array = $request->id;
        try {
            DB::beginTransaction();
    
            foreach($id_array as $id)
            {

                $_dtKaryawan = DB::table('users')
                ->select('username as username','name as nama')
                ->where('id',$id)
                ->first();

                // disable User
                $c_classKaryawan = new c_classKaryawan;
                $_status = $c_classKaryawan->disableUsers($_dtKaryawan->username);

                 // insert history
                 $_keterangan = 'Disable Karyawan | ID Karyawan : '. $_dtKaryawan->username .' Nama Karyawan : '.$_dtKaryawan->nama;

                 $_requestValue['tipe'] = 1;
                 $_requestValue['menu'] ='Master Data';
                 $_requestValue['module'] = 'User Management';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;

                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
            }
        
            DB::commit();
             return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function activate(Request $request) {
        $userLogin = request()->session()->get('username');

        $id_array = $request->id;
        try {

            DB::beginTransaction();
            
            foreach($id_array as $id)
            {
            
                $_dtKaryawan = DB::table('users')
                ->select('username as username','name as nama')
                ->where('id',$id)
                ->first();

                // disable User
                $c_classKaryawan = new c_classKaryawan;
                $_status = $c_classKaryawan->activeUsers($_dtKaryawan->username);

                 // insert history
                 $_keterangan = 'Activate Karyawan | ID Karyawan : '. $_dtKaryawan->username .' Nama Karyawan : '.$_dtKaryawan->nama;

                 $_requestValue['tipe'] = 1;
                 $_requestValue['menu'] ='Master Data';
                 $_requestValue['module'] = 'User Management';
                 $_requestValue['keterangan'] = $_keterangan;
                 $_requestValue['pic'] = $userLogin;

                 $c_class = new c_classHistory;
                 $c_class = $c_class->insertHistory($_requestValue);  
            }

            DB::commit();
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

    public function exportUserManagement(){

      return Excel::download(new export_userManagement(), 'Data-User-Management.xlsx');
    }

    public function importUserManagement(Request $request) 
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
      
		// upload ke folder kayrawan_import di dalam folder public
		// $file->move('kayrawan_import',$nama_file);
 		//Storage::putFileAs('public',$file,$nama_file);
		// import data
     

		// Excel::import(new karyawanImport, 'http://10.10.10.9:8099/storage/'.$nama_file);
        Excel::import(new UsersImport,$file);

		return redirect('dashboard/master/user-management/list');
        } catch (\Exception $ex) {
            return response()->json([$ex]);
        }
	}



}
