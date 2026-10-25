<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instrumen extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'instrumen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_versi_instrumen',
        'id_jenjang',
        'id_jenis_instrumen',
    ];

    protected $appends = [
        'kriterias_count',
        'kriteria_count',
    ];

    public function getKriteriasCountAttribute(): int
    {
        if (isset($this->attributes['kriterias_count'])) {
            return (int) $this->attributes['kriterias_count'];
        }
        if (isset($this->attributes['kriteria_count'])) {
            return (int) $this->attributes['kriteria_count'];
        }
        if ($this->relationLoaded('kriterias')) {
            return $this->kriterias->count();
        }
        if ($this->relationLoaded('kriteria')) {
            return $this->kriteria->count();
        }

        return 0;
    }

    public function getKriteriaCountAttribute(): int
    {
        return $this->kriterias_count;
    }

    protected function casts(): array
    {
        return [
            'id_versi_instrumen' => 'integer',
            'id_jenjang' => 'integer',
            'id_jenis_instrumen' => 'integer',
        ];
    }

    public function versiInstrumen(): BelongsTo
    {
        return $this->belongsTo(VersiInstrumen::class, 'id_versi_instrumen');
    }

    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }

    public function jenisInstrumen(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    /**
     * Alias relasi ke Jenis Instrumen / Akreditasi.
     */
    public function jenisAkreditasi(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    public function kriterias(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_instrumen');
    }

    /**
     * Alias relasi ke Kriteria.
     */
    public function kriteria(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_instrumen');
    }
}
