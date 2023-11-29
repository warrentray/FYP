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
        Schema::create('petrol', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('petrol_name', 20);
            $table->string('petrol_type', 20);
            $table->float('price_per_liter', 5, 2);
            $table->string('stock_id');
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petrol');

    }
};
