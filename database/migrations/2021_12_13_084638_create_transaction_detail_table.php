<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('td_transaction_id');
            $table->foreign('td_transaction_id')->references('id')->on('transaction_header')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('td_item_id');
            $table->foreign('td_item_id')->references('id')->on('item')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('td_item_qty');
            $table->integer('td_item_price');
            $table->integer('td_sub_total_price'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_detail');
    }
}
