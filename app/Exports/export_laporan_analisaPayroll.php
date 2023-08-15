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

class export_laporan_analisaPayroll implements FromView, WithColumnFormatting,WithColumnWidths
{
    function __construct($_typeActionExport,$_idPeriode,$_idDatakaryawan) {
        $this->typeActionExport = $_typeActionExport;
        $this->idPeriode = $_idPeriode;
        $this->idDataKaryawan = $_idDatakaryawan;
    }

    public function view(): View
    {
  
        $userLogin = request()->session()->get('username');
        $typeActionExport = $this->typeActionExport;
        $idPeriode = $this->idPeriode;
        $idDataKaryawan = $this->idDataKaryawan;
        
        try {
            $idData=explode(',',$idDataKaryawan);
            // get data
            $trn['komponenGaji'] = DB::table('grouping_sub_variable')
            ->select('grouping_sub_variable.id_variable as id_variable',
            'grouping_sub_variable.variable as variable')
            ->orderBy('grouping_sub_variable.id_variable','asc')
            ->where('isDell','1')
            ->get();

           $dataKaryawan =  DB::table('gaji_karyawan')
           ->select('users.id as id',
           'departemen.departemen as departemen',
           'departemen_sub.sub_departemen as subDepartemen',
           'users.pos as pos',
           'grade.level as grade',
           'users.doj as doj',
           'gaji_karyawan.id_karyawan as idAbsen',
           'gaji_karyawan.nik as nip',
           'users.name as nama',
           'gaji_karyawan.tipe_kontrak as tipeKontrak',
           'gaji_karyawan.masa_kerja as masaKerja',
           'gaji_karyawan.usia as usia',
           'users.no_rekening as noRekening',
           'users.tipe_bpjs as tipeBpjs',
           'gaji_karyawan.thp as thp',
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-001' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as gajiPokok"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-002' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganJabatan"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-003' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKeahlian"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-004' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganTransport"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-005' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tunjanganKomunikasi"),
           
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as lembur"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as tambahanLainnya"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-010' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as alfa"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-011' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as ijin"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-012' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as potonganLainnya"),
           
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsKes"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsTk"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as bpjsJp"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as simpananKoperasi"),
           DB::raw("(select gaji_karyawan_sub_variable.nominal as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_karyawan=gaji_karyawan.id_karyawan and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as hutangKaryawan"),
            'gaji_karyawan.updated_at as updatedAt')
            
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
           ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
           ->orderBy('users.username','asc')
           ->orderBy('gaji_karyawan_sub_variable.id_variable','asc');
         
           if($typeActionExport=='exportAll')
           {
               // nothing
           }
           elseif($typeActionExport=='exportSelectedCheckBox')
           {
               
               $dataKaryawan->whereIn('gaji_karyawan.id_karyawan',$idData);
               $dataKaryawanGaji->whereIn('gaji_karyawan_sub_variable.id_karyawan',$idData);
           }
           $trn['karyawan']= $dataKaryawan->get();
           $trn['karyawan_gaji'] = $dataKaryawanGaji->get();
       
           return view('dashboard.laporan.analisa-payroll.export_laporan', $trn);
      

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

