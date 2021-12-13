<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_header', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tr_user_id');
            $table->foreign('tr_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tr_transaction_type_id');
            $table->foreign('tr_transaction_type_id')->references('id')->on('transaction_type')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tr_transaction_date');
            $table->integer('tr_total_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_header');
    }
}
