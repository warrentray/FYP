<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('training_name', 100);
            $table->string('description', 500);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('status', 30);
            $table->string('location', 100);
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
        Schema::dropIfExists('training');

    }
};
