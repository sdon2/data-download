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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('isp');
            $table->string('list_id');
            $table->string('sub_seq_id');
            $table->string('seq_id');
            $table->boolean('offer_suppression')->default(false);
            $table->string('offer_id')->nullable();
            $table->boolean('complaints_suppression')->default(false);
            $table->boolean('optout_suppression')->default(false);
            $table->boolean('unsubscribe_suppression')->default(false);
            $table->boolean('badmail_suppression')->default(false);
            $table->boolean('espbadmail_suppression')->default(false);
            $table->boolean('dnd_suppression')->default(false);
            $table->string('output_file');
            $table->bigInteger('data_count')->default(0);
            $table->bigInteger('suppressed_data_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
