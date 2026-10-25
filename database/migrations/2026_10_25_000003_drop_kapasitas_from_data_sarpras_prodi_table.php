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
        if (Schema::hasTable('data_sarpras_prodi') && Schema::hasColumn('data_sarpras_prodi', 'kapasitas')) {
            Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                $table->dropColumn('kapasitas');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('data_sarpras_prodi') && ! Schema::hasColumn('data_sarpras_prodi', 'kapasitas')) {
            Schema::table('data_sarpras_prodi', function (Blueprint $table) {
                $table->integer('kapasitas')->default(0);
            });
        }
    }
};
