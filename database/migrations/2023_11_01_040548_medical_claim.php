<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_claim', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('image');
            $table->string('claim_status', 10);
            $table->double('amount', 8, 2);
            $table->string('reason', 100);
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
        Schema::dropIfExists('medical_claim');

    }
};
