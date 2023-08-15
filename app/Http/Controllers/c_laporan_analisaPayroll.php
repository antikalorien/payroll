<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Exports\export_laporan_analisaPayroll_allDataBCA;
use App\Exports\export_laporan_analisaPayroll;
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class c_laporan_analisaPayroll extends Controller
{
    public function index() {
        return view('dashboard.laporan.analisa-payroll.baru');
    }

    public function data($idPeriode) {
        
        if($idPeriode=='99')
        {
            // get ID Periode
            $c_classPenggajian = new c_classPenggajian;
            $_val = $c_classPenggajian->getLastPeriode(); 
            if( is_null($_val))
            {
            // nothing
            }
            else
            {
                // get Last Periode
                $periode = $_val;
                $idPeriode=$periode->idPeriode;
            }
        }
            $data['data'] =  DB::table('gaji_karyawan')
            ->select(
            'users.id as id',
            'departemen.departemen as id_departemen',
            'departemen_sub.sub_departemen as subDepartemen',
            'users.pos as pos',
            'grade.level as grade',
            'users.doj as doj',
            'gaji_karyawan.id_karyawan as id_absen',
            'gaji_karyawan.nik as username',
            'users.name as name',
            'gaji_karyawan.tipe_kontrak as tieKontrak',
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
             ->where('gaji_karyawan.id_periode',$idPeriode)
            //  ->where('gaji_karyawan.reff_closing','<>','-')
             ->get();
    
             $data['total'] = DB::table('gaji_karyawan_sub_variable')
             ->select(
                'gaji_karyawan_sub_variable.id_karyawan as idKaryawan',
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-001'  and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotGajiPokok"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-002' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotJabatan"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-003' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotKeahlian"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-004' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotTransport"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-005' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotKomunikasi"),
    
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-006' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iLembur"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-007' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTambahanLainnya"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-010' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iAlfa"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-011' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iIjin"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-012' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iPotonganLainnya"),
    
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-018' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsKes"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-014' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsTk"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-016' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotBpjsJp"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-008' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotSimpananKoperasi"),
                DB::raw("(select (FORMAT(SUM(gaji_karyawan_sub_variable.nominal),2)) as nominal from gaji_karyawan_sub_variable where gaji_karyawan_sub_variable.id_variable='VR-009' and gaji_karyawan_sub_variable.id_periode=".$idPeriode." limit 1)as iTotHutangKaryawan"),
             )
             ->where('gaji_karyawan_sub_variable.id_periode',$idPeriode)
            //  ->where('gaji_karyawan.reff_closing','<>','-')
             ->groupBy('gaji_karyawan_sub_variable.id_karyawan')
             ->first();  

             $data['thp'] = DB::table('gaji_karyawan')
             ->select(
                 DB::raw("FORMAT(sum(thp),2) as total"),
             )
             ->where('gaji_karyawan.id_periode',$idPeriode)
            //  ->where('gaji_karyawan.reff_closing','<>','-')
             ->first();

             $data['idPeriode'] = $idPeriode;

        return json_encode($data);
    }

    // Action Export
    public function actionExport($_typeActionExport,$_idPeriode,$_idData)
    {
        $userLogin = request()->session()->get('username');

        try {
            if($_typeActionExport=='exportSelected')
            {
                $trn= $this->exportSelectedPdf($_idPeriode,$_idData);

                $_nik = $trn['karyawan'][0]->nik;
                $_nama = $trn['karyawan'][0]->nama;
                $_departemen = $trn['karyawan'][0]->departemen;
                $_fileName = 'SLIP GAJI-'.$_nik.'-'.$_nama.'-'.$_departemen.'.pdf';
           
                $pdf = PDF::loadView('dashboard.laporan.analisa-payroll.slipgaji_pdf',$trn)->setPaper('b4','portrait');
             
                return $pdf->download($_fileName.'.pdf');
          
            }
            elseif($_typeActionExport=='exportSelectedCheckBox')
            {
                return Excel::download(new export_laporan_analisaPayroll($_typeActionExport,$_idPeriode,$_idData), 'Laporan-Penggajian-SelectedCheckBox.xls');
            }
            elseif($_typeActionExport=='exportAll')
            {
                return Excel::download(new export_laporan_analisaPayroll($_typeActionExport,$_idPeriode,$_idData), 'Laporan-Penggajian-All.xls');
            }
            elseif($_typeActionExport=='exportBCAFormat')
            {
                return Excel::download(new export_laporan_analisaPayroll_allDataBCA($_idPeriode), 'Laporan-Penggajian-BCA.csv');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode([$ex]);
        }
    }

        public function exportSelectedPdf($_idPeriode,$_idKaryawan) {
            $userLogin = request()->session()->get('username');
            try {
                       // get data
                       $trn['komponenGaji_upahTetap'] = DB::table('grouping_sub_variable')
                       ->select(
                       'grouping_sub_variable.id_sub_group as idSubGroup',
                       'grouping_sub_variable.id_variable as id_variable',
                       'grouping_sub_variable.variable as variable')
                       ->orderBy('grouping_sub_variable.id_variable','asc')
                       ->where('grouping_sub_variable.isDell','=','1')
                       ->where('grouping_sub_variable.id_sub_group','=','GS-001')
                       ->get();
   
                       $trn['komponenGaji_upahVariable'] = DB::table('grouping_sub_variable')
                       ->select(
                       'grouping_sub_variable.id_sub_group as idSubGroup',
                       'grouping_sub_variable.id_variable as id_variable',
                       'grouping_sub_variable.variable as variable')
                       ->orderBy('grouping_sub_variable.id_variable','asc')
                       ->where('grouping_sub_variable.isDell','=','1')
                       ->where('grouping_sub_variable.id_sub_group','=','GS-002')
                       ->get();
   
                       $trn['komponenGaji_potongan'] = DB::table('grouping_sub_variable')
                       ->select(
                       'grouping_sub_variable.id_sub_group as idSubGroup',
                       'grouping_sub_variable.id_variable as id_variable',
                       'grouping_sub_variable.variable as variable')
                       ->orderBy('grouping_sub_variable.id_variable','asc')
                       ->where('grouping_sub_variable.isDell','=','1')
                       ->where('grouping_sub_variable.id_sub_group','=','GS-003')
                       ->orWhere('grouping_sub_variable.id_sub_group','=','GS-004')
                       ->get();
   
                       $trn['komponenGaji_bpjsPerusahaan'] = DB::table('grouping_sub_variable')
                       ->select(
                       'grouping_sub_variable.id_sub_group as idSubGroup',
                       'grouping_sub_variable.id_variable as id_variable',
                       'grouping_sub_variable.variable as variable')
                       ->orderBy('grouping_sub_variable.id_variable','asc')
                       ->where('grouping_sub_variable.isDell','=','1')
                       ->where('grouping_sub_variable.id_sub_group','=','GS-006')
                       ->get();
                    
                      // get karyawan
                       $trn['karyawan'] = DB::table('gaji_karyawan')
                       ->select(
                       'gaji_periode.periode as periode',
                       'gaji_karyawan.nik as nik',
                       'users.name as nama',
                       'departemen.departemen as departemen',
                       'departemen_sub.sub_departemen as subDepartemen',
                       'users.pos as jabatan',
                       'gaji_karyawan.no_rekening as noRekening',
                       'gaji_karyawan.skema_gaji as skemaGaji',
                       'gaji_karyawan.thp as thp')
                       ->join('users','users.id_absen','gaji_karyawan.id_karyawan')
                       ->join('departemen','departemen.id_dept','gaji_karyawan.id_departemen')
                       ->join('departemen_sub','departemen_sub.id_subDepartemen','gaji_karyawan.id_departemen_sub')
                       ->join('gaji_periode','gaji_periode.id_periode','gaji_karyawan.id_periode')
                       ->where('users.id_absen',$_idKaryawan)
                       ->where('gaji_karyawan.id_periode',$_idPeriode)
                       ->limit(1)
                       ->get();
                
                      // get data
                      $trn['karyawan_gaji'] = DB::table('gaji_karyawan_sub_variable')
                      ->select('gaji_karyawan_sub_variable.id_karyawan as id_karyawan',
                     'gaji_karyawan_sub_variable.id_variable as id_variable',
                     'grouping_sub_variable.variable as variable',
                     'gaji_karyawan_sub_variable.nominal as nominal','gaji_karyawan_sub_variable.keterangan as keterangan')
                      ->join('grouping_sub_variable','grouping_sub_variable.id_variable','gaji_karyawan_sub_variable.id_variable')
                      ->join('users','users.id_absen','gaji_karyawan_sub_variable.id_karyawan')
                      ->where('users.id_absen',$_idKaryawan)
                      ->where('gaji_karyawan_sub_variable.id_periode',$_idPeriode)
                      ->orderBy('users.username','asc')
                      ->orderBy('gaji_karyawan_sub_variable.id_variable','asc')
                      ->get();
   
                       // kehadiran
                       $trn['kehadiran_karyawan'] = DB::table('gaji_kehadiran_absensi')
                       ->select(
                           'gaji_kehadiran_absensi.tot_libur as totLibur',
                           'gaji_kehadiran_absensi.tot_ph as totPh',
                           'gaji_kehadiran_absensi.tot_izin as totIzin',
                           'gaji_kehadiran_absensi.tot_alfa as totAlfa',
                           'gaji_kehadiran_absensi.tot_sakit as totSakit',
                           'gaji_kehadiran_absensi.tot_cuti as totCuti',
                           'gaji_kehadiran_absensi.tot_masuk as totMasuk'
                       )
                       ->where('gaji_kehadiran_absensi.id_karyawan',$_idKaryawan)
                       ->where('gaji_kehadiran_absensi.id_periode',$_idPeriode)
                       ->first();
                       return $trn;
            } catch (\Exception $ex) {
                return response()->json($ex);
            }
        }
}

