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
        Schema::create('data_spmi_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_project')->constrained('project_akreditasi')->cascadeOnDelete();
            $table->foreignId('id_standar')->constrained('standar_mutu')->cascadeOnDelete();
            $table->foreignId('id_indikator')->nullable()->constrained('indikator')->nullOnDelete();
            $table->enum('jenis_kegiatan', ['PPEPP', 'AMI', 'RTM']);
            $table->date('tanggal_pelaksanaan');
            $table->text('temuan')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->string('status_penyelesaian')->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_spmi_audit');
    }
};
