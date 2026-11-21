<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'id_instrumen',
        'kode_kriteria',
        'nama_kriteria',
    ];

    protected $appends = [
        'subkriteria_count',
        'subkriterias_count',
    ];

    public function getSubkriteriaCountAttribute(): int
    {
        if (isset($this->attributes['subkriteria_count'])) {
            return (int) $this->attributes['subkriteria_count'];
        }
        if ($this->relationLoaded('subkriteria')) {
            return $this->subkriteria->count();
        }

        return 0;
    }

    public function getSubkriteriasCountAttribute(): int
    {
        return $this->subkriteria_count;
    }

    protected function casts(): array
    {
        return [
            'id_instrumen' => 'string',
        ];
    }

    /**
     * Scope hierarki lengkap kriteria sampai indikator tanpa memuat rubrik.
     */
    public function scopeCompleteHierarchy(Builder $query): Builder
    {
        return $query->select([
            'id',
            'id_instrumen',
            'kode_kriteria',
            'nama_kriteria',
        ])
            ->with([
                'subkriteria' => function ($sub): void {
                    $sub->completeHierarchy();
                },
            ])
            ->orderBy('kode_kriteria');
    }

    /**
     * Scope untuk eager load instrumen induk dan hitungan subkriteria.
     */
    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
        ])->withCount('subkriteria');
    }

    /**
     * Scope untuk filter berdasarkan UUID instrumen.
     */
    public function scopeFilterByInstrumen(Builder $query, ?string $idInstrumen = null): Builder
    {
        if ($idInstrumen !== null && $idInstrumen !== '') {
            $query->where('id_instrumen', $idInstrumen);
        }

        return $query;
    }

    /**
     * Scope untuk detail kriteria beserta subkriteria dan indikator_count.
     */
    public function scopeWithDetailedSubkriteria(Builder $query): Builder
    {
        return $query->with([
            'instrumen.versiInstrumen.lembaga',
            'instrumen.jenjang',
            'instrumen.jenisInstrumen',
            'subkriteria' => function ($q): void {
                $q->withCount('indikator')->orderBy('kode_subkriteria');
            },
        ])->withCount('subkriteria');
    }

    /**
     * Relasi ke Instrumen induk (UUID).
     */
    public function instrumen(): BelongsTo
    {
        return $this->belongsTo(Instrumen::class, 'id_instrumen');
    }

    /**
     * Relasi ke Subkriteria di bawah kriteria ini.
     */
    public function subkriteria(): HasMany
    {
        return $this->hasMany(Subkriteria::class, 'id_kriteria');
    }
}
