<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Imports\ItemImport;
use Excel;
use DB;
use Illuminate\Support\Facades\File;
use Image;

class ItemController extends Controller
{

    public function import(Request $request,$id){
         Excel::import(new ItemImport($id),$request->file);
         return redirect('/items');
    }

    public function getUnitTypeId($id){
        $item=Item::where('id',$id)->first();
        return $item->id;
    }

    public function getCategoryId($id){
        $category=Category::where('id',$id)->first();
        return $category->id;
    }

    public function addItem(Request $request, $id){
        //Validate Data
        $this->validate($request,[
            'item_name' => ['required', 'string', 'min:3', 'max:255'],
            'item_desc' => ['required', 'string', 'min:3', 'max:255'],
            'item_category_id' => ['required'],
            'unit_type_id' => ['required'],
            'item_qty' => ['required', 'integer', 'min:3', 'max:999'],
            'item_buy_price' => ['required', 'integer', 'min:1'],
            'item_sell_price' => ['required', 'integer', 'min:1'],
        ]);
        $user=User::where('id',$id)->first();
        if($request->hasfile('item_image')){
            $image=$request->item_image;
            $img = Image::make($image->path());
            $img->resize(1500, 1500)->save('assets/item_img/'.'['.$user->userName.'_'.$id.']'.'-'.date("dmY").'_'.$request->item_name.'.'.$request->file('item_image')->extension());
            $imageString = '../assets/item_img/'.'['.$user->userName.'_'.$id.']'.'-'.date("dmY").'_'.$request->item_name.'.'.$request->file('item_image')->extension();
        }

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
        $unit_type_id=$request->unit_type_id;
        $userId = $id;
            $dataSave=[
                'item_name'=>$itemName,
                'item_desc'=>$itemDesc,
                'item_category_id'=>$category_id,
                'item_qty'=>$itemQty,
                'item_image'=>$imageString,
                'item_buy_price'=>$itemBuy,
                'item_sell_price'=>$itemSell,
                'user_id'=>$userId,
                'unit_type_id'=>$unit_type_id,
            ];
            DB::table('item')->insert($dataSave);
        return redirect()->back();
    }

    public function deleteItem($id){
        $deleteItem=Item::find($id);
        $deleteItem->delete();
    }

    public function editItem(Request $request, $id){
        $getItem=Item::where('id',$id)->first();
        $getUser=User::where('id',$getItem->user_id)->first();

        if($request->hasfile('item_image')){
            $imageString = '../assets/item_img/'.'['.date("dmY").']'.'-'.$getUser->userName.'_'.$request->item_name.'_'.$id.'.'.$request->file('item_image')->extension();
            $image=$request->item_image;
            $img = Image::make($image->path());

            if($getItem->item_image!='../assets/img/default.jpg'){
                File::delete($getItem->item_image);
            }
            $img->resize(1500, 1500)->save('assets/item_img/'.'['.date("dmY").']'.'-'.$getUser->userName.'_'.$request->item_name.'_'.$id.'.'.$request->file('item_image')->extension());
        }

        $updtItem = Item::where('id',$id)->update([
                'item_name'=>$request->item_name,
                'item_desc'=>$request->item_desc,
                'item_image'=>$imageString,
                'item_category_id'=>$request->item_category_id,
                'unit_type_id'=>$request->unit_type_id,
                'item_qty'=>$request->item_qty,
                'item_buy_price'=>$request->item_buy_price,
                'item_sell_price'=>$request->item_sell_price,
        ]);
        return $updtItem;
    }

    public function getItem($id){
        // Eager loading
        return Item::where('user_id',$id)->with('unitType')->latest()->get();
    }

    public function getItemInfo($id){
        return Item::where('id',$id)->with(['unitType', 'category'])->first();
    }
}
