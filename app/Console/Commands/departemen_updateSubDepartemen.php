<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\service_subDepartemen;
use App\Http\Controllers\SentWhatsappController;

class departemen_updateSubDepartemen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:subDepartemen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Master Sub Departemen';

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
            // update master data departemen
            $service_subDepartemen = new service_subDepartemen();
            $result = $service_subDepartemen->update_masterSubDepartemen();
            $_requestValue['apps'] = 'HRIS-Payroll';
            $_requestValue['service'] = 'CRON JOB';
            $_requestValue['class'] = 'departemen_updateSubDepartemen';
            $_requestValue['status'] ='Success';
            $_requestValue['report'] = json_encode($result);

            // sent to developer
            $c_sentWhatsappController = new SentWhatsappController();
            $c_sentWhatsappController->sentWAtoDeveloper(json_encode($_requestValue));
            
            DB::commit();
            return 'Cron Job Update Master Sub Departemen Success';
        } catch (\Exception $ex) {
            DB::rollBack();
            return 'Failed Cron Job';
        }
    }
}
