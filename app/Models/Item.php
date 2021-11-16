<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table='item';
    public $timestamps = false;

    protected $fillable = ['item_name', 'item_desc', 'item_qty', 'item_buy_price', 'item_sell_price'];
}
