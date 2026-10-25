<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $isMysql = DB::getDriverName() === 'mysql';

        if ($isMysql) {
            // 1. Drop foreign key id_prodi pada project_akreditasi jika masih terpasang
            if (Schema::hasTable('project_akreditasi')) {
                $fkProdiExists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
                    ->where('TABLE_NAME', 'project_akreditasi')
                    ->where('CONSTRAINT_NAME', 'project_akreditasi_id_prodi_foreign')
                    ->exists();

                if ($fkProdiExists) {
                    Schema::table('project_akreditasi', function (Blueprint $table) {
                        $table->dropForeign('project_akreditasi_id_prodi_foreign');
                    });
                }
            }

            // 2. Drop foreign key id_user pada mapping_tim_akreditasi jika masih terpasang
            if (Schema::hasTable('mapping_tim_akreditasi')) {
                $fkUserExists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
                    ->where('TABLE_NAME', 'mapping_tim_akreditasi')
                    ->where('CONSTRAINT_NAME', 'mapping_tim_akreditasi_id_user_foreign')
                    ->exists();

                if ($fkUserExists) {
                    Schema::table('mapping_tim_akreditasi', function (Blueprint $table) {
                        $table->dropForeign('mapping_tim_akreditasi_id_user_foreign');
                    });
                }
            }

            // 3. Drop foreign key reviewer_id pada self_assessment jika masih terpasang
            if (Schema::hasTable('self_assessment')) {
                $fkReviewerExists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
                    ->where('TABLE_NAME', 'self_assessment')
                    ->where('CONSTRAINT_NAME', 'self_assessment_reviewer_id_foreign')
                    ->exists();

                if ($fkReviewerExists) {
                    Schema::table('self_assessment', function (Blueprint $table) {
                        $table->dropForeign('self_assessment_reviewer_id_foreign');
                    });
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu menambahkan kembali foreign key ke tabel eksternal prodi/users
    }
};
