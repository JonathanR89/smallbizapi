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
      Commands\SendEmailReport::class,
      Commands\SeedDatabaseFromAirtable::class,
      Commands\SeedVendorsDatabaseFromAirtable::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (env('APP_ENV' == 'production')) {
            $schedule->command('send:report')
                 ->hourly();
        }
        $schedule->command('backup:clean')->hourly()->withoutOverlapping();
        $schedule->command('backup:run')->hourly()->withoutOverlapping();
        $schedule->command('airtable:seed')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
