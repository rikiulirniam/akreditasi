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
        if (Schema::hasTable('data_sarpras_prodi')) {
            // 1. Tambahkan kolom kapasitas jika belum ada
            if (! Schema::hasColumn('data_sarpras_prodi', 'kapasitas')) {
                Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                    $table->integer('kapasitas')->nullable()->default(0);
                });
            }

            // 2. Perbaiki kolom-kolom yang sudah ada di database agar nullable (tidak error saat insert)
            if (DB::getDriverName() === 'mysql') {
                try {
                    if (Schema::hasColumn('data_sarpras_prodi', 'id_sarana')) {
                        DB::statement('ALTER TABLE data_sarpras_prodi MODIFY id_sarana BIGINT UNSIGNED NULL DEFAULT NULL');
                    }
                    if (Schema::hasColumn('data_sarpras_prodi', 'jumlah_unit')) {
                        DB::statement('ALTER TABLE data_sarpras_prodi MODIFY jumlah_unit INT NULL DEFAULT 0');
                    }
                    if (Schema::hasColumn('data_sarpras_prodi', 'kondisi')) {
                        DB::statement("ALTER TABLE data_sarpras_prodi MODIFY kondisi VARCHAR(255) NULL DEFAULT 'Baik'");
                    }
                } catch (Throwable $e) {
                    // Abaikan jika sudah nullable
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Migrasi ini tidak merusak struktur tabel atau menghapus kolom
    }
};
