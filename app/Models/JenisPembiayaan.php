<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPembiayaan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pembiayaan';

    protected $fillable = [
        'nama_pembiayaan',
    ];

    /**
     * Relasi ke Data Keuangan Prodi yang menggunakan pos pembiayaan ini.
     */
    public function dataKeuanganProdi(): HasMany
    {
        return $this->hasMany(DataKeuanganProdi::class, 'id_pembiayaan');
    }
}
