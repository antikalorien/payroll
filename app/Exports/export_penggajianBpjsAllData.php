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

class export_penggajianBpjsAllData implements FromView, WithColumnFormatting,WithColumnWidths
{
    
    function __construct($idPeriode,$typeActionData,$idData) {
        $this->idPeriode = $idPeriode;
        $this->typeActionData = $typeActionData;
        $this->idData = $idData;
    }
    
    public function view(): View
    {

    $userLogin = request()->session()->get('username');
    $idPeriode= $this->idPeriode;
    $typeActionData = $this->typeActionData;
    $idData = $this->idData;

    try {
        $idData=explode(',',$idData);
        $idBpjs=['VR-013','VR-014','VR-015','VR-016','VR-017','VR-018'];

         // get data
         $trn['komponenGaji'] = DB::table('grouping_sub_variable')
         ->select('grouping_sub_variable.id_variable as id_variable',
        'grouping_sub_variable.variable as variable')
         ->orderBy('grouping_sub_variable.id_variable','asc')
         ->whereIn('grouping_sub_variable.id_variable',$idBpjs)
         ->where('isDell','1')
         ->get();

        // get karyawan
        $dataKaryawan =  DB::table('gaji_karyawan')
        ->select(
        'departemen.departemen as departemen',
        'departemen_sub.sub_departemen as subDepartemen',
        'users.pos as pos',
        'grade.level as grade',
        'gaji_karyawan.id_karyawan as idAbsen',
        'gaji_karyawan.nik as nik',
        'users.name as nama',
        'users.tipe_bpjs as tipeBpjs')
        ->join('users','users.id_absen','=','gaji_karyawan.id_karyawan')
        ->join('departemen','departemen.id_dept','=','gaji_karyawan.id_departemen')
        ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_karyawan.id_departemen_sub')
        ->join('grade','grade.id_grade','users.grade')
        ->where('gaji_karyawan.id_periode',$idPeriode);

        // get data
        $dataKaryawanGaji = DB::table('gaji_karyawan_sub_variable')
        ->select('gaji_karyawan_sub_variable.id_karyawan as id_karyawan',
       'gaji_karyawan_sub_variable.id_variable as id_variable',
       'grouping_sub_variable.variable as variable',
       'gaji_karyawan_sub_variable.nominal as nominal')
        ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
        ->join('users','users.id_absen','gaji_karyawan_sub_variable.id_karyawan')
        ->whereIn('gaji_karyawan_sub_variable.id_variable',$idBpjs)
        ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
        ->orderBy('users.username','asc')
        ->orderBy('gaji_karyawan_sub_variable.id_variable','asc');
    
        if($typeActionData=='exportAll')
        {
            // nothing
        }
        elseif($typeActionData=='exportSelectedCheckBox')
        {
            
            $dataKaryawan->whereIn('gaji_karyawan.id_karyawan',$idData);
            $dataKaryawanGaji->whereIn('gaji_karyawan_sub_variable.id_karyawan',$idData);
        }
  
        $trn['karyawan']= $dataKaryawan->get();
        $trn['karyawan_gaji'] = $dataKaryawanGaji->get();

        return view('dashboard.penggajian.bpjs.export_bpjs', $trn);
    } catch (\Exception $ex) {
        dd($ex);
        return response()->json($ex);
    }
}

public function columnFormats(): array
{
    return [
        'E' => NumberFormat::FORMAT_TEXT,
        'F' => NumberFormat::FORMAT_TEXT,
        'G' => NumberFormat::FORMAT_TEXT,
        'H' => NumberFormat::FORMAT_TEXT,
        'I' => NumberFormat::FORMAT_TEXT,

        'J' => NumberFormat::FORMAT_TEXT,
        'K' => NumberFormat::FORMAT_TEXT,
        'L' => NumberFormat::FORMAT_TEXT,
        'M' => NumberFormat::FORMAT_TEXT,
        'N' => NumberFormat::FORMAT_TEXT,
        'O' => NumberFormat::FORMAT_TEXT,
        'P' => NumberFormat::FORMAT_TEXT,
        'Q' => NumberFormat::FORMAT_TEXT,
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

        'J' => 18,
        'K' => 18,
        'L' => 18,
        'M' => 18,
        'N' => 18,
        'O' => 18,
    

    ];
}
}