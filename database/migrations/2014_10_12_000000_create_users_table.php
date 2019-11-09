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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('umpire_level')->unsigned();
            $table->bigInteger('referee_level')->unsigned();
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('deleted');
            $table->foreign('umpire_level')->references('id')->on('umpire_levels');
            $table->foreign('referee_level')->references('id')->on('referee_levels');
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
