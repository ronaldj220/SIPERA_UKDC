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
            $table->unsignedBigInteger('id_users')->unique()->after('tgl_pengajuan');
            $table->foreign('id_users')->references('id')->on('users');
            $table->string('departemen')->nullable();
            $table->string('PiC')->nullable();
            $table->string('CV')->nullable();
            $table->string('transkrip_nilai')->nullable();
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
