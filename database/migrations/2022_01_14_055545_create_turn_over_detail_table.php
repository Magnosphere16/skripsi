<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnOverDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_over_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('tod_turn_over_id');
            $table->foreign('tod_turn_over_id')->references('id')->on('turn_over')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('tod_period');
            $table->integer('tod_turn_over_amount');
            $table->integer('tod_target_turn_over');
            $table->integer('tod_month');
            $table->integer('tod_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turn_over_detail');
    }
}
