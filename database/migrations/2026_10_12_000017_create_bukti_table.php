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
        Schema::create('bukti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lembar_prodi')->constrained('lembar_prodi')->cascadeOnDelete();
            $table->foreignId('id_jenis_bukti')->constrained('jenis_bukti')->cascadeOnDelete();
            $table->string('nama_file');
            $table->string('file_path');
            $table->dateTime('tanggal_up');
            $table->date('masa_berlaku')->nullable();
            $table->enum('status_validasi', ['Pending', 'Approved', 'Revision'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti');
    }
};
