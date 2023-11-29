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
        Schema::create('spin_event', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('spin_event_name', 50);
            $table->string('spin_event_description', 500);
            $table->integer('spin_event_quantity');
            $table->string('spin_event_deadline', 10);
            $table->string('spin_event_status', 20);
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
