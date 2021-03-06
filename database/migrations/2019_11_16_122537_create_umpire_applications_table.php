<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmpireApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umpire_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('umpire_id')->unsigned();
            $table->bigInteger('tournament_id')->unsigned();
            $table->boolean('processed')->default(false);
            $table->boolean('approved')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('umpire_id')->references('id')->on('users');
            $table->foreign('tournament_id')->references('id')->on('tournaments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umpire_applications');
    }
}
