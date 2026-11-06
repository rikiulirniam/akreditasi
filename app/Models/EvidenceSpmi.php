<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceSpmi extends Model
{
    use HasFactory;

    protected $table = 'evidence_spmi';

    protected $fillable = [
        'project_id',
        'link_bukti_evaluasi',
        'deskripsi_bukti_evaluasi',
        'link_bukti_pengendalian',
        'deskripsi_bukti_pengendalian',
        'link_bukti_dampak',
        'deskripsi_bukti_dampak',
        'link_dokumen_implementasi',
        'deskripsi_dokumen_implementasi',
    ];

    /**
     * Cast attributes.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'project_id' => 'integer',
        ];
    }

    /**
     * Relasi ke model Project (ProjectAkreditasi).
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}

