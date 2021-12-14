<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table='transaction_detail';

    protected $fillable = ['td_transaction_id','td_item_id','td_item_qty','td_item_price','td_sub_total_price'];
    public $timestamps = false;
}
