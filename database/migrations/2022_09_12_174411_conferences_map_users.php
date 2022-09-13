<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConferencesMapUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences_map_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();

            $table->bigInteger('conference_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('conference_id')->references('id')->on('conferences')
                ->onDelete('cascade');
            $table->string('joined_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conferences_map_users');

    }
}
