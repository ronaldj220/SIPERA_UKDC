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
            $table->unsignedBigInteger('id_departemen')->unique()->after('id_users');
            $table->foreign('id_departemen')->references('id')->on('users');
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
