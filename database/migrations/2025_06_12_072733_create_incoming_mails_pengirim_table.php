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
        Schema::create('incoming_mails_pengirim', function (Blueprint $table) {
            $table->id();

            $table->foreignId('incoming_mail_id')
                ->constrained('incoming_mails')
                ->onDelete('cascade');

            $table->foreignId('institution_id')
                ->constrained('institutions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_mails_pengirim');
    }
};
