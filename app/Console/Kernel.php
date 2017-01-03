<?php

namespace App\Console;



use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Saleitem;
use App\Currencies;
use App\MailingList;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
//    protected $commands =
//        [
//            \App\Console\Commands\Inspire::class,
//        ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //GET CURRENCY RATES FROM EXTERNAL SOURCE
        $schedule->call
            (
                function ()
                {
                    $currencies = new Currencies();
                    $currencies-> getLatestCurrencyRates();
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

        //REMOVE UNSOLD SALEITEMS MORE THAN 10 DAYS OLD
        $schedule->call
            (
                function ()
                {
                    $saleitem = new Saleitem();
                    $saleitem->removeExpiredSaleitems();

                }
            );


        $schedule->call
            (
                function ()
                {
                    $mailinglist = new MailingList();
                    $mailinglist->sendWeeklyMail();

                }
            );
//        ->weekly();



            //TODO DEPLOYED - ADD DAILY WHEN DEPLOYED!!!
//        ->daily()
    }
}
