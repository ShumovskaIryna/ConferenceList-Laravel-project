<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            Schema::create('conferences_users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('conference_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
                $table->foreign('conference_id')->references('id')->on('conferences')
                    ->onDelete('cascade');
                $table->timestamp('joined_at')->nullable();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conferences_users');
    }
};
