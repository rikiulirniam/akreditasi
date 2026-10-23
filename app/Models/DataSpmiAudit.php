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
        'tahun_audit',
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
            'tahun_audit' => 'integer',
            'tanggal_pelaksanaan' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    public function standarMutu(): BelongsTo
    {
        return $this->belongsTo(StandarMutu::class, 'id_standar');
    }

    public function indikator(): BelongsTo
    {
        return $this->belongsTo(Indikator::class, 'id_indikator');
    }
}
