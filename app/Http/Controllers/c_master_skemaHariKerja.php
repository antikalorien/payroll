<?php

namespace App\Http\Controllers;

use App\skema_hari_kerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class c_master_skemaHariKerja extends Controller
{
    public function index() {
        return view('dashboard.master-data.skema-hari-kerja.baru');
    }

    public function list() {
        return view('dashboard.master-data.skema-hari-kerja.list');
    }

    public function listData() {
        $data['data'] = skema_hari_kerja::all();
        return json_encode($data);
    }

    public function edit($id) {
        $data = DB::table('skema_hari_kerja')->where('id','=',$id)->first();
        return view('dashboard.master-data.skema-hari-kerja.edit')->with('data',$data);
    }

    public function submit(Request $request) {
        $type = $request->type;
        $idSkema = $request->idSkema;
        $skemaHariKerja = $request->namaSkemaHariKerja;
        $jmlHari = $request->jmlHari;
        $jamKerja = $request->jamKerja;
        $totalJamMinggu = $request->totJamMingguan;
        $totalJamBulan = $request->totJamBulanan;
        try {
            DB::beginTransaction();
            if ($type == 'baru') {
                $data = new skema_hari_kerja();
                $data->id_skema = $idSkema;
                $data->skema = $skemaHariKerja; 
                $data->jml_hari = $jmlHari; 
                $data->jam_kerja = $jamKerja; 
                $data->total_jam_mingguan = $totalJamMinggu; 
                $data->total_jam_bulanan = $totalJamBulan; 
                $data->save();
            } elseif ($type == 'edit') {
                DB::table('skema_hari_kerja')
                    ->where('id_skema','=',$request->idSkema)
                    ->update([
                        'skema' => $skemaHariKerja,
                        'jml_hari' => $jmlHari,
                        'jam_kerja' => $jamKerja,
                        'total_jam_mingguan' => $totalJamMinggu,
                        'total_jam_bulanan' => $totalJamBulan
                    ]);
            }
            DB::commit();
            
            return 'success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
