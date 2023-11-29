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
        Schema::create('user', function (Blueprint $table) {
            $table->string('id',10)->primary();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('identityCard')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('gender');
            $table->integer('count_fail_login')->nullable();
            $table->timestamp('fail_login_time')->nullable();
            $table->string('token');
            $table->string('status');
            $table->string('shift_id', 10);
              $table->string('salary_id', 10);
            $table->string('station_id', 10);

            $table->foreign('shift_id')->references('id')->on('shift');
               $table->foreign('salary_id')->references('id')->on('salary');
            $table->foreign('station_id')->references('id')->on('station');

            $table->timestamps();
        });
    }
 
 
    public function down(): void
    {
        Schema::dropIfExists('user');

     }
};
