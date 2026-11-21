<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel narasi beserta snapshot agregasi dan kunci unik project-subkriteria.
     */
    public function up(): void
    {
        Schema::create('narasi_subkriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->foreignId('id_subkriteria')->constrained('subkriteria')->cascadeOnDelete();
            $table->longText('narasi');
            $table->json('data_agregasi')->nullable();
            $table->timestamps();

            $table->unique(['id_project', 'id_subkriteria']);
        });
    }

    /**
     * Menghapus tabel narasi dan seluruh data narasi yang disimpannya.
     */
    public function down(): void
    {
        Schema::dropIfExists('narasi_subkriterias');
    }
};
