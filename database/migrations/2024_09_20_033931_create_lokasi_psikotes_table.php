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
        Schema::create('lokasi_psikotes', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_psikotes')->nullable();
            $table->string('ruangan_psikotes')->nullable();
            $table->string('alamat_psikotes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_psikotes');
    }
};
