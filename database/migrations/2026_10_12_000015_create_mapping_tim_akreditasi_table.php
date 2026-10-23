<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapping_tim_akreditasi', function (Blueprint $table) {
            $table->id();

            // Menggunakan foreignId (integer) mengacu ke PK project_akreditasi lokal
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();

            // ID User dari API Kelompok 2 (tanpa FK constraint lokal)
            $table->integer('id_user');

            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->string('role')->nullable(); // Opsional jika dibutuhkan penanda peran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mapping_tim_akreditasi');
    }
};
