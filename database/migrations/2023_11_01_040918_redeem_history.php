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
        Schema::create('redeem_history', function (Blueprint $table) {
            $table->string('id', 10);
            $table->integer('redeem_quantity');
            $table->integer('points_per_item');
            $table->integer('item_points_total');
            $table->string('cust_id', 10);
            $table->string('item_id', 10); 
            $table->timestamps();
        
            $table->foreign('cust_id')->references('id')->on('customer');
            $table->foreign('item_id')->references('id')->on('reward_item');
            $table->primary(['id','cust_id','item_id']);
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
