<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
      Commands\SendEmailReport::class,
      Commands\SeedDatabaseFromAirtable::class,
      Commands\SeedVendorsDatabaseFromAirtable::class,
      Commands\DestroyOldCSVFiles::class,
      Commands\SyncStagingEmailsToTest::class,

    ];


    protected function schedule(Schedule $schedule)
    {
        if (env('APP_ENV') == 'production') {
            $schedule->command('send:report')->hourly();
            $schedule->command('backup:clean')->daily()->withoutOverlapping();
            $schedule->command('backup:run')->daily()->withoutOverlapping();
            $schedule->command('airtable:seed')->everyMinute();
            $schedule->command('queue:restart')->everyFiveMinutes();
            $schedule->command('queue:listen')->everyMinute()->withoutOverlapping();
        } elseif (env('APP_ENV') == 'staging') {
            $schedule->command('airtable:seed')->hourly();
            $schedule->command('send:report')->daily();
        }
        $schedule->command('exports:clear')->hourly();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
