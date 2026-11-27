<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateNarasiSubkriteria extends Model
{
    protected $table = 'template_narasi_subkriteria';

    protected $fillable = [
        'id_subkriteria',
        'kategori_data',
        'nama_template',
        'template_tersedia',
        'template_tidak_tersedia',
        'sumber_data',
        'field_mapping',
        'prioritas',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'id_subkriteria' => 'integer',
            'sumber_data' => 'array',
            'field_mapping' => 'array',
            'prioritas' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForSubkriteria(Builder $query, Subkriteria $subkriteria): Builder
    {
        return $query->where(function (Builder $builder) use ($subkriteria): void {
            $builder->where('id_subkriteria', $subkriteria->id)
                ->orWhereNull('id_subkriteria');
        });
    }

    public function subkriteria(): BelongsTo
    {
        return $this->belongsTo(Subkriteria::class, 'id_subkriteria');
    }

    public static function resolveFor(Subkriteria $subkriteria, string $kategoriData): ?self
    {
        return static::query()
            ->active()
            ->where('kategori_data', $kategoriData)
            ->forSubkriteria($subkriteria)
            ->orderByRaw('CASE WHEN id_subkriteria IS NULL THEN 1 ELSE 0 END')
            ->orderBy('prioritas')
            ->first();
    }
}
