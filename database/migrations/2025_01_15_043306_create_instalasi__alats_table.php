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
        Schema::create('instalasi_alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat', 100);
            $table->string('merk', 100);
            $table->string('tipe', 100);
            $table->string('no_seri', 100);
            $table->string('lokasi', 100);
            $table->string('foto', 50);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('alat_id')->constrained('alats');
            $table->unsignedBigInteger('rumah_sakit_id');
            $table->foreign('rumah_sakit_id')->references('id')->on('rumah_sakits');
            $table->softDeletes();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalasi_alats');
    }
};
