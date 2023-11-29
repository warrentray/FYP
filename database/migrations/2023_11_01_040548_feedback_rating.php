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
        Schema::create('feedback_rating', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('feedback_content', 500);
            $table->integer('feedback_rating'); // Use an appropriate data type for ratings
            $table->date('feedback_date'); // Use an appropriate data type for dates
            $table->string('cust_id', 10)->nullable();
            $table->string('user_id', 10)->nullable();
            $table->string('training_id', 10)->nullable();
            $table->string('station_id', 10);
            
            $table->foreign('cust_id')->references('id')->on('customer');
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('training_id')->references('id')->on('training');
            $table->foreign('station_id')->references('id')->on('station');
            
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