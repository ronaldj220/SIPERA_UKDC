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
        Schema::create('recruitmen', function (Blueprint $table) {
            $table->id();
            $table->string('no_doku')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->string('pemohon')->nullable();
            $table->string('email_pemohon')->nullable();
            $table->string('departemen')->nullable();
            $table->string('PiC')->nullable();
            $table->string('CV')->nullable();
            $table->string('jabatan_pelamar')->nullable();
            $table->date('tgl_hadir')->nullable();
            $table->json('jam_hadir')->nullable();
            $table->json('jam_selesai')->nullable();
            $table->json('kegiatan')->nullable();
            $table->enum('is_edited', ['true', 'false'])->nullable()->default('true');
            $table->enum('status_approval', ['submitted', 'pending', 'approved', 'rejected'])->nullable()->default('submitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitmen');
    }
};
