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
        Schema::create('prodi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_upps')->nullable()->index();
            $table->string('kode_prodi')->unique();
            $table->string('nama_prodi');
            $table->string('akreditasi');
            $table->timestamps();

            $table->foreign('id_upps')->references('id')->on('prodi')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
