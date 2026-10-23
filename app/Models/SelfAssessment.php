<?php

namespace App\Models;

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
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_indikator' => 'integer',
            'id_rubrik' => 'integer',
            'skor_terbobot' => 'decimal:2',
            'tanggal_penilaian' => 'datetime',
            'reviewer_id' => 'integer',
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
}
