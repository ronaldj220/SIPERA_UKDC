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
        Schema::create('role_has_users', function (Blueprint $table) {
            $table->id();

            // Untuk Penghubung ke Role
            $table->unsignedBigInteger('fk_role')->unique();

            $table->foreign('fk_role')->references('id')->on('role');

            // Untuk Penghubung ke User
            $table->unsignedBigInteger('fk_user')->unique();

            $table->foreign('fk_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_users');
    }
};
