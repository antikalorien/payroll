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

class export_thr implements FromView, WithColumnFormatting,WithColumnWidths
{
    function __construct($idPeriode,$typeActionData,$idData) {
        $this->idPeriode = $idPeriode;
        $this->typeActionData = $typeActionData;
        $this->idData = $idData;
    }

    public function view(): View
    {
 
        $idPeriode = $this->idPeriode;
        $typeActionData = $this->typeActionData;
        $_idData = $this->idData;
      
        try {
            $idData=explode(',',$_idData);
            // get data
            $dataKaryawan =  DB::table('gaji_thr')
            ->select(
            'gaji_thr.id_periode',
            'departemen.departemen',
            'departemen_sub.sub_departemen',
            'users.pos',
            'gaji_thr.id_karyawan',
            'gaji_thr.nik',
            'users.name',
            'gaji_thr.masa_kerja',
            'gaji_thr.no_rekening',
            'gaji_thr.tipe_thr',
            'gaji_thr.thr',
            'gaji_thr.reff')
            ->join('users','users.id_absen','=','gaji_thr.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_thr.id_departemen')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_thr.id_departemen_sub')
            ->where('gaji_thr.id_periode',$idPeriode);
          
            if($typeActionData=='exportAll')
            {
                // nothing
            }
            elseif($typeActionData=='exportSelectedCheckBox')
            {
                
                $dataKaryawan->whereIn('gaji_thr.id',$idData);
            }
            $trn['dataTHR']= $dataKaryawan->get();

            return view('dashboard.thr.input-thr.export_thrKaryawan', $trn);
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
            'M' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 20,
            'C' => 20,
            'D' => 20,   
            'E' => 20, 
            'F' => 15, 
            'G' => 25, 
            'H' => 10,    
            'I' => 15,
            'J' => 10,
            'K' => 15,
            'L' => 15,
          
        ];
    }
}

