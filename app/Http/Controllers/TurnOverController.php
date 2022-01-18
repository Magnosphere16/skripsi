<?php

namespace App\Http\Controllers;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\TurnOverDetail;


use Illuminate\Http\Request;
use DB;

class TurnOverController extends Controller
{
    public function getUserTurnOver($id){

        //get newest turn over target
        $turnOver=TurnOver::select(DB::raw('MAX(id) as `max_Id`'),'to_user_id',DB::raw('MAX(created_at) as `maxDate`'))
        ->groupBy('to_user_id')->where('to_user_id',$id)
        ->first();

        return TurnOver::where('id',$turnOver->max_Id)->first();
    }

    public function getTurnOverPerMonth($id){
        //get newest turn over target
        $turnOver=TurnOver::select(DB::raw('MAX(id) as `maxId`'),'to_user_id',DB::raw('MAX(created_at) as `maxDate`'))
        ->groupBy('to_user_id')->where('to_user_id',$id)
        ->first();
        
        return TurnOverDetail::where('tod_turn_over_id',$turnOver->maxId)->get();
    }

    public function setTarget(Request $request, $id){
        $startingTarget=$request->target/$request->duration;
        $trans_Header=TransactionHeader::where('tr_transaction_type_id',2)->get();

        //calculate total turn over in current month as the current turn over
        $total_price=0;
        for($i=0;$i<count($trans_Header);$i++){
            if(date("m",strtotime($trans_Header[$i]->tr_transaction_date))==date('m')){
                $total_price += $trans_Header[$i]->tr_total_price;
            }
        }

        //Make master data to track overall turn over
        $dataSave=[
            'to_user_id'=>$id,
            'to_turnover_duration'=>$request->duration,
            'to_current_turnover'=>$total_price,
            'to_current_month_target_turnover'=>$startingTarget,
            'to_final_target_turnover'=>$request->target,
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        $turn_id=DB::table('turn_over')->insertGetId($dataSave);

        //Starting Track turn over from 1st period
        $dataSaveDetail=[
            'tod_turn_over_id'=>$turn_id,
            'tod_period'=>1,
            'tod_turn_over_amount'=>$total_price,
            'tod_target_turn_over'=>$startingTarget,
            'tod_month'=>date('m'),
            'tod_year'=>date('Y')
        ];
        DB::table('turn_over_detail')->insert($dataSaveDetail);
    }

    public function getTurnOverCurrentMonth(){
        $trans_Header=TransactionHeader::where('tr_transaction_type_id',2)->get();

        $total_price=0;
        for($i=0;$i<count($trans_Header);$i++){
            if(date("m",strtotime($trans_Header[$i]->tr_transaction_date))==date('m')){
                $total_price += $trans_Header[$i]->tr_total_price;
            }
        }
        return $total_price;
    }

}
