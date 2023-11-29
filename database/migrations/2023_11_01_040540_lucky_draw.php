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
        Schema::create('lucky_draw', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('event_name', 100);
            $table->string('event_description', 500);
            $table->date('event_start');
            $table->date('event_end');
            $table->string('required_rank', 20);
            $table->integer('participant_number');
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
