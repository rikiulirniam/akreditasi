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
        Schema::create('data_sarpras_prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->integer('kapasitas')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sarpras_prodi');
    }
};
