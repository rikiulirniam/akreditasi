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
        if (Schema::hasTable('self_assessment') && ! Schema::hasColumn('self_assessment', 'tanggapan_kaprodi')) {
            Schema::table('self_assessment', function (Blueprint $table) {
                $table->text('tanggapan_kaprodi')->nullable()->after('catatan_reviewer');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('self_assessment') && Schema::hasColumn('self_assessment', 'tanggapan_kaprodi')) {
            Schema::table('self_assessment', function (Blueprint $table) {
                $table->dropColumn('tanggapan_kaprodi');
            });
        }
    }
};
