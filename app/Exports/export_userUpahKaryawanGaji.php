<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Session;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class export_userUpahKaryawanGaji implements FromView, WithColumnFormatting,WithColumnWidths
{
    public function view(): View
    {
  
        $userLogin = request()->session()->get('username');
      
        try {

             // get data
             $trn['komponenGaji'] = DB::table('grouping_sub_variable')
             ->select('grouping_sub_variable.id_variable as id_variable',
            'grouping_sub_variable.variable as variable')
             ->orderBy('grouping_sub_variable.id_variable','asc')
             ->where('isDell','1')
             ->get();

            // get karyawan
            $trn['karyawan'] = DB::table('users')
            ->select('users.id_departemen as id_departemen',
            'departemen.departemen as departemen',
            'users.id_departemen_sub as id_departemen_sub',
            'departemen_sub.sub_departemen as sub_departemen',
            'users.pos as pos',
            'users.grade as grade',
            'users.id_absen as id_absen',
            'users.username as username',
            'users.name as nama')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','users.id_departemen_sub')
            ->join('departemen','departemen.id_Dept','users.id_departemen')
            ->where('users.status','1')
            ->where('users.grade','<>','Magang')
            ->orderBy('users.username','asc')
            ->get();
            
            // get data
            $trn['karyawan_gaji'] = DB::table('karyawan_group_sub_variable')
            ->select('karyawan_group_sub_variable.id_karyawan as id_karyawan',
           'karyawan_group_sub_variable.id_variable as id_variable',
           'grouping_sub_variable.variable as variable',
           'karyawan_group_sub_variable.nominal as nominal')
            ->join('grouping_sub_variable','grouping_sub_variable.id_variable','karyawan_group_sub_variable.id_variable')
            ->join('users','users.id_absen','karyawan_group_sub_variable.id_karyawan')
            ->where('users.status','1')
            ->where('karyawan_group_sub_variable.isDell','1')
            ->orderBy('users.username','asc')
            ->orderBy('karyawan_group_sub_variable.id_variable','asc')
            ->get();
        
          
            return view('dashboard.master-data.upah-karyawan.export_userUpahKaryawan_gaji', $trn);

        } catch (\Exception $ex) {
            dd($ex);
            return response()->json($ex);
        }
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 4,
            'C' => 20,   
            'D' => 35, 
            'E' => 37, 
            'F' => 16, 
            'G' => 10,    
            'H' => 19,
            'I' => 31,

            'J' => 17,
            'K' => 17,
            'L' => 17,
            'M' => 17,
            'N' => 17,
            'O' => 17,
            
        ];
    }
    
}
