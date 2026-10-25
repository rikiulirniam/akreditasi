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
        if (Schema::hasTable('data_spmi_audit') && ! Schema::hasColumn('data_spmi_audit', 'tahun_audit')) {
            Schema::table('data_spmi_audit', function (Blueprint $table) {
                $table->year('tahun_audit')->nullable()->default(date('Y'))->after('tanggal_pelaksanaan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('data_spmi_audit') && Schema::hasColumn('data_spmi_audit', 'tahun_audit')) {
            Schema::table('data_spmi_audit', function (Blueprint $table) {
                $table->dropColumn('tahun_audit');
            });
        }
    }
};
