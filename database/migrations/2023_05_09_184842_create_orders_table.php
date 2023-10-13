<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();            
            $table->string('requested', 45)->nullable();
            $table->string('phone', 15);            
            $table->string('email', 35);
            $table->string('delivery_place');            
            $table->date('expected_date');
            $table->date('end_date')->nullable();
            $table->text('note')->nullable();
            $table->string('order_business');
            $table->string('cod_document', 15)->unique();
            $table->enum('status', [Order::POR_PLANIFICAR, Order::EN_PROCESO, Order::FINALIZADO])->default(Order::POR_PLANIFICAR);

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('orders');
    }
};
