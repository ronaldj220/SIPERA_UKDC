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
        Schema::table('psikotes', function (Blueprint $table) {
            $table->date('tgl_kirim')->nullable()->after('no_doku_rektor');
            $table->integer('jumlah_kirim')->default(0)->after('tgl_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psikotes', function (Blueprint $table) {
            //
        });
    }
};
