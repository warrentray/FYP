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
        Schema::create('station', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name', 50);
            $table->string('address', 100);
            $table->string('operationHours', 20);
            $table->string('phoneNo', 12);
            $table->string('status', 20);
            $table->binary('qr');
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