<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->string('id',10)->primary();
             $table->double('basic_salary', 8, 2);
             $table->string('bonus_type')->nullable();
             $table->double('bonus_amount', 8, 2);      
           
            $table->timestamps();

         });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary');

    }
};
