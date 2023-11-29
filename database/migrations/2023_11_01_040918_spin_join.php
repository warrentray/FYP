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
        Schema::create('spin_join', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('item_id', 10); 
            $table->string('cust_id', 10); 
            
            $table->foreign('item_id')->references('id')->on('reward_item');
            $table->foreign('cust_id')->references('id')->on('customer');
            
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
