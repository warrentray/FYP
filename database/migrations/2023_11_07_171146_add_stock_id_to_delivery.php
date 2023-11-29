<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockIdToDelivery extends Migration
{
   public function up()
{
    Schema::table('delivery', function (Blueprint $table) {
        if (!Schema::hasColumn('delivery', 'stock_id')) {
            $table->string('stock_id', 10)->after('user_id'); // Adjust the data type and length as needed
            $table->foreign('stock_id')->references('id')->on('stock');
        }
    });
}

    public function down()
    {
        Schema::table('delivery', function (Blueprint $table) {
            $table->dropForeign(['stock_id']);
            $table->dropColumn('stock_id');
        });
    }
}
