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
        Schema::create('outgoing_mails', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_kirim');
            $table->date('tanggal_terima');
            $table->string('no_surat');
            $table->text('isi_surat');
            $table->text('feedback_surat')->nullable();
            $table->date('feedback_date')->nullable();
            $table->string('tipe_upload')->nullable();
            $table->string('dokumen_surat');
            $table->string('dokumen')->nullable();
            $table->string('hash_file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_mails');
    }
};
