<?php

namespace App\Exports;

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


class export_userManagement implements FromView, WithColumnFormatting,WithColumnWidths
{
    public function view(): View
    {
        try {
      
            $trn['karyawan']= DB::table('users')
            ->select('users.id as id',
            'users.status as status',
            'users.id_departemen as idDepartemen',
            'departemen.departemen as departemen',
            'users.id_departemen_sub as idDepartemenSub',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'users.grade as grade',
            'users.id_absen as idAbsen',
            'users.username as username',
            'users.name as nama',
            'users.email as email',
            'users.id_skema_hari_kerja as idSkemaHarikerja',
            'skema_hari_kerja.skema as skema',
            'users.no_hp as noHp',
            'users.doj as doj',
            'users.masa_kerja as masaKerja',
            'users.dob as dob',
            'users.usia as usia'
            )
            ->join('departemen_sub','departemen_sub.id_subDepartemen','users.id_departemen_sub')
            ->join('departemen','departemen.id_Dept','users.id_departemen')
            ->join('skema_hari_kerja','skema_hari_kerja.id_skema','users.id_skema_hari_kerja')
            ->orderBy('users.username','asc')
            ->get();
         
            return view('dashboard.master-data.user-management.export_userManagement', $trn);
        } catch (\Exception $ex) {
            dd ($ex);
            return response()->json($ex);
        }
    }

    public function headings(): array{
        return [
            [
                'ID',
                'STATUS',
                'ID DEPARTEMEN',
                'DEPARTEMEN',
                'ID DEPARTEMEN SUB',
                'DEPARTEMEN SUB',
                'POS',
                'GRADE',
                'ID_ABSEN',
                'USERNAME',
                'NAMA',
                'EMAIL',
                'ID SKEMA HARI KERJA',
                'SKEMA HARI KERJA',
                'NO HP',
                'TANGGAL BERGABUNG',
                'MASA KERJA',
                'TANGGAL LAHIR',
                'TANGGAL LAHIR',
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
            'P' => NumberFormat::FORMAT_TEXT,
            'Q' => NumberFormat::FORMAT_TEXT,
            'R' => NumberFormat::FORMAT_TEXT,
            'S' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 10,
            'C' => 15,
            'D' => 20,
            'E' => 15,
            'F' => 20,   
            'G' => 35, 
            'H' => 15, 
            'I' => 9, 
            'J' => 15,    
            'K' => 35,
            'L' => 20,
            'M' => 20,
            'N' => 15,
            'O' => 15,
            'P' => 20,
            'Q' => 15,
            'R' => 20,
            'S' => 10,

        ];
    }
}
