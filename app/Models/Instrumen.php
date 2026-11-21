<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Instrumen extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'instrumen';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_versi_instrumen',
        'id_jenjang',
        'id_jenis_instrumen',
    ];

    protected $appends = [
        'kriterias_count',
        'kriteria_count',
    ];

    public function getKriteriasCountAttribute(): int
    {
        if (isset($this->attributes['kriterias_count'])) {
            return (int) $this->attributes['kriterias_count'];
        }
        if (isset($this->attributes['kriteria_count'])) {
            return (int) $this->attributes['kriteria_count'];
        }
        if ($this->relationLoaded('kriterias')) {
            return $this->kriterias->count();
        }
        if ($this->relationLoaded('kriteria')) {
            return $this->kriteria->count();
        }

        return 0;
    }

    public function getKriteriaCountAttribute(): int
    {
        return $this->kriterias_count;
    }

    protected function casts(): array
    {
        return [
            'id_versi_instrumen' => 'integer',
            'id_jenjang' => 'integer',
            'id_jenis_instrumen' => 'integer',
        ];
    }

    /**
     * Scope untuk eager load relasi dasar instrumen beserta jumlah kriteria.
     */
    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with(['versiInstrumen.lembaga', 'jenjang', 'jenisInstrumen'])
            ->withCount('kriterias');
    }

    /**
     * Scope untuk filtering berdasarkan id jenjang, versi, dan jenis instrumen.
     */
    public function scopeFilterByParams(
        Builder $query,
        ?int $idJenjang = null,
        ?int $idVersi = null,
        ?int $idJenis = null
    ): Builder {
        if ($idJenjang !== null) {
            $query->where('id_jenjang', $idJenjang);
        }
        if ($idVersi !== null) {
            $query->where('id_versi_instrumen', $idVersi);
        }
        if ($idJenis !== null) {
            $query->where('id_jenis_instrumen', $idJenis);
        }

        return $query;
    }

    /**
     * Scope untuk mengunci instrumen aktif default LAM-INFOKOM 2.1 Sarjana Terapan (TRK).
     */
    public function scopeActiveStatic(Builder $query): Builder
    {
        return $query->where(function (Builder $subQuery): void {
            $subQuery->where(function (Builder $q): void {
                $q->whereHas('versiInstrumen', function (Builder $v): void {
                    $v->where('nomor_versi', 'like', '%2.1%');
                })->whereHas('jenjang', function (Builder $j): void {
                    $j->where('nama_jenjang', 'like', '%Sarjana Terapan%')
                        ->orWhere('nama_jenjang', 'like', '%TRK%')
                        ->orWhere('kode_jenjang', 'D4');
                });
            })->orWhere(function (Builder $q): void {
                $q->whereExists(function ($sub): void {
                    $sub->select(DB::raw(1))
                        ->from('versi_instrumen_jenjang')
                        ->whereColumn('versi_instrumen_jenjang.id_versi_instrumen', 'instrumen.id_versi_instrumen')
                        ->whereColumn('versi_instrumen_jenjang.id_jenjang', 'instrumen.id_jenjang')
                        ->where('versi_instrumen_jenjang.status_aktif', true);
                });
            });
        });
    }

    /**
     * Alias scope untuk active static version.
     */
    public function scopeActiveVersion(Builder $query): Builder
    {
        return $this->scopeActiveStatic($query);
    }

    /**
     * Scope untuk memuat hierarki instrumen lengkap 4 level (Instrumen -> Kriteria -> Subkriteria -> Indikator).
     */
    public function scopeCompleteHierarchy(Builder $query): Builder
    {
        return $query->select([
            'id',
            'id_versi_instrumen',
            'id_jenjang',
            'id_jenis_instrumen',
        ])
            ->with([
                'versiInstrumen' => function ($q): void {
                    $q->select([
                        'id',
                        'id_lembaga',
                        'nomor_versi',
                    ]);
                },
                'versiInstrumen.lembaga' => function ($q): void {
                    $q->select([
                        'id',
                        'nama_lembaga',
                    ]);
                },
                'jenjang:id,nama_jenjang',
                'jenisInstrumen:id,nama_jenis',
                'kriterias' => function ($q): void {
                    $q->completeHierarchy();
                },
            ]);
    }

    /**
     * Scope untuk memuat detail instrumen beserta daftar kriteria dan subkriteria_count.
     */
    public function scopeWithDetailedKriterias(Builder $query): Builder
    {
        return $query->with([
            'versiInstrumen.lembaga',
            'jenjang',
            'jenisInstrumen',
            'kriterias' => function ($q): void {
                $q->withCount('subkriteria')->orderBy('kode_kriteria');
            },
        ])->withCount('kriterias');
    }

    /**
     * Menemukan instrumen aktif LAM-INFOKOM 2.1 TRK secara statis (dengan fallback ke instrumen terakhir).
     */
    public static function findActiveStatic(): ?self
    {
        /** @var self|null $active */
        $active = static::query()->activeStatic()->completeHierarchy()->first();

        if ($active) {
            return $active;
        }

        return static::query()->completeHierarchy()->latest()->first();
    }

    /**
     * Mengubah data model hierarki instrumen ke representasi array terstruktur.
     */
    public function toHierarchyArray(): array
    {
        return [
            'id_instrumen' => $this->id,
            'lembaga' => [
                'nama' => $this->versiInstrumen?->lembaga?->nama_lembaga,
            ],
            'versi_instrumen' => [
                'nomor_versi' => $this->versiInstrumen?->nomor_versi,
            ],
            'jenjang' => [
                'nama' => $this->jenjang?->nama_jenjang,
            ],
            'jenis_instrumen' => [
                'nama' => $this->jenisInstrumen?->nama_jenis,
            ],
            'kriteria' => $this->kriterias->map(function (Kriteria $kriteria): array {
                return [
                    'kode' => $kriteria->kode_kriteria,
                    'nama' => $kriteria->nama_kriteria,
                    'subkriteria' => $kriteria->subkriteria->map(function (Subkriteria $subkriteria): array {
                        return [
                            'kode' => $subkriteria->kode_subkriteria,
                            'nama' => $subkriteria->nama_subkriteria,
                            'indikator' => $subkriteria->indikator->map(function (Indikator $indikator): array {
                                return [
                                    'id' => $indikator->id,
                                    'kode' => $indikator->kode_indikator,
                                    'nama' => $indikator->deskripsi_indikator,
                                    'bobot' => (float) $indikator->bobot,
                                    'target_sumber_data' => $indikator->target_sumber_data,
                                ];
                            })->values()->all(),
                        ];
                    })->values()->all(),
                ];
            })->values()->all(),
        ];
    }

    public function versiInstrumen(): BelongsTo
    {
        return $this->belongsTo(VersiInstrumen::class, 'id_versi_instrumen');
    }

    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }

    public function jenisInstrumen(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    /**
     * Alias relasi ke Jenis Instrumen / Akreditasi.
     */
    public function jenisAkreditasi(): BelongsTo
    {
        return $this->belongsTo(JenisInstrumen::class, 'id_jenis_instrumen');
    }

    public function kriterias(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_instrumen');
    }

    /**
     * Alias relasi ke Kriteria.
     */
    public function kriteria(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_instrumen');
    }
}
