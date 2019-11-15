<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->date('datefrom');
            $table->date('dateto');
            $table->bigInteger('venue_id')->unsigned();
            $table->boolean('international')->default(false);
            $table->bigInteger('requested_umpires')->unsigned();
            $table->timestamps(); // adds nullable created_at and updated_at timestamp equivalent columns
            $table->softDeletes();
            $table->foreign('venue_id')->references('id')->on('venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
}
