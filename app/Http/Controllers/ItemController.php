<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use DB;

class ItemController extends Controller
{

    public function addItem(Request $request){
        $this->validate($request, [
            'item_name' => ['required', 'string', 'min:3', 'max:255'],
            'item_desc' => ['required', 'string', 'min:3', 'max:255'],
            'item_category_id' => ['required', 'integer'],
            'item_qty' => ['required', 'integer', 'min:3', 'max:999'],
            'item_buy_price' => ['required', 'integer', 'min:1'],
            'item_sell_price' => ['required', 'integer', 'min:1'],
        ]);

        $itemName= $request->item_name;
        $itemDesc=$request->item_desc;
        $category_id=$request->item_category_id;
        $itemQty=$request->item_qty;
        $itemBuy=$request->item_buy_price;
        $itemSell=$request->item_sell_price;
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

    public function deleteItem($id){
        $deleteItem=Item::find($id);
        $deleteItem->delete();
    }

    public function editItem(Request $request){
        $this->validate($request, [
            'item_name' => ['required', 'string', 'min:3', 'max:255'],
            'item_desc' => ['required', 'string', 'min:3', 'max:255'],
            'item_category_id' => ['required', 'integer'],
            'item_qty' => ['required', 'integer', 'min:3', 'max:999'],
            'item_buy_price' => ['required', 'integer', 'min:1'],
            'item_sell_price' => ['required', 'integer', 'min:1'],
        ]);

        $updtItem = Item::find($id)->update([
                'item_name'=>$request->itemName,
                'item_desc'=>$request->itemDesc,
                'item_category_id'=>$request->category_id,
                'item_qty'=>$request->itemQty,
                'item_buy_price'=>$request->itemBuy,
                'item_sell_price'=>$request->itemSell,
        ]);
    }

    public function getItem(){
        return Item::all();
    }
}
