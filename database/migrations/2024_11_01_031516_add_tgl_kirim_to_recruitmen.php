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
            $table->date('tgl_kirim')->nullable()->after('tgl_pengajuan');
            
            $table->dropColumn('tgl_persetujuan');
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
