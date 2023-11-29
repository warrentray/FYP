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
        Schema::create('sales_transaction', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('transaction_amount', 50);
            $table->string('petrol_type', 100);
            $table->float('liter_amount', 3, 2);
            $table->string('station_id', 10);
            $table->string('cust_id', 10);
            $table->string('payment_id', 10);
            $table->string('user_id', 10)->nullable();
            $table->string('stock_id', 10)->nullable();

            $table->foreign('station_id')->references('id')->on('station');
            $table->foreign('cust_id')->references('id')->on('customer');
            $table->foreign('payment_id')->references('id')->on('payment');
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
        //
    }
};
