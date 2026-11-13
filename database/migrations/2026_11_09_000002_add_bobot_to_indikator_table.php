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
        if (Schema::hasTable('indikator') && ! Schema::hasColumn('indikator', 'bobot')) {
            Schema::table('indikator', function (Blueprint $table) {
                if (Schema::hasColumn('indikator', 'parameter_penilaian')) {
                    $table->dropColumn('parameter_penilaian');
                }
                $table->decimal('bobot', 8, 2)->default(1.0)->after('deskripsi_indikator');
            });
        }

        if (Schema::hasTable('data_spmi_audit') && Schema::hasColumn('data_spmi_audit', 'id_standar')) {
            Schema::table('data_spmi_audit', function (Blueprint $table) {
                $table->dropForeign(['id_standar']);
                $table->dropColumn('id_standar');
            });
        }

        if (Schema::hasTable('standar_mutu')) {
            Schema::dropIfExists('standar_mutu');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('indikator') && Schema::hasColumn('indikator', 'bobot')) {
            Schema::table('indikator', function (Blueprint $table) {
                $table->dropColumn('bobot');
            });
        }
    }
};
