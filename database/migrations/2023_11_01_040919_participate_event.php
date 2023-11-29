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
        Schema::create('participate_event', function (Blueprint $table) {
            $table->string('event_id'); 
            $table->string('cust_id'); 
            $table->date('participate_date'); 
            
            $table->foreign('event_id')->references('id')->on('lucky_draw')->onDelete('cascade'); 
            $table->foreign('cust_id')->references('id')->on('customer')->onDelete('cascade'); 
            $table->primary(['event_id','cust_id']);
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
