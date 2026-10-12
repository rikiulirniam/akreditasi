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
        Schema::create('mapping_tim_akreditasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->unsignedBigInteger('id_user')->index();
            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_tim_akreditasi');
    }
};
