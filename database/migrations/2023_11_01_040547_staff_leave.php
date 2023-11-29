<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_leave', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('leaveType');
             $table->integer('totalLeave');
             $table->integer('leaveBal');
            $table->string('reason', 100);
            $table->date('applyStartDate')->nullable();
            $table->date('applyEndDate')->nullable();
            $table->string('status', 100);
            $table->string('leave_id', 100);
            $table->string('user_id', 100);
              $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade'); 
            $table->foreign('leave_id')->references('id')->on('leave')->onDelete('cascade'); 
            
            $table->timestamps();

         }); 
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_leave');

    }
};
