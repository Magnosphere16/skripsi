<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\TransactionHeader;
use App\Models\TransactionType;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\Item;
use Carbon\Carbon;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $turnOver=TurnOver::all();

            $realization=0;
            $currentTarget=0;

            $max = sizeof($turnOver);
            for($i = 0; $i < $max;$i++)//looping buat tiap user
            {   
                $realization=$turnOver[$i]->to_current_turnover;//realisasi

                $currentTarget=$turnOver[$i]->to_current_month_target_turnover;//target per periode

                $selisih=0;
                if($currentTarget<0){//jika target per periode minus
                    $selisih=($currentTarget*(-1))+$realization;
                }else{
                    $selisih=$realization-$currentTarget;
                }

                $newTarget = 0;
                $perMonthDefault=$turnOver[$i]->to_final_target_turnover/$turnOver[$i]->to_turnover_duration;

                if($selisih==0){
                    $newTarget=$perMonthDefault;
                }else if($selisih<0){
                    $newTarget=$perMonthDefault+($selisih*(-1));
                }else{
                    $newTarget=$perMonthDefault-$selisih;
                }

                $newRealization=0;

                
            }

        })->monthly();
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
