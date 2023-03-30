<?php

namespace App\Console;

use App\Jobs\JobHasNotBeenBookedJob;
use App\Jobs\UpcomingJobJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->job(new UpcomingJobJob)->daily();
        // $schedule->job(new JobHasNotBeenBookedJob)->daily();
        $schedule->job(new UpcomingJobJob)->dailyAt('00:15');
        $schedule->job(new JobHasNotBeenBookedJob)->dailyAt('00:15');
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
