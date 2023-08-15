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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class export_laporan_analisaPayroll_allDataBCA implements FromView, WithColumnFormatting
{    
    function __construct($idPeriode) {
        $this->idPeriode = $idPeriode;
    }
    
    public function view(): View
    {
    $userLogin = request()->session()->get('username');
    $idPeriode = $this->idPeriode; 
    try {
        // get karyawan
        $trn['karyawan'] = DB::table('gaji_karyawan')
        ->select(
        'gaji_karyawan.no_rekening as noRekening',
        'gaji_karyawan.thp as thp',
        'gaji_karyawan.nik as nip',
        'users.name as nama')
        ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
        ->where('gaji_karyawan.id_periode',$idPeriode)
        ->orderBy('gaji_karyawan.nik','asc')
        ->get();
  
        return view('dashboard.laporan.analisa-payroll.export_laporanAllDataBCA', $trn);

    } catch (\Exception $ex) {
        dd($ex);
        return response()->json($ex);
    }
}

public function columnFormats(): array
{
    return [
        'A' => NumberFormat::FORMAT_TEXT,
        'C' => NumberFormat::FORMAT_TEXT,
        'D' => NumberFormat::FORMAT_TEXT,
    ];
}
}
