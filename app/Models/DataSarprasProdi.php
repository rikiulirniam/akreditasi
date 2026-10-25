<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataSarprasProdi extends Model
{
    use HasFactory;

    protected $table = 'data_sarpras_prodi';

    protected $fillable = [
        'id_project',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
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
     * Relasi 1-to-Many ke Data Sarana Prodi.
     */
    public function sarana(): HasMany
    {
        return $this->hasMany(DataSaranaProdi::class, 'id_prasarana');
    }
}
