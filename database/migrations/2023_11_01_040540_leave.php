<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('leave_type');
             $table->integer('totalNumber');
            $table->timestamps();

         });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave');

    }
};
