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
        Schema::table('self_assessment', function (Blueprint $table) {
            $table->enum('status_verifikasi_bukti', ['pending', 'disetujui', 'perlu_revisi'])
                  ->default('pending')
                  ->after('tanggapan_kaprodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('self_assessment', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi_bukti');
        });
    }
};