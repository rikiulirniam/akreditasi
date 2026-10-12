<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LembagaAkreditasi extends Model
{
    use HasFactory;

    protected $table = 'lembaga_akreditasi';

    protected $fillable = [
        'nama_lembaga',
        'keterangan',
    ];

    /**
     * Relasi ke Versi Instrumen yang dirilis oleh lembaga ini.
     */
    public function versiInstrumen(): HasMany
    {
        return $this->hasMany(VersiInstrumen::class, 'id_lembaga');
    }
}
