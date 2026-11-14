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
        Schema::create('project_indicator_evidence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->text('link_evidence');
            $table->timestamps();

            $table->unique(['id_project', 'id_indikator']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_indicator_evidence');
    }
};
