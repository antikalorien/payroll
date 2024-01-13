<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\c_classKaryawan;
use App\sysActivityHistory;

class karyawan_updateMasaKerja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karyawan:masaKerja';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crone Update Masa Kerja Successfully!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            
            //get data user
            $dbUser = DB::table('users')
            ->select('id_absen','doj')
            ->where('status','1')
            ->get();

            foreach($dbUser as $x)
            {

                // cek masa kerja
                $c_classKaryawan = new c_classKaryawan();
                $_masaKerja = $c_classKaryawan->getMasaKerja($x->doj);
    
                DB::table('users')
                ->where('id_absen','=',$x->id_absen)
                ->update([
                    'masa_kerja' => $_masaKerja,
                ]);
            }

                // add to table log activity
                $activity = new sysActivityHistory();
                $activity->tipe = '1';
                $activity->menu = 'Task';
                $activity->module = 'Crone Job'; 
                $activity->keterangan = 'Update Masa Kerja ID User: ' . $dbUser;
                $activity->pic = 'Crone Job';
                $activity->save();
    
            DB::commit();
          
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
