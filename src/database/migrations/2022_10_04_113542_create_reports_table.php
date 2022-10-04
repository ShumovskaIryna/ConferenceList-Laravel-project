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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('topic');
            $table->timestamp('time_start')->nullable();
            $table->timestamp('time_finish')->nullable();
            $table->string('description')->nullable();
            $table->string('file_path')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('conference_id');
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
        Schema::dropIfExists('reports');
    }
};
