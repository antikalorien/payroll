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
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('karyawan:usia')
        // ->daily();
        ->hourly();
        // ->dailyAt('16:07');

        $schedule->command('karyawan:masaKerja')
        // ->daily();
        ->hourly();
        // ->dailyAt('16:07');
        
        $schedule->command('karyawan:transport')
        // ->daily();
        ->hourly();
        // ->dailyAt('16:07');

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
