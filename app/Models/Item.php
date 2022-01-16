<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table='item';
    public $timestamps = false;

    protected $fillable = ['item_name', 'item_desc', 'item_image','item_qty', 'unit_type_id','item_category_id','user_id','item_buy_price', 'item_sell_price'];

    public function unitType() {
        return $this->belongsTo(UnitType::class);
    }
    public function category() {
        return $this->belongsTo(Category::class,'item_category_id');
    }
}
