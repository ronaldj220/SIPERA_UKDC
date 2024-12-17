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
        Schema::table('posisi_lamaran', function (Blueprint $table) {
            $table->string('unit_kerja')->nullable()->after('posisi');
            $table->string('status_pegawai')->nullable()->after('unit_kerja');
            $table->date('masa_percobaan_awal')->nullable()->after('status_pegawai');
            $table->date('masa_percobaan_akhir')->nullable()->after('masa_percobaan_awal');
            $table->integer('lama_masa_percobaan')->nullable()->after('masa_percobaan_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posisi_lamaran', function (Blueprint $table) {
            //
        });
    }
};
