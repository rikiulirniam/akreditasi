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
        Schema::create('project_akreditasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prodi')->constrained('prodi')->cascadeOnDelete();
            $table->foreignId('id_versi_instrumen')->constrained('versi_instrumen')->cascadeOnDelete();
            $table->foreignId('id_jenjang')->constrained('jenjang')->cascadeOnDelete();
            $table->foreignId('id_jenis_instrumen')->constrained('jenis_instrumen')->cascadeOnDelete();
            $table->string('nama_project');
            $table->year('tahun_target_submit');
            $table->string('status_project')->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_akreditasi');
    }
};
