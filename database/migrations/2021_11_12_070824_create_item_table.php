<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_image')->nullable();
            $table->string('item_desc')->nullable();
            $table->integer('item_qty');
            $table->unsignedBigInteger('unit_type_id');
            $table->foreign('unit_type_id')->references('id')->on('unit_type')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('item_category_id')->nullable();
            $table->foreign('item_category_id')->references('id')->on('category')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('item_buy_price');
            $table->integer('item_sell_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
