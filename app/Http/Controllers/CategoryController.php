<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        $categoryName= $request->cat_name;
        $categoryDesc=$request->cat_desc;
            $dataSave=[
                'category_name'=>$categoryName,
                'category_desc'=>$categoryDesc
            ];
            DB::table('category')->insert($dataSave);
        return redirect()->back();
    }
}
