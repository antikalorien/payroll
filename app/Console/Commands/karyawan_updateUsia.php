<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\c_classKaryawan;
use App\Http\Controllers\c_classPenggajian;

use App\sysActivityHistory;

class karyawan_updateUsia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karyawan:usia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crone Update usia karyawan Successfully!';

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
            ->select('id_absen','dob')
            ->get();

            foreach($dbUser as $x)
            {
                // cek usia
                $c_classKaryawan = new c_classKaryawan();
                $_usia = $c_classKaryawan->getUsia($x->dob);
    
                DB::table('users')
                ->where('id_absen','=',$x->id_absen)
                ->update([
                    'usia' => $_usia,
                ]);

                // update bpjs Kesehatan Usia > 56 Tahun JP
                $_idBPJSJP = ['VR-015','VR-016'];
                if($_usia > 56)
                {
                    $_dataVar = DB::table('grouping_sub_variable_bpjs')
                    ->whereIn('id_variable',$_idBPJSJP)
                    ->where('tipe_potongan','2')
                    ->get();
                    
                    foreach($_dataVar as $v)
                    {
                        // update table karyawan_group_sub_variable_bpjs
                        DB::table('karyawan_group_sub_variable_bpjs')
                        ->where('id_karyawan','=',$x->id_absen)
                        ->where('id_variable','=',$v->id_variable)
                        ->update([
                            'tipe_potongan' => $v->tipe_potongan,
                            'tot_presentase' => $v->tot_presentase,
                            'presentasi' => $v->presentase,
                            'max_value' => $v->max_value,
                            'max_value_nominal' => $v->max_value_nominal,
                            'nominal' => $v->nominal
                        ]);

                        // update master karyawan group sub variable
                        DB::table('karyawan_group_sub_variable')
                        ->where('id_karyawan','=',$x->id_absen)
                        ->where('id_variable','=',$v->id_variable)
                        ->update([
                            'nominal' => $v->nominal
                        ]);

                         // get ID Periode Berjalan
                        $c_classPenggajian = new c_classPenggajian;
                        $_val = $c_classPenggajian->getPeriodeBerjalan(); 
                        if( is_null($_val))
                        {
                        // nothing
                        }
                        else
                        {
                            // get Data Periode
                            $idPeriode = $_val->idPeriode;

                            // update periode karyawan group sub variable
                            DB::table('gaji_karyawan_sub_variable')
                            ->where('id_karyawan','=',$x->id_absen)
                            ->where('id_variable','=',$v->id_variable)
                            ->where('id_periode','=',$idPeriode)
                            ->update([
                                'nominal' => $v->nominal
                            ]);
                        
                        }

                    }

                     // add to table log activity
                    $activity = new sysActivityHistory();
                    $activity->tipe = '1';
                    $activity->menu = 'Task';
                    $activity->module = 'Crone Job'; 
                    $activity->keterangan = 'Update BPJS JP Usia > 56 th : '.$x->id_absen;
                    $activity->pic = 'Crone Job';
                    $activity->save();
                    
                }

            }
    
            DB::commit();
          
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json($ex);
        }
    }
}
