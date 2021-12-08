<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

use DB;

class ItemController extends Controller
{

    public function addItem(Request $request, $id){
        //Validate Data
        $this->validate($request,[
            'item_name' => ['required', 'string', 'min:3', 'max:255'],
            'item_desc' => ['required', 'string', 'min:3', 'max:255'],
            'item_category_id' => ['required'],
            'item_qty' => ['required', 'integer', 'min:3', 'max:999'],
            'item_buy_price' => ['required', 'integer', 'min:1'],
            'item_sell_price' => ['required', 'integer', 'min:1'],
        ]);

        //Find Existing Item Category
        $findCategory=Category::where('id',$request->item_category_id)->first();
        if($findCategory==NULL){
            $dataSave=[
                'category_name'=>$request->item_category_id,
                'category_desc'=>$request->item_category_id
            ];
            DB::table('category')->insert($dataSave);
            $currCategory=Category::where('category_name',$request->item_category_id)->first();
        }else{
            $currCategory=Category::where('id',$request->item_category_id)->first();
        }

        //Insert new Item data
        $itemName= $request->item_name;
        $itemDesc=$request->item_desc;
        $category_id=$currCategory->id;
        $itemQty=$request->item_qty;
        $itemBuy=$request->item_buy_price;
        $itemSell=$request->item_sell_price;
        $userId = $id;
            $dataSave=[
                'item_name'=>$itemName,
                'item_desc'=>$itemDesc,
                'item_category_id'=>$category_id,
                'item_qty'=>$itemQty,
                'item_buy_price'=>$itemBuy,
                'item_sell_price'=>$itemSell,
                'user_id'=>$userId,
            ];
            DB::table('item')->insert($dataSave);
        return redirect()->back();
    }

    public function deleteItem($id){
        $deleteItem=Item::find($id);
        $deleteItem->delete();
    }

    public function editItem(Request $request, $id){

        // $this->validate($request, [
        //     'item_name' => ['required', 'string', 'min:3', 'max:255'],
        //     'item_desc' => ['required', 'string', 'min:3', 'max:255'],
        //     'item_category_id' => ['required', 'integer'],
        //     'item_qty' => ['required', 'integer', 'min:3', 'max:999'],
        //     'item_buy_price' => ['required', 'integer', 'min:1'],
        //     'item_sell_price' => ['required', 'integer', 'min:1'],
        // ]);

        $updtItem = Item::find($id)->update([
                'item_name'=>$request->item_name,
                'item_desc'=>$request->item_desc,
                'item_category_id'=>$request->item_category_id,
                'item_qty'=>$request->item_qty,
                'item_buy_price'=>$request->item_buy_price,
                'item_sell_price'=>$request->item_sell_price,
        ]);
    }

    public function getItem(){
        return Item::all();
    }
}
