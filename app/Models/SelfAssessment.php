<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SelfAssessment extends Model
{
    use HasFactory;

    protected $table = 'self_assessment';

    protected $fillable = [
        'id_project',
        'id_indikator',
        'id_rubrik',
        'skor_terbobot',
        'catatan_reviewer',
        'tanggal_penilaian',
        'reviewer_id',
        'tanggapan_kaprodi',
        'status_verifikasi_bukti',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_indikator' => 'integer',
            'id_rubrik' => 'integer',
            'skor_terbobot' => 'decimal:2',
            'tanggal_penilaian' => 'datetime',
            'catatan_reviewer' => 'string',
            'reviewer_id' => 'integer',
            'status_verifikasi_bukti' => 'string',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }

    public function rubrik(): BelongsTo
    {
        return $this->belongsTo(Rubrik::class, 'id_rubrik');
    }

    /**
     * Scope untuk memfilter penilaian berdasarkan project ID.
     */
    public function scopeForProject(Builder $query, int $projectId): Builder
    {
        return $query->where('id_project', $projectId);
    }

    /**
     * Scope untuk memfilter penilaian berdasarkan indikator ID.
     */
    public function scopeForIndikator(Builder $query, int $indikatorId): Builder
    {
        return $query->where('id_indikator', $indikatorId);
    }

    /**
     * Scope untuk hanya memuat penilaian yang memiliki penjelasan / tanggapan kaprodi.
     */
    public function scopeWithPenjelasan(Builder $query): Builder
    {
        return $query->whereNotNull('tanggapan_kaprodi')->where('tanggapan_kaprodi', '!=', '');
    }

    /**
     * Scope untuk eager loading relasi rubrik dan hierarki indikator -> subkriteria -> kriteria.
     */
    public function scopeWithRubrikAndIndikator(Builder $query): Builder
    {
        return $query->with(['rubrik', 'indikator.subkriteria.kriteria']);
    }
}
