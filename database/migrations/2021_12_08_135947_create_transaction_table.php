<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_user_id');
            $table->foreign('tr_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_item_id');
            $table->foreign('tr_item_id')->references('id')->on('item')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_transaction_type_id');
            $table->foreign('tr_transaction_type_id')->references('id')->on('transaction_type')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('tr_item_qty');
            $table->integer('tr_item_price');
            $table->date('tr_transaction_date');
            $table->integer('total_price');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
