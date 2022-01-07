<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnOverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turn_over', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_user_id');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('to_turnover_duration');
            $table->integer('to_current_turnover');
            $table->integer('to_current_month_target_turnover');
            $table->integer('to_final_target_turnover');
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
        Schema::dropIfExists('turn_over');
    }
}
