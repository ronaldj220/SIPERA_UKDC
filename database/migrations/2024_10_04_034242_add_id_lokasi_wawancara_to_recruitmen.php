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
        Schema::table('recruitmen', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lokasi_wawancara')->nullable()->after('alasan_penerimaan'); // Tambahkan kolom id_lokasi_wawancara
            $table->foreign('id_lokasi_wawancara')->references('id')->on('lokasi_wawancara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitmen', function (Blueprint $table) {
            //
        });
    }
};
