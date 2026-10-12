<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VersiInstrumen extends Model
{
    use HasFactory;

    protected $table = 'versi_instrumen';

    protected $fillable = [
        'id_lembaga',
        'nomor_versi',
        'tanggal_berlaku',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'id_lembaga' => 'integer',
            'tanggal_berlaku' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke Lembaga Akreditasi penerbit versi instrumen.
     */
    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(LembagaAkreditasi::class, 'id_lembaga');
    }

    /**
     * Relasi ke daftar Kriteria pada versi instrumen ini.
     */
    public function kriteria(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_versi_instrumen');
    }

    /**
     * Relasi ke Project Akreditasi yang menggunakan versi instrumen ini.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectAkreditasi::class, 'id_versi_instrumen');
    }
}
