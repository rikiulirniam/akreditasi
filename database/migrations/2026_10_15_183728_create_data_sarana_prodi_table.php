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
            $table->foreignId('id_prasarana')->nullable()->constrained('data_sarpras_prodi')->nullOnDelete();
            $table->integer('jumlah_unit')->nullable();
            $table->string('kondisi')->nullable();
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
