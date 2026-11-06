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
        Schema::create('evidence_spmi', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke tabel project_akreditasi (One-to-One)
            $table->foreignId('project_id')
                ->constrained('project_akreditasi')
                ->cascadeOnDelete()
                ->unique();

            // 1. Bukti Evaluasi
            $table->text('link_bukti_evaluasi')->nullable();
            $table->text('deskripsi_bukti_evaluasi')->nullable();

            // 2. Bukti Pengendalian & Peningkatan
            $table->text('link_bukti_pengendalian')->nullable();
            $table->text('deskripsi_bukti_pengendalian')->nullable();

            // 3. Bukti Dampak Tridharma
            $table->text('link_bukti_dampak')->nullable();
            $table->text('deskripsi_bukti_dampak')->nullable();

            // 4. Dokumen Implementasi Harian
            $table->text('link_dokumen_implementasi')->nullable();
            $table->text('deskripsi_dokumen_implementasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidence_spmi');
    }
};
