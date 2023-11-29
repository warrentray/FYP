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
        Schema::create('chop_chop', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->date('received_date');
            $table->string('transaction_id', 10);
            $table->string('chop_reward_id', 10);
            
            $table->foreign('transaction_id')->references('id')->on('sales_transaction');
            $table->foreign('chop_reward_id')->references('id')->on('chop_reward');
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
