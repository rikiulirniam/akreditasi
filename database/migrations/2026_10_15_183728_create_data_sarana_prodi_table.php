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
        Schema::create('data_sarana_prodi', function (Blueprint $table) {
            $table->id();

            // Mengacu ke parent data_sarpras_prodi dengan cascadeOnDelete
            $table->foreignId('id_prasarana')->constrained('data_sarpras_prodi')->cascadeOnDelete();

            $table->integer('jumlah_unit')->default(0);
            $table->string('kondisi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sarana_prodi');
    }
};
