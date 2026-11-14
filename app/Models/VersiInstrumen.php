<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    ];

    protected function casts(): array
    {
        return [
            'id_lembaga' => 'integer',
            'tanggal_berlaku' => 'date',
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
     * Relasi ke Jenjang melalui tabel penghubung
     */
    public function jenjangs(): BelongsToMany
    {
        return $this->belongsToMany(
            Jenjang::class,
            'versi_instrumen_jenjang',
            'id_versi_instrumen',
            'id_jenjang'
        )->withPivot('status_aktif')
            ->withTimestamps();
    }

    /**
     * Relasi ke daftar Kriteria pada versi instrumen ini.
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
