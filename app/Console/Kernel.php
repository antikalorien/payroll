<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\karyawan_updateUsers::class,
        Commands\karyawan_updateUsia::class,
        Commands\karyawan_updateTransport::class,
        Commands\karyawan_updateMasaKerja::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('karyawan:updateUsers')
        ->dailyAt('00:01');

        $schedule->command('karyawan:usia')
        ->dailyAt('00:03');

        $schedule->command('karyawan:masaKerja')
        ->dailyAt('00:06');
        
        $schedule->command('karyawan:transport')
        ->dailyAt('00:09');

        $schedule->command('update:departemen')
        ->dailyAt('00:01');

        $schedule->command('update:subDepartemen')
        ->dailyAt('00:03');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
