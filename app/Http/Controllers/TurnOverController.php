<?php

namespace App\Http\Controllers;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\TurnOver;

use Illuminate\Http\Request;
use DB;

class TurnOverController extends Controller
{
    public function getUserTurnOver($id){
        return TurnOver::where('to_user_id',$id)->first();
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

        $dataSave=[
            'to_user_id'=>$id,
            'to_turnover_duration'=>$request->duration,
            'to_current_turnover'=>$total_price,
            'to_current_month_target_turnover'=>$startingTarget,
            'to_final_target_turnover'=>$request->target,
            'created_at'=>date('Y-m-d H:i:s'),
        ];
        DB::table('turn_over')->insert($dataSave);
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
