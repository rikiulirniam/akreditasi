<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSpmiAudit extends Model
{
    use HasFactory;

    protected $table = 'data_spmi_audit';

    protected $fillable = [
        'id_project',
        'id_standar',
        'id_indikator',
        'jenis_kegiatan',
        'tanggal_pelaksanaan',
        'temuan',
        'tindak_lanjut',
        'status_penyelesaian',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_standar' => 'integer',
            'id_indikator' => 'integer',
            'tanggal_pelaksanaan' => 'date',
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
     * Relasi ke Standar Mutu yang diaudit.
     */
    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'id_standar');
    }

    /**
     * Relasi ke Indikator terkait audit SPMI (opsional).
     */
    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }
}
