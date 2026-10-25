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
        // 1. Tambah kolom id_instrumen jika belum ada di tabel kriteria
        if (! Schema::hasColumn('kriteria', 'id_instrumen')) {
            Schema::table('kriteria', function (Blueprint $table) {
                $table->uuid('id_instrumen')->nullable()->after('id');
            });
        }

        $isMysql = DB::getDriverName() === 'mysql';

        // 2. Jika id_versi_instrumen masih ada, buat nullable dan lepas foreign key jika terpasang
        if (Schema::hasColumn('kriteria', 'id_versi_instrumen')) {
            if ($isMysql) {
                $fkVersiExists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
                    ->where('TABLE_NAME', 'kriteria')
                    ->where('CONSTRAINT_NAME', 'kriteria_id_versi_instrumen_foreign')
                    ->exists();

                if ($fkVersiExists) {
                    Schema::table('kriteria', function (Blueprint $table) {
                        $table->dropForeign('kriteria_id_versi_instrumen_foreign');
                    });
                }
            }

            try {
                if ($isMysql) {
                    DB::statement('ALTER TABLE `kriteria` MODIFY `id_versi_instrumen` BIGINT UNSIGNED NULL');
                }
            } catch (Throwable $e) {
                // Abaikan jika database engine tidak mendukung modify sintaks
            }
        }

        // 3. Tambahkan foreign key id_instrumen jika belum terpasang
        if (Schema::hasTable('instrumen')) {
            $fkInstrumenExists = false;
            if ($isMysql) {
                $fkInstrumenExists = DB::table('information_schema.TABLE_CONSTRAINTS')
                    ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
                    ->where('TABLE_NAME', 'kriteria')
                    ->where('CONSTRAINT_NAME', 'kriteria_id_instrumen_foreign')
                    ->exists();
            }

            if (! $fkInstrumenExists) {
                try {
                    Schema::table('kriteria', function (Blueprint $table) {
                        $table->foreign('id_instrumen')
                            ->references('id')
                            ->on('instrumen')
                            ->cascadeOnDelete();
                    });
                } catch (Throwable $e) {
                    // Abaikan jika FK sudah ada
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kriteria', 'id_instrumen')) {
            try {
                Schema::table('kriteria', function (Blueprint $table) {
                    $table->dropForeign(['id_instrumen']);
                });
            } catch (Throwable $e) {
            }

            Schema::table('kriteria', function (Blueprint $table) {
                $table->dropColumn('id_instrumen');
            });
        }
    }
};
