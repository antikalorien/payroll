<?php

namespace App\Imports;



use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

// model
use App\User;
use App\karyawan_group_sub_variable_bpjs;
use App\Http\Controllers\c_classKaryawan;
use App\Http\Controllers\c_classHistory;
use Session;

class UsersUpahKaryawan implements ToModel,WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $userLogin = request()->session()->get('username');

        try {
            DB::beginTransaction();
            if(isset($row['tanggal_bergabung']))
            {  
                $_idKaryawan = $row['id_absen'];
                $_tipeBpjs= $row['tipe_bpjs'];
                $_doj = $row['tanggal_bergabung'];
                $_tipeKontrak = $row['tipe_kontrak'];
                $_noRekening = $row['no_rekening'];
                $_statusKaryawan = $row['status_karyawan'];
                $_tipeGaji = $row['tipe_penggajian'];

                // Update Upah Karyawan Master
                $c_karyawan = new c_classKaryawan;
                $_status = $c_karyawan->updateUpahkaryawanMaster($_idKaryawan,$_tipeBpjs,$_doj,$_tipeKontrak,$_noRekening,$_statusKaryawan,$_tipeGaji); 

                // insert history
                $_keterangan = 'Update Upah Karyawan Master - Import Excel | ID Karyawan : '. $_idKaryawan. 
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
            }
            elseif(isset($row['gaji_pokok']))
            {
                // get Column Komponen Gaji
                $komponenGaji = DB::table('grouping_sub_variable')
                ->select('grouping_sub_variable.id_variable as id_variable',
                'grouping_sub_variable.variable as variable')
                ->orderBy('grouping_sub_variable.id_variable','asc')
                ->where('isDell','1')
                ->limit(7)
                ->get();

                $keterangan='';
                foreach ($komponenGaji as $x => $val) {
                 
                    $_idKaryawan=$row['id_absen'];
                    $s = str_replace(' ', '_', strtolower($val->variable));
                    $value = $row[''.$s.''];
        
                    // Update Upah Karyawan Master Variable
                    $c_karyawan = new c_classKaryawan;
                    $_status = $c_karyawan->updateUpahkaryawanVariable($_idKaryawan,$val->id_variable,$value); 
                    $keterangan = 'ID Karyawan : '. $_idKaryawan. ' ID Variable : '. $val->id_variable. ' Nominal : '. $value.' | '. $keterangan;    
                }
                
                // insert history
                $_keterangan = 'Update Upah Karyawan Variable - Excel | Data : '. $keterangan;
                                
                $_requestValue['tipe'] = 0;
                $_requestValue['menu'] ='Master Data';
                $_requestValue['module'] = 'Upah Karyawan';
                $_requestValue['keterangan'] = $_keterangan;
                $_requestValue['pic'] = $userLogin;
        
                $c_class = new c_classHistory;
                $c_class = $c_class->insertHistory($_requestValue);   
            }
        

            DB::commit();
        
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return response()->json($ex);
        }
    }
}
