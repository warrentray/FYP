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
        Schema::create('customer', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('status');
            $table->string('referral_code',9);
            $table->string('password');
            $table->integer('count_fail_login')->nullable();
            $table->timestamp('fail_login_time')->nullable();
            $table->integer('reward_points');
            $table->integer('cust_points');
            $table->string('cust_rank');
            $table->string('chop_quantity');
            $table->string('membershipCard'); 
            $table->string('token');
             $table->string('membership_id', 10); 
            $table->foreign('membership_id')->references('id')->on('membership');
            $table->timestamps();

         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
