<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instrumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('id_versi_instrumen')->constrained('versi_instrumen')->cascadeOnDelete();
            $table->foreignId('id_jenjang')->constrained('jenjang')->cascadeOnDelete();
            $table->foreignId('id_jenis_instrumen')->constrained('jenis_instrumen')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instrumen');
    }
};
