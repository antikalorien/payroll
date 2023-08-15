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


class export_penggajianLembur implements FromView, WithColumnFormatting,WithColumnWidths
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
            $dataKaryawan =  DB::table('gaji_lembur')
            ->select(
            'departemen.departemen as departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'grade.level as grade',
            'gaji_lembur.id_karyawan as idAbsen',
            'users.username as nip',
            'users.name as nama',
            'users.tipe_kontrak as tipeKontrak',
            'gaji_lembur.tgl as tanggal',
            'gaji_lembur.jam_lembur as jamLembur',
            'gaji_lembur.total_upah as totalUpah',
            'gaji_lembur.total_jam as totalJam',
            'gaji_lembur.nominal as nominal',
            'gaji_lembur.keterangan as keterangan',
            'gaji_lembur.pic as pic')
            ->join('users','users.id_absen','=','gaji_lembur.id_karyawan')
            ->join('departemen','departemen.id_dept','=','gaji_lembur.id_dept')
            ->join('departemen_sub','departemen_sub.id_subDepartemen','=','gaji_lembur.id_sub_dept')
            ->join('grade','grade.id_grade','users.grade')
            ->where('gaji_lembur.id_periode',$idPeriode);
          
            if($typeActionData=='exportAll')
            {
                // nothing
            }
            elseif($typeActionData=='exportSelectedCheckBox')
            {
                
                $dataKaryawan->whereIn('gaji_lembur.id',$idData);
            }
            $trn['dataLembur']= $dataKaryawan->get();
     
            return view('dashboard.penggajian.data-lembur.export_lemburKaryawan', $trn);
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
            'F' => 9, 
            'G' => 15, 
            'H' => 35,    
            'I' => 12,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 12,
            'O' => 35,
            'P' => 15,
        ];
    }
}
