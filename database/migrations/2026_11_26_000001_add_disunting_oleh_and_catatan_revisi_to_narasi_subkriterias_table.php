<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom disunting_oleh dan catatan_revisi pada tabel narasi_subkriterias secara non-destruktif.
     */
    public function up(): void
    {
        if (Schema::hasTable('narasi_subkriterias')) {
            Schema::table('narasi_subkriterias', function (Blueprint $table) {
                if (! Schema::hasColumn('narasi_subkriterias', 'disunting_oleh')) {
                    $table->string('disunting_oleh')->nullable()->after('narasi');
                }
                if (! Schema::hasColumn('narasi_subkriterias', 'catatan_revisi')) {
                    $table->text('catatan_revisi')->nullable()->after('disunting_oleh');
                }
            });
        }
    }

    /**
     * Membatalkan penambahan kolom.
     */
    public function down(): void
    {
        if (Schema::hasTable('narasi_subkriterias')) {
            Schema::table('narasi_subkriterias', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('narasi_subkriterias', 'disunting_oleh')) {
                    $columns[] = 'disunting_oleh';
                }
                if (Schema::hasColumn('narasi_subkriterias', 'catatan_revisi')) {
                    $columns[] = 'catatan_revisi';
                }
                if (! empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
