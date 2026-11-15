<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectIndicatorEvidence extends Model
{
    protected $table = 'project_indicator_evidence';

    protected $fillable = [
        'id_project',
        'id_indikator',
        'link_evidence',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_indikator' => 'integer',
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
}
