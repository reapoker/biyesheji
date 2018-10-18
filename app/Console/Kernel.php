<?php

namespace App\Console;

use App\Console\Commands\MakeComponent;
use App\Console\Commands\RenderComponents;
use App\Console\Commands\WatchComponent;
use App\Console\Commands\ReadExcel;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       MakeComponent::class,
        RenderComponents::class,
        WatchComponent::class,
        ReadExcel::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
