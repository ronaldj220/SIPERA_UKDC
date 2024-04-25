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
        Schema::create('surat_penerimaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_doku')->nullable();
            $table->date('tgl_pengajuan')->nullable();
            $table->unsignedBigInteger('rekrutmen_id');
            $table->foreign('rekrutmen_id')->references('id')->on('recruitmen');
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tgl_kerja')->nullable();
            $table->enum('status_penerimaan', ['true', 'false'])->nullable()->default('false');
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_penerimaan');
    }
};
