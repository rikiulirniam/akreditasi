<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rubrik extends Model
{
    use HasFactory;

    protected $table = 'rubrik';

    protected $fillable = [
        'id_indikator',
        'skor',
        'deskripsi_rubrik',
    ];

    protected function casts(): array
    {
        return [
            'id_indikator' => 'integer',
            'skor' => 'integer',
        ];
    }

    /**
     * Proteksi soft guard: cek apakah rubrik sedang digunakan dalam transaksi penilaian aktif.
     */
    public function isUsedInActiveTransactions(): bool
    {
        return $this->selfAssessments()->exists();
    }

    /**
     * Relasi ke Indikator induk.
     */
    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    /**
     * Relasi ke entri Self Assessment yang memilih rubrik ini.
     */
    public function selfAssessments(): HasMany
    {
        return $this->hasMany(SelfAssessment::class, 'id_rubrik');
    }
}
