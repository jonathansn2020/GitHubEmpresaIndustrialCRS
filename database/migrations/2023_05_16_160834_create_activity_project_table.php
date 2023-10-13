<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Activity;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_project', function (Blueprint $table) {
            $table->id();

            $table->string('priority', 20);
            $table->date('start_date');
            $table->date('expected_date');
            $table->date('true_start')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('position')->nullable();
            $table->enum('status', [Activity::ENTRADA, Activity::PROCESO, Activity::COMPLETADA])->default(Activity::ENTRADA);            


            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('operator_id')->nullable();

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('set null');

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
        Schema::dropIfExists('activity_project');
    }
};
