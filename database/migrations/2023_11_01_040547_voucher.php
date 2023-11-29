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
        Schema::create('voucher', function (Blueprint $table) {
            $table->string('id', 10);
            $table->string('voucher_code', 50);
            $table->string('voucher_name', 50);
            $table->integer('voucher_quantity');
            $table->string('voucher_category', 12);
            $table->date('voucher_deadline');
            $table->string('voucher_terms', 500);
            $table->date('voucher_generated_date');
            $table->date('redeem_date');
            $table->string('voucher_qr', 100);
            $table->string('user_id', 10)->nullable();
            $table->string('cust_id', 10)->nullable();

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('cust_id')->references('id')->on('customer');
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
