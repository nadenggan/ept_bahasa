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
        Schema::create('jadwal_tes', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('ruangan');
            $table->integer('kapasitas')->default(30);
            $table->integer('kuota')->default(30); // Kuota tersisa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_tes');
    }
};
