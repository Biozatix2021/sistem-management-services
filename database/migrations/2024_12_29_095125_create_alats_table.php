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
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('merk', 100);
            $table->string('tipe', 100);
            $table->string('gambar', 100);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('instalasi_alats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_instalasi', 100);
            $table->string('no_seri', 100);
            $table->string('status_instalasi', 50);
            $table->string('keterangan', 100);
            $table->string('foto', 100);
            $table->date('tanggal_instalasi');
            $table->date('tanggal_kalibrasi');
            $table->unsignedBigInteger('alat_id');
            $table->foreign('alat_id')->references('id')->on('alats');
            $table->unsignedBigInteger('rumah_sakit_id');
            $table->foreign('rumah_sakit_id')->references('id')->on('rumah_sakits');
            $table->unsignedBigInteger('teknisi_id');
            $table->foreign('teknisi_id')->references('id')->on('teknisis');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
        Schema::dropIfExists('instalasi_alats');
    }
};
