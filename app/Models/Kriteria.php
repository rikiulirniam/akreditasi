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
        'id_versi_instrumen',
        'kode_kriteria',
        'nama_kriteria',
    ];

    protected function casts(): array
    {
        return [
            'id_versi_instrumen' => 'integer',
        ];
    }

    /**
     * Relasi ke Versi Instrumen induk.
     */
    public function versiInstrumen(): BelongsTo
    {
        return $this->belongsTo(VersiInstrumen::class, 'id_versi_instrumen');
    }

    /**
     * Relasi ke Subkriteria di bawah kriteria ini.
     */
    public function subkriteria(): HasMany
    {
        return $this->hasMany(Subkriteria::class, 'id_kriteria');
    }
}
