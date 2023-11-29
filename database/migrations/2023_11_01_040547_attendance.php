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
    { Schema::create('attendance', function (Blueprint $table) {
        $table->string('id',10)->primary();
        $table->dateTime('sign_in_time')->nullable();
        $table->dateTime('sign_out_time')->nullable();
        $table->string('user_id', 10);
        $table->foreign('user_id')->references('id')->on('user');
        $table->timestamps();

     });
         
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');

    }
};
