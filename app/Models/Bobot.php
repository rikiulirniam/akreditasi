<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bobot extends Model
{
    use HasFactory;

    protected $table = 'bobot';

    protected $fillable = [
        'id_indikator',
        'id_jenis_instrumen',
        'id_jenjang',
        'nilai_bobot',
    ];

    protected function casts(): array
    {
        return [
            'id_indikator' => 'integer',
            'id_jenis_instrumen' => 'integer',
            'id_jenjang' => 'integer',
            'nilai_bobot' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke Indikator penilaian.
     */
    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    /**
     * Relasi ke Jenis Instrumen.
     */
    public function jenisInstrumen(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    /**
     * Relasi ke Jenjang pendidikan.
     */
    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }
}
