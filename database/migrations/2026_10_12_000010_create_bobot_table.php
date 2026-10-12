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
        Schema::create('bobot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_indikator')->constrained('indikator')->cascadeOnDelete();
            $table->foreignId('id_jenis_instrumen')->constrained('jenis_instrumen')->cascadeOnDelete();
            $table->foreignId('id_jenjang')->constrained('jenjang')->cascadeOnDelete();
            $table->decimal('nilai_bobot', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot');
    }
};
