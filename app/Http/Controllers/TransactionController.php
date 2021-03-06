<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

use App\Models\TransactionHeader;
use App\Models\TransactionType;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\TurnOverDetail;
use App\Models\UnitType;
use App\Models\User;
use App\Models\Item;
use Carbon\Carbon;
use PDF;
use DB;
use App;

use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesTransactionPerMonth($id){
        $sales=DB::table('transaction_header')
                    ->select(DB::raw('count(id) as `count`'), DB::raw("MONTH(tr_transaction_date) month"), DB::raw("YEAR(tr_transaction_date) year") )
                    ->where('tr_user_id',$id)
                    ->groupBy('month','year')
                    ->get();
        return $sales;
    }

    public function getSalesPerMonth($id){
        $sales=DB::table('transaction_header')
                    ->select(DB::raw('SUM(tr_total_price) as `Sum`'), DB::raw("MONTH(tr_transaction_date) month"), DB::raw("YEAR(tr_transaction_date) year") )
                    ->where('tr_user_id',$id)
                    ->groupBy('month','year')
                    ->get();
        return $sales;
    }

    public function transactionExport($id,$start_date,$end_date){
        return Excel::download(new TransactionExport($start_date,$end_date,$id),'Transactions.xlsx');
    }

    public function bestSeller($id){
        // $best = TransactionDetail::orderBy('td_item_qty','desc')->get()->take(5);

        $best=DB::table('transaction_detail')
                 ->select('transaction_detail.td_item_id', DB::raw('SUM(td_item_qty) as total'), 'item.item_name','item.item_buy_price')
                 ->join('transaction_header','transaction_detail.td_transaction_id','=','transaction_header.id')
                 ->join('item','transaction_detail.td_item_id','=','item.id')
                 ->where('transaction_header.tr_user_id',$id)
                 ->groupBy('transaction_detail.td_item_id','item.item_name','item.item_buy_price')
                 ->get();
        $bestSeller = $best->sortByDesc('total')->take(5);

        return $bestSeller;
    }

    public function getSoldProduct($id){
        $trans_detail=TransactionDetail::join('transaction_header','transaction_detail.td_transaction_id','=','transaction_header.id')
                        ->where('transaction_header.tr_user_id',$id)->get();
        $total_product=0;
        for($i=0;$i<count($trans_detail);$i++){
            $total_product += $trans_detail[$i]->td_item_qty;
        }
        return $total_product;
    }

    public function addSaleTransaction(Request $request){
        $transaction_date=$request->get('transactionDate');
        $transaction_type=$request->get('transactionType');
        $transaction_user=$request->get('userId');
        $transaction_total=$request->get('total_price');

        $transaction=$request->get('saleArray');

        $userInfo=User::where('id',$transaction_user)->first();
        
        $headerSave=[
            'tr_user_id'=>$transaction_user,
            'tr_transaction_date'=>$transaction_date,
            'tr_total_price'=>$transaction_total,
        ];
        $trans_id=DB::table('transaction_header')->insertGetId($headerSave);

        $item=Item::all();

        //loop all item data inserted
        foreach($transaction as $arrTrans){

            //search existing item to update quantity
            for($i=0;$i<count($item);$i++){
                if($arrTrans['tr_item_id'] == $item[$i]->id){
                    $item[$i]->update([
                        'item_qty' => $item[$i]->item_qty-$arrTrans['tr_item_qty']
                    ]);
                    break;
                }
            }
            TransactionDetail::create([
                'td_transaction_id' => $trans_id,
                'td_item_id' =>$arrTrans['tr_item_id'],
                'td_item_qty' =>$arrTrans['tr_item_qty'],
                'td_item_price' =>$arrTrans['tr_item_price'],
                'td_sub_total_price' =>$arrTrans['tr_line_total'],
            ]);
        }

        $trans_Header=TransactionHeader::all();

        $total_price=0;
        for($i=0;$i<count($trans_Header);$i++){
            if(date("m",strtotime($trans_Header[$i]->tr_transaction_date))==date('m') && date("Y",strtotime($trans_Header[$i]->tr_transaction_date))==date('Y')){
                $total_price += $trans_Header[$i]->tr_total_price;
            }
        }

        //get newest turn over target
        $turnOver=TurnOver::select(DB::raw('MAX(id) as `max_Id`'),'to_user_id',DB::raw('MAX(created_at) as `maxDate`'))
        ->groupBy('to_user_id')->where('to_user_id',$transaction_user)
        ->first();

        if($turnOver->max_Id){// jika udh ada pasang target   
            $updtTurnOver = TurnOver::where('to_user_id',$transaction_user)->where('id',$turnOver->max_Id)->update([
                'to_current_turnover'=>$total_price,
            ]);

            $updtTurnOverDtl = TurnOverDetail::where('tod_turn_over_id',$turnOver->max_Id)
                                ->where('tod_month',date('m'))
                                ->where('tod_year',date('Y'))
                                ->update([
                                'tod_turn_over_amount'=>$total_price,
                            ]);
        }

    //print receipt
        $printTransHeader=TransactionHeader::where('id',$trans_id)->first();
        $printTransDtl=TransactionDetail::where('td_transaction_id',$trans_id)->get();
    
        $unitType=UnitType::all();
        
        $data = [
            'shop' => $userInfo->userBusinessName,
            'phone' => $userInfo->userPhone,
            'address' => $userInfo->userAddress,
            'email' =>  $userInfo->email,
            'transHeader' =>$printTransHeader,
            'transDetail' =>$printTransDtl,
            'unitType' =>$unitType,
            'item' =>$item,
            'date' => date("l jS \of F Y h:i:s A", strtotime('+7 hours')),

        ];
        
        $pdf = PDF::loadView('myPDF', $data);
        $pdf->setPaper('a4' , 'portrait');
        return $pdf->output();
    }

    public function getTransactionDetail($id){
        $trans_dtl=DB::table('transaction_detail')
                 ->select('transaction_detail.td_item_id','item.item_name', 'transaction_detail.td_item_qty', 'transaction_detail.td_item_price'
                                ,'transaction_detail.td_sub_total_price'
                                ,'transaction_header.tr_transaction_date'
                                ,'transaction_header.tr_total_price')
                 ->join('transaction_header','transaction_detail.td_transaction_id','=','transaction_header.id')
                 ->join('item','transaction_detail.td_item_id','=','item.id')
                 ->where('transaction_header.id',$id)
                 ->get();
         return $trans_dtl;
        }

    public function getSaleTransactions($id,$start,$end)// still in construction
    {
        if($start==0){
                if($end==0){
                    return new TransactionResource(TransactionHeader::where('tr_user_id',$id)
                            ->paginate(5)->withQueryString());
                }else if($end!=0){
                    return new TransactionResource(TransactionHeader::where('tr_user_id',$id)
                    ->where('tr_transaction_date','<=',$end)
                    ->paginate(5)->withQueryString());
                }
        }else if($start!=0){
                if($end !=0){
                    return new TransactionResource(TransactionHeader::where('tr_user_id',$id)
                    ->where('tr_transaction_date','>=',$start)
                    ->where('tr_transaction_date','<=',$end)
                    ->paginate(5)->withQueryString());
                }else if($end ==0){
                    return new TransactionResource(TransactionHeader::where('tr_user_id',$id)
                    ->where('tr_transaction_date','>=',$start)
                    ->paginate(5)->withQueryString());
                }
        }
    }

    public function getAsset($id)
    {
        $item_asset=Item::where('user_id',$id)->get();

        $total_price=0;
        for($i=0;$i<count($item_asset);$i++){
            $total_price += $item_asset[$i]->item_buy_price * $item_asset[$i]->item_qty;
        }
        return $total_price;
    }

    public function getSale($id)
    {
        $trans_Header=TransactionHeader::where('tr_user_id',$id)->get();

        $total_price=0;
        for($i=0;$i<count($trans_Header);$i++){
            $total_price += $trans_Header[$i]->tr_total_price;
        }
        return $total_price;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function getTransactionType()
    // {
    //     return TransactionType::all();
    // }

}
