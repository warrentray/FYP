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
        Schema::create('reward_item', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('item_name', 50);
            $table->string('item_description', 500);
            $table->integer('item_quantity');
            $table->integer('item_points_amount');
            $table->text('item_qr');
            $table->binary('item_image');
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
