<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->date('date');
            $table->time('time'); 
            $table->string('tank_number');
            $table->string('petrol_type');
            $table->integer('quality');
            $table->string('status');
            $table->string('user_id', 10);
            $table->string('stock_id', 10);
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('stock_id')->references('id')->on('stock');

            $table->timestamps();

         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
