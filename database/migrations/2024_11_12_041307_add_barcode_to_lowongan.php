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
        Schema::table('lowongan', function (Blueprint $table) {
            $table->string('link_lowongan')->nullable()->after('name_lowongan');
            $table->string('lowongan_code')->nullable()->after('link_lowongan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan', function (Blueprint $table) {
            //
        });
    }
};
