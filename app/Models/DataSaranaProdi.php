<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataSaranaProdi extends Model
{
    use HasFactory;

    protected $table = 'data_sarana_prodi';

    protected $fillable = [
        'id_prasarana',
        'jumlah_unit',
        'kondisi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'id_prasarana' => 'integer',
            'jumlah_unit' => 'integer',
        ];
    }

    /**
     * Relasi ke Data Prasarana Prodi (parent).
     */
    public function prasarana(): BelongsTo
    {
        return $this->belongsTo(DataSarprasProdi::class, 'id_prasarana');
    }
}
