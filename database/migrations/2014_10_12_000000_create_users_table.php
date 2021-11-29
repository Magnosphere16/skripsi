<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userName');
            $table->string('userEmail')->unique();
            $table->string('userAddress');
            $table->integer('userPhone');
            $table->date('userBirthdate');
            $table->string('userBusinessName');
            $table->string('userBusinessCategory');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('userPassword');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
