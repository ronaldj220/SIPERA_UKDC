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
        Schema::create('psikotes', function (Blueprint $table) {
            $table->id();
            $table->string('no_doku_psikotes')->nullable();
            $table->string('no_doku_rektor')->nullable();
            $table->unsignedBigInteger('id_rekrutmen')->unique();
            $table->foreign('id_rekrutmen')->references('id')->on('recruitmen');
            $table->string('tempat_pengajuan')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_hadir')->nullable();
            $table->time('jam_hadir')->nullable();
            $table->string('lokasi_hadir')->nullable();
            $table->string('link_psikotes')->nullable();
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psikotes');
    }
};
