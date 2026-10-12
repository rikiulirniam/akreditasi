<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LembarProdi extends Model
{
    use HasFactory;

    protected $table = 'lembar_prodi';

    protected $fillable = [
        'id_project',
        'id_indikator',
        'penjelasan_prodi',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_indikator' => 'integer',
        ];
    }

    /**
     * Relasi ke Project Akreditasi.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    /**
     * Relasi ke Indikator penilaian.
     */
    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    /**
     * Relasi ke Bukti / dokumen pendukung untuk lembar prodi ini.
     */
    public function buktis(): HasMany
    {
        return $this->hasMany(Bukti::class, 'id_lembar_prodi');
    }
}
