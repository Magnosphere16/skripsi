<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use DB;

class ItemController extends Controller
{
    public function addItem(Request $request){
        $itemName= $request->item_name;
        $itemDesc=$request->item_desc;
        $category_id=$request->category_id;
        $itemQty=$request->item_qty;
        $itemBuy=$request->item_buy;
        $itemSell=$request->item_sell;
            $dataSave=[
                'item_name'=>$itemName,
                'item_desc'=>$itemDesc,
                'item_category_id'=>$category_id,
                'item_qty'=>$itemQty,
                'item_buy_price'=>$itemBuy,
                'item_sell_price'=>$itemSell,
            ];
            DB::table('item')->insert($dataSave);
        return redirect()->back();
    }
}
