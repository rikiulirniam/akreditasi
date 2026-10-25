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

    public function kriterias(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_instrumen');
    }
}
