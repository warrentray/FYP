<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('ShiftType', 50);
            $table->string('ShiftChangeStatus', 20);
            $table->date('ChangeDate')->nullable();
            $table->string('Reason', 100);

            $table->timestamps();
         });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift');

    }
};
