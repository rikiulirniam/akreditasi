<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataKeuanganProdi extends Model
{
    use HasFactory;

    protected $table = 'data_keuangan_prodi';

    protected $fillable = [
        'id_project',
        'id_pembiayaan',
        'tahun_anggaran',
        'jumlah_dana',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_pembiayaan' => 'integer',
            'tahun_anggaran' => 'integer',
            'jumlah_dana' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke Project Akreditasi.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    /**
     * Relasi ke Jenis Pembiayaan.
     */
    public function jenisPembiayaan(): BelongsTo
    {
        return $this->belongsTo(JenisPembiayaan::class, 'id_pembiayaan');
    }
}
