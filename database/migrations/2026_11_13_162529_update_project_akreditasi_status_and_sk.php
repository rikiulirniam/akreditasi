<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->date('tanggal_verifikasi_akreditasi')->nullable()->after('status_project');
            $table->string('nomor_sk_akreditasi')->nullable()->after('tanggal_verifikasi_akreditasi');
        });
    }

    public function down(): void
    {
        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->dropColumn(['tanggal_verifikasi_akreditasi', 'nomor_sk_akreditasi']);
        });
    }
};
