<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
     * Relasi ke daftar Instrumen pada versi ini.
     */
    public function instrumen(): HasMany
    {
        return $this->hasMany(Instrumen::class, 'id_versi_instrumen');
    }

    /**
     * Relasi ke daftar Kriteria pada versi instrumen ini melalui Instrumen.
     */
    public function kriteria(): HasManyThrough
    {
        return $this->hasManyThrough(
            Kriteria::class,
            Instrumen::class,
            'id_versi_instrumen',
            'id_instrumen',
            'id',
            'id'
        );
    }

    /**
     * Relasi ke Project Akreditasi yang menggunakan versi instrumen ini.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(ProjectAkreditasi::class, 'id_versi_instrumen');
    }
}
