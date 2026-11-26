<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NarasiSubkriteria extends Model
{
    protected $table = 'narasi_subkriterias';

    protected $fillable = [
        'id_project',
        'id_subkriteria',
        'narasi',
        'disunting_oleh',
        'catatan_revisi',
        'data_agregasi',
    ];

    /**
     * Mendefinisikan konversi tipe untuk identifier dan snapshot data agregasi.
     */
    protected function casts(): array
    {
        return [
            'id_project' => 'integer',
            'id_subkriteria' => 'integer',
            'data_agregasi' => 'array',
        ];
    }

    /**
     * Relasi narasi ke project akreditasi pemiliknya.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectAkreditasi::class, 'id_project');
    }

    /**
     * Relasi narasi ke subkriteria yang dijelaskan.
     */
    public function subkriteria(): BelongsTo
    {
        return $this->belongsTo(Subkriteria::class, 'id_subkriteria');
    }
}
