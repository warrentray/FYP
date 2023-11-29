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
        Schema::create('stock', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('tank_number');
            $table->integer('tank_capability');
            $table->string('tank_type');
            $table->integer('tank_quantity');
            $table->string('station_id', 10);
            $table->foreign('station_id')->references('id')->on('station');
            $table->timestamps();
        });

        // Schema::table('delivery', function (Blueprint $table) {
        //     $table->string('stock_id', 10)->after('user_id'); // Adjust the data type and length as needed
        //     $table->foreign('stock_id')->references('id')->on('stock');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('delivery', function (Blueprint $table) {
        //     $table->dropForeign(['stock_id']);
        //     $table->dropColumn('stock_id');
        // });

        Schema::dropIfExists('stock');
    }
};
