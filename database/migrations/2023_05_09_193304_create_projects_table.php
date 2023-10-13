<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('summary')->nullable();            
            $table->float('long', 5, 2);
            $table->float('width', 5, 2);
            $table->float('thickness', 5, 2);
            $table->integer('rows');
            $table->string('tube');
            $table->float('progress')->nullable()->default(0.00);
            $table->date('start_date_p');
            $table->date('expected_date_p');
            $table->date('end_date_p')->nullable();
            $table->string('url_photo', 2048)->nullable();                  
            $table->enum('status', [Project::POR_PLANIFICAR, Project::EN_PROCESO, Project::FINALIZADO])->default(Project::POR_PLANIFICAR);            
            
            $table->unsignedBigInteger('order_id');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

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
        Schema::dropIfExists('projects');
    }
};
