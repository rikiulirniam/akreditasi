<?php

namespace App\Models;

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
