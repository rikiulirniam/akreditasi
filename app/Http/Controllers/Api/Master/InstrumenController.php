<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreInstrumenRequest;
use App\Models\Instrumen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumenController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Instrumen::with(['versiInstrumen.lembaga', 'jenjang', 'jenisInstrumen'])
            ->withCount('kriterias');

        if ($request->filled('id_jenjang')) {
            $query->where('id_jenjang', $request->query('id_jenjang'));
        }
        if ($request->filled('id_versi_instrumen')) {
            $query->where('id_versi_instrumen', $request->query('id_versi_instrumen'));
        }
        if ($request->filled('id_jenis_instrumen')) {
            $query->where('id_jenis_instrumen', $request->query('id_jenis_instrumen'));
        }

        $data = $query->latest()->get();

        return $this->successResponse($data, 'Daftar instrumen berhasil diambil');
    }

    public function store(StoreInstrumenRequest $request): JsonResponse
    {
        $data = $request->validated();

        $instrumen = DB::transaction(function () use ($data) {
            DB::table('versi_instrumen_jenjang')->insertOrIgnore([
                'id_versi_instrumen' => $data['id_versi_instrumen'],
                'id_jenjang' => $data['id_jenjang'],
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return Instrumen::create($data);
        });

        $instrumen->load([
            'versiInstrumen.lembaga',
            'jenjang',
            'jenisInstrumen',
        ])->loadCount('kriterias');

        return $this->successResponse(
            $instrumen,
            'Instrumen berhasil ditambahkan',
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $instrumen = Instrumen::with([
            'versiInstrumen.lembaga',
            'jenjang',
            'jenisInstrumen',
            'kriterias' => function ($q) {
                $q->withCount('subkriteria')->orderBy('kode_kriteria');
            },
        ])->withCount('kriterias')->find($id);

        if (! $instrumen) {
            return $this->errorResponse('Data instrumen tidak ditemukan', null, 404);
        }

        return $this->successResponse($instrumen, 'Detail instrumen berhasil diambil');
    }

    public function getHierarchy(string $id): JsonResponse
    {
        $instrumen = Instrumen::query()
            ->select([
                'id',
                'id_versi_instrumen',
                'id_jenjang',
                'id_jenis_instrumen',
            ])
            ->with([
                'versiInstrumen' => function ($q) {
                    $q->select([
                        'id',
                        'id_lembaga',
                        'nomor_versi',
                    ]);
                },
                'versiInstrumen.lembaga' => function ($q) {
                    $q->select([
                        'id',
                        'nama_lembaga',
                    ]);
                },
                'jenjang:id,nama_jenjang',
                'jenisInstrumen:id,nama_jenis',
                'kriterias' => function ($q) {
                    $q->select([
                        'id',
                        'id_instrumen',
                        'kode_kriteria',
                        'nama_kriteria',
                    ])
                        ->with([
                            'subkriteria' => function ($sub) {
                                $sub->select([
                                    'id',
                                    'id_kriteria',
                                    'kode_subkriteria',
                                    'nama_subkriteria',
                                ])
                                    ->with([
                                        'indikator' => function ($indikator) {
                                            $indikator->select([
                                                'id',
                                                'id_subkriteria',
                                                'kode_indikator',
                                                'deskripsi_indikator',
                                            ])->orderBy('kode_indikator');
                                        },
                                    ])
                                    ->orderBy('kode_subkriteria');
                            },
                        ])
                        ->orderBy('kode_kriteria');
                },
            ])
            ->find($id);

        if (! $instrumen) {
            return $this->errorResponse(
                'Data instrumen tidak ditemukan',
                null,
                404
            );
        }

        $data = [
            'id_instrumen' => $instrumen->id,

            'lembaga' => [
                'nama' => $instrumen->versiInstrumen?->lembaga?->nama_lembaga,
            ],

            'versi_instrumen' => [
                'nomor_versi' => $instrumen->versiInstrumen?->nomor_versi,
            ],

            'jenjang' => [
                'nama' => $instrumen->jenjang?->nama_jenjang,
            ],

            'jenis_instrumen' => [
                'nama' => $instrumen->jenisInstrumen?->nama_jenis,
            ],

            'kriteria' => $instrumen->kriterias->map(function ($kriteria) {
                return [
                    'kode' => $kriteria->kode_kriteria,
                    'nama' => $kriteria->nama_kriteria,

                    'subkriteria' => $kriteria->subkriteria->map(function ($subkriteria) {
                        return [
                            'kode' => $subkriteria->kode_subkriteria,
                            'nama' => $subkriteria->nama_subkriteria,

                            'indikator' => $subkriteria->indikator->map(function ($indikator) {
                                return [
                                    'kode' => $indikator->kode_indikator,
                                    'nama' => $indikator->deskripsi_indikator,
                                ];
                            })->values(),
                        ];
                    })->values(),
                ];
            })->values(),
        ];

        return $this->successResponse(
            $data,
            'Hierarchy instrumen berhasil diambil'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $instrumen = Instrumen::find($id);

        if (! $instrumen) {
            return $this->errorResponse('Data instrumen tidak ditemukan', null, 404);
        }

        $instrumen->delete();

        return $this->successResponse(null, 'Data instrumen berhasil dihapus');
    }
}
