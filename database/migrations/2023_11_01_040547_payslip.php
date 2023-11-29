<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslip', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->date('date')->nullable();
             $table->double('total_amount', 8, 2);
             $table->double('epf', 8, 2);
             $table->double('SOCSO', 8, 2); 
            $table->double('EIS', 8, 2);    
            $table->double('leave_amount', 8, 2);
            $table->double('medical_amount', 8, 2); 
           $table->double('netAmount', 8, 2);       
             $table->string('leave_id', 10);
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
        Schema::dropIfExists('payslip');

    }
};
