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
        Schema::create('data_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('isp', 255);
            $table->string('filename', 255);
            $table->unsignedBigInteger('count')->default(0);
            $table->enum('status', ['processing', 'completed', 'failed'])->default('processing');
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_uploads');
    }
};