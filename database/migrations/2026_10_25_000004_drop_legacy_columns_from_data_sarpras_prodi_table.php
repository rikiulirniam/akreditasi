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
            // Drop foreign key pada id_sarana jika ada di MySQL
            if (DB::getDriverName() === 'mysql') {
                try {
                    $foreignKeys = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = DATABASE() 
                          AND TABLE_NAME = 'data_sarpras_prodi' 
                          AND COLUMN_NAME = 'id_sarana' 
                          AND REFERENCED_TABLE_NAME IS NOT NULL
                    ");
                    foreach ($foreignKeys as $fk) {
                        Schema::table('data_sarpras_prodi', function (Blueprint $table) use ($fk) {
                            $table->dropForeign($fk->CONSTRAINT_NAME);
                        });
                    }
                } catch (Throwable $e) {
                    // Ignore jika tidak ada foreign key
                }
            }

            Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                $columnsToDrop = [];

                if (Schema::hasColumn('data_sarpras_prodi', 'id_sarana')) {
                    $columnsToDrop[] = 'id_sarana';
                }
                if (Schema::hasColumn('data_sarpras_prodi', 'jumlah_unit')) {
                    $columnsToDrop[] = 'jumlah_unit';
                }
                if (Schema::hasColumn('data_sarpras_prodi', 'kondisi')) {
                    $columnsToDrop[] = 'kondisi';
                }

                if (! empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('data_sarpras_prodi')) {
            Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                if (! Schema::hasColumn('data_sarpras_prodi', 'id_sarana')) {
                    $table->unsignedBigInteger('id_sarana')->nullable()->index();
                }
                if (! Schema::hasColumn('data_sarpras_prodi', 'jumlah_unit')) {
                    $table->integer('jumlah_unit')->nullable();
                }
                if (! Schema::hasColumn('data_sarpras_prodi', 'kondisi')) {
                    $table->string('kondisi')->nullable();
                }
            });
        }
    }
};
