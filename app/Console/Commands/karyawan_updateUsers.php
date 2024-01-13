<?php

namespace App\Console\Commands;

use App\sysActivityHistory;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\service_karyawan;
use App\Http\Controllers\SentWhatsappController;

class karyawan_updateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karyawan:updateUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Master User dari data LOKAHR';

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
            // getData Karyawan validity Periode cuti expied
            $serviceKaryawan = new service_karyawan();
            $result['update_masterUsers'] = $serviceKaryawan->update_masterUser();
         
            // add to table log activity
            $activity = new sysActivityHistory();
            $activity->tipe = '1';
            $activity->menu = 'Task';
            $activity->module = 'Crone Job'; 
            $activity->keterangan = 'Update Master User from LOKAHR';
            $activity->pic = 'Crone Job';
            $activity->save();

            $_requestValue['apps'] = 'HRIS-Payroll';
            $_requestValue['service'] = 'CRON JOB';
            $_requestValue['class'] = 'karyawan_updateUsers';
            $_requestValue['status'] ='Success';
            $_requestValue['report'] = json_encode($result);
            // sent to developer
            $c_sentWhatsappController = new SentWhatsappController();
            $c_sentWhatsappController->sentWAtoDeveloper(json_encode($_requestValue));

            return 'Cron Job Update Komplement Success';
        } catch (\Exception $ex) {
            return 'Failed Cron Job';
        }
    }
}
