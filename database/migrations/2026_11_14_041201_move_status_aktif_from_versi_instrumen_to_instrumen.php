
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel penghubung versi dan jenjang
        Schema::create('versi_instrumen_jenjang', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_versi_instrumen')
                ->constrained('versi_instrumen')
                ->cascadeOnDelete();

            $table->foreignId('id_jenjang')
                ->constrained('jenjang')
                ->cascadeOnDelete();

            $table->boolean('status_aktif')->default(false);

            $table->timestamps();

            // Satu versi hanya punya satu relasi untuk setiap jenjang
            $table->unique(
                ['id_versi_instrumen', 'id_jenjang'],
                'versi_jenjang_unique'
            );
        });

        // Pindahkan status aktif lama ke tabel penghubung
        $dataLama = DB::table('instrumen')
            ->join(
                'versi_instrumen',
                'instrumen.id_versi_instrumen',
                '=',
                'versi_instrumen.id'
            )
            ->select(
                'instrumen.id_versi_instrumen',
                'instrumen.id_jenjang',
                'versi_instrumen.status_aktif'
            )
            ->distinct()
            ->get();

        foreach ($dataLama as $data) {
            DB::table('versi_instrumen_jenjang')->insert([
                'id_versi_instrumen' => $data->id_versi_instrumen,
                'id_jenjang' => $data->id_jenjang,
                'status_aktif' => $data->status_aktif,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus status aktif dari tabel versi lama
        Schema::table('versi_instrumen', function (Blueprint $table) {
            $table->dropColumn('status_aktif');
        });
    }

    public function down(): void
    {
        // Kembalikan kolom status aktif ke tabel versi
        Schema::table('versi_instrumen', function (Blueprint $table) {
            $table->boolean('status_aktif')->default(false);
        });

        // Jika suatu versi aktif di salah satu jenjang,
        // tandai versi tersebut aktif kembali.
        DB::table('versi_instrumen')
            ->whereIn('id', function ($query) {
                $query->select('id_versi_instrumen')
                    ->from('versi_instrumen_jenjang')
                    ->where('status_aktif', true);
            })
            ->update(['status_aktif' => true]);

        Schema::dropIfExists('versi_instrumen_jenjang');
    }
};
