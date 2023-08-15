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

class export_penggajianPaycheckAllData implements FromView, WithColumnFormatting,WithColumnWidths
{
    function __construct($idPeriode) {
        $this->idPeriode = $idPeriode;
    }

    public function view(): View
    {
  
        $userLogin = request()->session()->get('username');
        $idPeriode = $this->idPeriode;
        try {
          
             // get data
             $trn['komponenGaji'] = DB::table('grouping_sub_variable')
             ->select('grouping_sub_variable.id_variable as id_variable',
            'grouping_sub_variable.variable as variable')
             ->orderBy('grouping_sub_variable.id_variable','asc')
             ->where('isDell','1')
             ->get();

            $trn['karyawan'] =  DB::table('gaji_karyawan')
            ->select(
            'departemen.departemen as departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'grade.level as grade',
            'gaji_karyawan.id_karyawan as idAbsen',
            'gaji_karyawan.nik as nik',
            'users.name as name',
            'gaji_karyawan.tipe_kontrak as tipeKontrak',
            'users.doj as doj',
            'gaji_karyawan.masa_kerja as masaKerja',
            'users.no_rekening as noRekening',
            'users.tipe_bpjs as tipeBpjs',
            'gaji_karyawan.thp as thp')
            ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
            ->join('grade','grade.id_grade','users.grade')
            ->where('gaji_karyawan.id_periode',$idPeriode)
            ->get();

            // get data
            $trn['karyawan_gaji'] = DB::table('gaji_karyawan_sub_variable')
            ->select('gaji_karyawan_sub_variable.id_karyawan as id_karyawan',
           'gaji_karyawan_sub_variable.id_variable as id_variable',
           'grouping_sub_variable.variable as variable',
           'gaji_karyawan_sub_variable.nominal as nominal')
            ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
            ->join('users','users.id_absen','gaji_karyawan_sub_variable.id_karyawan')
            // ->whereIn('gaji_karyawan_sub_variable.id_karyawan',$dtListUser)
            ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
            ->orderBy('users.username','asc')
            ->orderBy('gaji_karyawan_sub_variable.id_variable','asc')
            ->get();
        
      
            return view('dashboard.penggajian.paycheck.export_paycheckAll', $trn);

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
            'J' => NumberFormat::FORMAT_TEXT,
            'K' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 20,
            'C' => 20,   
            'D' => 35, 
            'E' => 15, 
            'F' => 9, 
            'G' => 12,    
            'H' => 35,
            'I' => 12,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 12,

            'N' => 20,
            'O' => 20,
            'P' => 20,
            'Q' => 20,
            'R' => 20,
            'S' => 20,
            'T' => 20,
            'U' => 20,
            'V' => 20,
            'W' => 20,
            'X' => 20,
            'Y' => 20,
            'Z' => 20,
            'AA' => 20,
            'AB' => 20,
            'AC' => 20,
            'AD' => 20,
            'AE' => 20,
            'AF' => 20,
            'AG' => 20,
        ];
    }
}
