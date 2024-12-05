<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('jadwal_tes_id')->constrained('jadwal_tes')->onDelete('cascade');
            $table->string('status_daftar')->default('dalam konfirmasi');
            ;
            $table->string('ruangan')->nullable();
            $table->string('status_tes')->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->string('no_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
