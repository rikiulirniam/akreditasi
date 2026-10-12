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
}
