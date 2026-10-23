<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('self_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->foreignId('id_rubrik')->nullable()->constrained('rubrik')->nullOnDelete();
            $table->decimal('skor_terbobot', 8, 2)->nullable();
            $table->text('catatan_reviewer')->nullable();
            $table->dateTime('tanggal_penilaian')->nullable();

            // ID Reviewer dari API Kelompok 2 (tipe integer sesuai ERD, tanpa FK constraint lokal)
            $table->integer('reviewer_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('self_assessment');
    }
};
