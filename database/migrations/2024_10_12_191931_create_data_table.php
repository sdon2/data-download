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
        Schema::create('data', function (Blueprint $table) {
            //['emid', 'email', 'ds', 'isp', 'edate', 'e_ip', 'fname', 'lname', 'suburl', 'subdate', 'click', 'open', 'flag']
            $table->string('emid', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('ds', 255)->nullable();
            $table->string('isp', 255)->nullable();
            $table->string('edate', 255)->nullable();
            $table->string('e_ip', 255)->nullable();
            $table->string('fname', 255)->nullable();
            $table->string('lname', 255)->nullable();
            $table->string('suburl', 255)->nullable();
            $table->string('subdate', 255)->nullable();
            $table->string('click', 255)->nullable();
            $table->string('open', 255)->nullable();
            $table->string('flag', 255)->nullable();
            $table->string('identifier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
