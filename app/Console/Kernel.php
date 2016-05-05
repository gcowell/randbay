<?php

namespace App\Console;



use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Saleitem;
use App\Buyorder;
use App\Currencies;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();


        //UPDATE CURRENCY RATES
        $schedule->call
            (
                function ()
                {
                    $currencies = new Currencies();
                    $currencies-> getLatestCurrencyRates();
                }
            );


        //DELETE UNUSED BUYORDERS
        $schedule->call
            (
                function ()
                {
                    $buyorder = new Buyorder();
                    $buyorder->clearUnusedOrders();
                }
            );


        //CASCADE CURRENCY RATES TO SALEITEMS
        $schedule->call
            (
                function ()
                {
                    $saleitem = new Saleitem();
                    $saleitem->cascadeLatestRates();
                }
            );

            //TODO - ADD DAILY WHEN DEPLOYED!!!
//        ->daily()
    }
}
