<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

use App\Models\TransactionHeader;
use App\Models\TransactionType;
use App\Models\TransactionDetail;
use App\Models\TurnOver;
use App\Models\Item;
use Carbon\Carbon;
use DB;

use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    // public function transactionVisualization(){
    //     $data = TransactionHeader::select('id','tr_transaction_date','tr_total_price')->get()->groupBy(function($data){
    //         return Carbon::parse($data->tr_transaction_date)->format('M');
    //     });

    //     $months=[];
    //     $monthCount=[];

    //     foreach($data as $month =>$values){
    //         $months[]=$month;
    //         $monthCount[]=count($values);
    //     }

    //     return ['data'=>$data,'months'=>$months,'monthCount'=>$monthCount];
    // }

    public function addSaleTransaction(Request $request){
        $transaction_date=$request->get('transactionDate');
        $transaction_type=$request->get('transactionType');
        $transaction_user=$request->get('userId');
        $transaction_total=$request->get('total_price');

        $transaction=$request->get('saleArray');
        
        $headerSave=[
            'tr_user_id'=>$transaction_user,
            'tr_transaction_type_id'=>$transaction_type,
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

        $trans_Header=TransactionHeader::where('tr_transaction_type_id',2)->get();

        $total_price=0;
        for($i=0;$i<count($trans_Header);$i++){
            if(date("m",strtotime($trans_Header[$i]->tr_transaction_date))==date('m')){
                $total_price += $trans_Header[$i]->tr_total_price;
            }
        }

        $updtTurnOver = TurnOver::where('to_user_id',$transaction_user)->update([
            'to_current_turnover'=>$total_price,
        ]);
    }

    // public function addPurchaseTransaction(Request $request)
    // {
    //     $transaction_date=$request->get('transactionDate');
    //     $transaction_type=$request->get('transactionType');
    //     $transaction_user=$request->get('userId');
    //     $transaction_total=$request->get('total_price');

    //     $transaction=$request->get('purchaseArray');

    //     $headerSave=[
    //                 'tr_user_id'=>$transaction_user,
    //                 'tr_transaction_type_id'=>$transaction_type,
    //                 'tr_transaction_date'=>$transaction_date,
    //                 'tr_total_price'=>$transaction_total,
    //             ];
    //     $trans_id=DB::table('transaction_header')->insertGetId($headerSave);

    //     $item_id=0;
    //     $item=Item::all();
    //     foreach($transaction as $arrTrans){
    //         //search existing item
    //         for($i=0;$i<count($item);$i++){
    //             if(strcasecmp($arrTrans['tr_item_name'],$item[$i]->item_name)==0){
    //                 $item_id=$item[$i]->id;
    //                 $item[$i]->update([
    //                     'item_qty' => $item[$i]->item_qty+$arrTrans['tr_item_qty']
    //                 ]);
    //                 break;
    //             }else{
    //                 $itemSave=[
    //                     'item_name'=>$arrTrans['tr_item_name'],
    //                     'item_desc'=>"New Item",
    //                     'item_qty'=>$arrTrans['tr_item_qty'],
    //                     'item_buy_price'=>$arrTrans['tr_item_price'],
    //                     'item_sell_price'=>0,
    //                     'item_category_id'=>1,
    //                     'user_id'=>$transaction_user,
    //                     'unit_type_id'=>$arrTrans['tr_unit_type_id'],
    //                 ];
    //                 $item_id=DB::table('item')->insertGetId($itemSave);
    //                 break;
    //             }
    //         }
    //         TransactionDetail::create([
    //             'td_transaction_id' => $trans_id,
    //             'td_item_id' =>$item_id,
    //             'td_item_qty' =>$arrTrans['tr_item_qty'],
    //             'td_item_price' =>$arrTrans['tr_item_price'],
    //             'td_sub_total_price' =>$arrTrans['tr_line_total'],
    //         ]);
    //     }
    //     return back();
    // }

    // public function getPurchaseTransactions()
    // {
    //     return TransactionHeader::where('tr_transaction_type_id',1)->get();
    // }

    public function getSaleTransactions($id)
    {
        return new TransactionResource(TransactionHeader::where('tr_transaction_type_id',2)
                                                            ->where('tr_user_id',$id)
                                                            ->paginate(5)
                                                            ->onEachSide(2));
    }

    public function getAsset()
    {
        $item=Item::all();
        $total_asset=0;
        for($i=0;$i<count($item);$i++){
            $total_asset += ($item[$i]->item_qty*$item[$i]->item_buy_price);
        }
        return $total_asset;
    }

    public function getSale($id)
    {
        $trans_Header=TransactionHeader::where([
                            ['tr_transaction_type_id',2],
                            ['tr_user_id',$id]
                        ])->get();

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
    public function getTransactionType()
    {
        return TransactionType::all();
    }

}
