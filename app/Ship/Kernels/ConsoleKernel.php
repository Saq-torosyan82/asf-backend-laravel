<?php

namespace App\Ship\Kernels;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as LaravelConsoleKernel;

class ConsoleKernel extends LaravelConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // NOTE: your Containers command will all be auto registered for you.
        // Same for the Ship commands who live in the `app/Ship/Commands/` directory.
        // If you have commands living somewhere else then consider registering them manually here.
    ];

    private $mailOnFailure = 'claudiuj@gmail.com';

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // update deal index
        $schedule->command('update-deal-index')
            ->hourlyAt('15')
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('update deal index columns');

        // update currency rates
        $schedule->command('update-currency-rates')
            ->everyFiveMinutes()
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('update currency rates');

        // import news
        $schedule->command('import-sport-news')
            ->hourly()
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('import sport news');

        // add data to social media followers table
        $schedule->command('social-media-followers transfer')
            ->everyFiveMinutes()
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('add data to social media followers table');

        // check social media followers
        $schedule->command('social-media-followers update')
            ->everyFiveMinutes()
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('check social media followers');

        // send notifications
        $schedule->command('send-notifications')
            ->twiceDailyAt(11, 19)
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('send notifications');

        // process payments notifications
        // add new data to payments table (if dosn't exists)
        $schedule->command('payments')
            ->twiceDailyAt(10, 21)
            ->emailOutputOnFailure($this->mailOnFailure)
            ->description('add data to payments table & send payments notifications');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // NOTE: No need to load your Commands manually from here.
        // As they are automatically registered by the Apiato Loader.

        // $this->load(__DIR__.'/Commands');

        require app_path('Ship/Commands/Routes.php');
    }
}
