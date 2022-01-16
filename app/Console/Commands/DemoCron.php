<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\TransactionHeader;
use App\Models\TransactionType;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\TurnOverDetail;
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
            //get newest turn over target
            $turnOver=TurnOver::select(DB::raw('MAX(id) as `maxId`'),'to_user_id',DB::raw('MAX(created_at) as `maxDate`'))
            ->groupBy('to_user_id')
            ->get();

            $realization=0;
            $currentTarget=0;

            $max = sizeof($turnOver);
            for($i = 0; $i < $max;$i++)//looping buat tiap user
            {   
                $getTurnOver=TurnOver::all()->where('id',$turnOver[$i]->maxId)->first();

                //make new detail for new period
                $turnOverDetailMaxPeriod=TurnOverDetail::select(DB::raw('MAX(tod_period) as `maxPeriod`'))
                ->where('tod_turn_over_id',$getTurnOver->id)
                ->first();

                //prevent target keep calculating
                // existing max period of current targeting omset data is equal of duration, update is stop, new detail making is stop
                if($getTurnOver->to_turnover_duration!=$turnOverDetailMaxPeriod->maxPeriod){
                    $realization=$getTurnOver->to_current_turnover;//realisasi 0
                    $currentTarget=$getTurnOver->to_current_month_target_turnover;//target per periode 1,000,000
                    $selisih=0;
                    if($currentTarget<0){//jika target per periode minus
                        $selisih=($currentTarget*(-1))+$realization; 
                    }else{
                        $selisih=$realization-$currentTarget;
                    }
    
                    $newTarget = 0;
                    $perMonthDefault=$getTurnOver->to_final_target_turnover/$getTurnOver->to_turnover_duration;
    
                    if($selisih==0){
                        $newTarget=$perMonthDefault;
                    }else if($selisih<0){
                        $newTarget=$perMonthDefault+($selisih*(-1)); //
                    }else{
                        $newTarget=$perMonthDefault-$selisih;
                    }
    
                    $reset=0;
                    //update target baru
                    $updtTurnOver = TurnOver::where('to_user_id',$getTurnOver->to_user_id)
                                    ->where('id',$getTurnOver->id)->update([
                                    'to_current_turnover'=>$reset,//realisasi bulan ini di reset
                                    'to_current_month_target_turnover'=>$newTarget,//ganti target baru
                                ]);
    
                    //get existing detail with max period object
                    $turnOverDetail=TurnOverDetail::where('tod_turn_over_id',$getTurnOver->id)
                    ->where('tod_period',$turnOverDetailMaxPeriod->maxPeriod)->first();
    
                    //insert for new period
                    $dataSaveDetail=[
                        'tod_turn_over_id'=>$turnOverDetail->tod_turn_over_id,
                        'tod_period'=>$turnOverDetail->tod_period+1,
                        'tod_turn_over_amount'=>$reset,
                        'tod_target_turn_over'=>$newTarget,
                        'tod_month'=>date('m'),
                        'tod_year'=>date('Y')
                    ];
                    DB::table('turn_over_detail')->insert($dataSaveDetail);
                }
            }

        return "Calculate Complete";
    }
}
