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
        Schema::create('self_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->foreignId('id_rubrik')->nullable()->constrained('rubrik')->nullOnDelete();
            $table->decimal('skor_terbobot', 8, 2)->nullable();
            $table->text('catatan_reviewer')->nullable();
            $table->dateTime('tanggal_penilaian')->nullable();
            $table->unsignedBigInteger('asesor_id')->nullable()->index();
            $table->unsignedBigInteger('reviewer_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('self_assessment');
    }
};
