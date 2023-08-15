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

class export_userUpahKaryawan implements FromView, WithColumnFormatting,WithColumnWidths

{

    public function view(): View
    {
        try {
      
            $trn['karyawan']= DB::table('users')
            ->select('users.id as id',
            'departemen.departemen as departemen',
            'departemen_sub.sub_departemen as sub_departemen',
            'users.pos as pos',
            'users.grade as grade',
            'users.id_absen as idAbsen',
            'users.username as username',
            'users.name as nama',
            'users.masa_kerja as masaKerja',
            'users.doj as doj',
            'users.tipe_kontrak as tipeKontrak',
            'users.no_rekening as noRekening',
            'users.tipe_bpjs as tipeBpjs',
            'users.status_skema_gaji as statusSkemaGaji',
            'users.skema_gaji as skema_gaji',
            )
            ->join('departemen_sub','departemen_sub.id_subDepartemen','users.id_departemen_sub')
            ->join('departemen','departemen.id_Dept','users.id_departemen')
            ->where('users.status','1')
            ->orderBy('users.username','asc')
            ->get();
            return view('dashboard.master-data.upah-karyawan.export_userUpahKaryawan', $trn);
            // return $data;
        } catch (\Exception $ex) {
            dd($ex);
            return response()->json($ex);
        }
    }

    public function headings(): array{
        return [
            [
                'ID',
                'ID DEPARTEMEN',
                'ID DEPARTEMEN SUB',
                'POS',
                'GRADE',
                'ID_ABSEN',
                'USERNAME',
                'NAMA',
                'MASA KERJA',
                'TANGGAL BERGABUNG',
                'TIPE KONTRAK',
                'NO REKENING',
                'TIPE BPJS',
                'STATUS KARYAWAN',
                'TIPE PENGGAJIAN',
            ],
        ];
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
            'N' => NumberFormat::FORMAT_TEXT,
            'O' => NumberFormat::FORMAT_TEXT,
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
            'J' => 20,

            'K' => 14,
            'L' => 14,
            'M' => 10,
            'N' => 17,
            'O' => 17,

        ];
    }
}
