<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subkriteria extends Model
{
    use HasFactory;

    protected $table = 'subkriteria';

    protected $fillable = [
        'id_kriteria',
        'kode_subkriteria',
        'nama_subkriteria',
    ];

    protected $appends = [
        'indikator_count',
        'indikators_count',
    ];

    public function getIndikatorCountAttribute(): int
    {
        if (isset($this->attributes['indikator_count'])) {
            return (int) $this->attributes['indikator_count'];
        }
        if (isset($this->attributes['indikators_count'])) {
            return (int) $this->attributes['indikators_count'];
        }
        if ($this->relationLoaded('indikator')) {
            return $this->indikator->count();
        }
        if ($this->relationLoaded('indikators')) {
            return $this->indikators->count();
        }

        return 0;
    }

    public function getIndikatorsCountAttribute(): int
    {
        return $this->indikator_count;
    }

    protected function casts(): array
    {
        return [
            'id_kriteria' => 'integer',
        ];
    }

    /**
     * Relasi ke Kriteria induk.
     */
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    /**
     * Relasi ke Indikator di bawah subkriteria ini.
     */
    public function indikator(): HasMany
    {
        return $this->hasMany(Indikator::class, 'id_subkriteria');
    }

    /**
     * Alias relasi ke Indikator.
     */
    public function indikators(): HasMany
    {
        return $this->hasMany(Indikator::class, 'id_subkriteria');
    }
}
