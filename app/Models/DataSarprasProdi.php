<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSarprasProdi extends Model
{
    use HasFactory;

    protected $table = 'data_sarpras_prodi';

    protected $fillable = [
        'id_project',
        'id_sarana',
        'jumlah_unit',
        'kondisi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_sarana' => 'integer',
            'jumlah_unit' => 'integer',
        ];
    }

    /**
     * Relasi ke Project Akreditasi.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }
}
