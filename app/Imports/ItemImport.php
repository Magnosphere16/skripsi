<?php

namespace App\Imports;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Item;
use App\Models\UnitType;
use App\Models\Category;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use DB;

class ItemImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $id;

    public function  __construct($id)
    {
        $this->id= $id;
    }

    public function collection (Collection $rows)
    {   
        foreach ($rows as $row)
        {
            $unitTypeId=0;
            $itemCategoryId=0;

            $unit_type=UnitType::where('unit_type_name',$row['unit_type_id'])->first();
            // if unit type is not in db
            if($unit_type==null){
                $newUnitType=[
                    'unit_type_name'=> $row['unit_type_id'],
                ];
                $unitTypeId=DB::table('unit_type')->insertGetId($newUnitType);
            }else{
                $unitTypeId=$unit_type->id;
            }

            $item_category=Category::where('category_name',$row['item_category_id'])->first();
            if($item_category==null){
                $newItemCategory=[
                    'category_name'=> $row['item_category_id'],
                    'category_desc'=> $row['item_category_id'],
                ];
                $itemCategoryId=DB::table('category')->insertGetId($newItemCategory);
            }else{
                $itemCategoryId=$item_category->id;
            }

            $newItem=Item::create([
                'item_name'=>$row['item_name'],
                'item_desc'=>$row['item_desc'],
                'item_qty'=>$row['item_qty'],
                'unit_type_id'=>$unitTypeId,
                'user_id'=>$this->id,
                'item_category_id'=>$itemCategoryId,
                'item_buy_price'=>$row['item_buy_price'],
            ]);
        }
    }

    // public function model(array $row)
    // {
    //     return new Item([
    //         'item_name'=>$row['item_name'],
    //         'item_desc'=>$row['item_desc'],
    //         'item_qty'=>$row['item_qty'],
    //         'unit_type_id'=>$row['unit_type_id'],
    //         'user_id'=>1,
    //         'item_category_id'=>$row['item_category_id'],
    //         'item_buy_price'=>$row['item_buy_price'],
    //     ]);
    // }
}
