<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_narasi_subkriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_subkriteria')->nullable()->constrained('subkriteria')->nullOnDelete();
            $table->string('kategori_data', 80);
            $table->string('nama_template');
            $table->longText('template_tersedia');
            $table->longText('template_tidak_tersedia')->nullable();
            $table->json('sumber_data')->nullable();
            $table->json('field_mapping')->nullable();
            $table->unsignedSmallInteger('prioritas')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['kategori_data', 'is_active', 'prioritas'], 'tns_kategori_active_priority_idx');
            $table->index(['id_subkriteria', 'is_active'], 'tns_subkriteria_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_narasi_subkriteria');
    }
};
