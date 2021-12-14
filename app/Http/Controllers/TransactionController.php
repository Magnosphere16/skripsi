<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Item;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPurchaseTransaction(Request $request)
    {
        $transaction_date=$request->get('transactionDate');
        $transaction_type=$request->get('transactionType');
        $transaction_user=$request->get('userId');
        $transaction_total=$request->get('total_price');

        $transaction=$request->get('myArray');

        $headerSave=[
                    'tr_user_id'=>$transaction_user,
                    'tr_transaction_type_id'=>$transaction_type,
                    'tr_transaction_date'=>$transaction_date,
                    'tr_total_price'=>$transaction_total,
                ];
        $trans_id=DB::table('transaction_header')->insertGetId($headerSave);
        
        $item_id=0;
        $item=Item::all();
        foreach($transaction as $arrTrans){
            //search existing item
            for($i=0;$i<count($item);$i++){
                if(strcasecmp($arrTrans['tr_item_name'],$item[$i]->item_name)==0){
                    $item_id=$item[$i]->id;
                    $item[$i]->update([
                        'item_qty' => $item[$i]->item_qty+$arrTrans['tr_item_qty']
                    ]);
                    break;
                }else{
                    $itemSave=[
                        'item_name'=>$arrTrans['tr_item_name'],
                        'item_qty'=>$arrTrans['tr_item_qty'],
                        'item_buy_price'=>$arrTrans['tr_item_price'],
                        'user_id'=>$transaction_user,
                        'unit_type_id'=>$arrTrans['tr_unit_type_id'],
                    ];
                    $item_id=DB::table('item')->insertGetId($itemSave);
                    break;
                }
            }
            TransactionDetail::create([
                'td_transaction_id' => $trans_id,
                'td_item_id' =>$item_id,
                'td_item_qty' =>$arrTrans['tr_item_qty'],
                'td_item_price' =>$arrTrans['tr_item_price'],
                'td_sub_total_price' =>$arrTrans['tr_line_total'],
            ]);

            return view('home');
        }
    }

    public function getPurchaseTransactions()
    {
        return TransactionHeader::where('tr_transaction_type_id',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
