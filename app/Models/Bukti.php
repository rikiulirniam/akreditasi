<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bukti extends Model
{
    use HasFactory;

    protected $table = 'bukti';

    protected $fillable = [
        'id_lembar_prodi',
        'id_jenis_bukti',
        'deskripsi_bukti',
        'link_bukti',
        'tanggal_up',
        'masa_berlaku',
        'status_validasi',
    ];

    protected function casts(): array
    {
        return [
            'id_lembar_prodi' => 'integer',
            'id_jenis_bukti' => 'integer',
            'tanggal_up' => 'datetime',
            'masa_berlaku' => 'date',
        ];
    }

    /**
     * Relasi ke Lembar Prodi pemilik bukti dokumen.
     */
    public function lembarProdi(): BelongsTo
    {
        return $this->belongsTo(LembarProdi::class, 'id_lembar_prodi');
    }

    /**
     * Relasi ke Jenis Bukti.
     */
    public function jenisBukti(): BelongsTo
    {
        return $this->belongsTo(JenisBukti::class, 'id_jenis_bukti');
    }
}
