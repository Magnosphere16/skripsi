<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TransactionHeader;
use App\Models\TransactionType;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\Item;
use Carbon\Carbon;
use DB;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $turnOver=TurnOver::all();

        $realization=0;
        $currentTarget=0;

        $max = sizeof($turnOver);
        for($i = 0; $i < $max;$i++)//looping buat tiap user
        {   
            $realization=$turnOver[$i]->to_current_turnover;//realisasi 0

            $currentTarget=$turnOver[$i]->to_current_month_target_turnover;//target per periode 1,000,000

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
                $newTarget=$perMonthDefault+($selisih*(-1)); //
            }else{
                $newTarget=$perMonthDefault-$selisih;
            }

            $reset=0;
            //update target baru
            $updtTurnOver = TurnOver::where('to_user_id',$turnOver[$i]->to_user_id)->update([
                'to_current_turnover'=>$reset,//realisasi bulan ini di reset
                'to_current_month_target_turnover'=>$newTarget,//ganti target baru
            ]);
        }

        return "Calculate Complete";
    }
}
