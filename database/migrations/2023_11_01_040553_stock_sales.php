<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_sales', function (Blueprint $table) {
            $table->string('id', 10)->primary();
             $table->string('petrol_type');
            $table->double('total_liter_amount', 100,2);
             $table->date('transaction_date');
             $table->string('stock_id');
             $table->string('transaction_id');
              $table->foreign('stock_id')->references('id')->on('stock')->onDelete('cascade'); 
             $table->foreign('transaction_id')->references('id')->on('Sales_Transaction')->onDelete('cascade'); 
             $table->timestamps();

         });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_sales');

    }
};
