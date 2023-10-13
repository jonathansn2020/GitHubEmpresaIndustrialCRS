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
        Schema::create('reworks', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->time('hour');
            $table->date('start')->nullable();
            $table->time('start_hour')->nullable();
            $table->date('end')->nullable();
            $table->time('end_hour')->nullable();
            $table->unsignedBigInteger('activity_project_id');
            $table->foreign('activity_project_id')->references('id')->on('activity_project');

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
        Schema::dropIfExists('reworks');
    }
};
