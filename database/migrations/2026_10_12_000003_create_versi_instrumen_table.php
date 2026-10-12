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
        Schema::create('versi_instrumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lembaga')->constrained('lembaga_akreditasi')->cascadeOnDelete();
            $table->string('nomor_versi');
            $table->date('tanggal_berlaku');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versi_instrumen');
    }
};
