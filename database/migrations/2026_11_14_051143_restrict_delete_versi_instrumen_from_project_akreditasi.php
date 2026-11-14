<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->dropForeign(['id_versi_instrumen']);
        });

        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->foreign('id_versi_instrumen')
                ->references('id')
                ->on('versi_instrumen')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->dropForeign(['id_versi_instrumen']);
        });

        Schema::table('project_akreditasi', function (Blueprint $table) {
            $table->foreign('id_versi_instrumen')
                ->references('id')
                ->on('versi_instrumen')
                ->cascadeOnDelete();
        });
    }
};
