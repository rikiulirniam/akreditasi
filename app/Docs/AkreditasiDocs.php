<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class AkreditasiDocs
{
    // ==========================================
    // PROJECTS AKREDITASI
    // ==========================================
    #[OA\Get(
        path: '/projects',
        summary: 'Mendapatkan daftar project akreditasi',
        description: 'Menampilkan list project akreditasi.',
        tags: ['Akreditasi - Project'],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar project akreditasi', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/projects',
        summary: 'Membuat project akreditasi baru',
        tags: ['Akreditasi - Project'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_prodi', 'id_versi_instrumen', 'id_jenjang', 'id_jenis_instrumen', 'nama_project', 'tahun_target_submit'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1, description: 'ID Program Studi'),
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1, description: 'ID Versi Instrumen'),
                    new OA\Property(property: 'id_jenjang', type: 'integer', example: 1, description: 'ID Jenjang'),
                    new OA\Property(property: 'id_jenis_instrumen', type: 'integer', example: 1, description: 'ID Jenis Instrumen'),
                    new OA\Property(property: 'nama_project', type: 'string', example: 'Akreditasi Program Studi D4 Rekayasa Perangkat Lunak 2026'),
                    new OA\Property(property: 'tahun_target_submit', type: 'integer', example: 2026, description: 'Tahun target submit berkas akreditasi (4 digit)'),
                    new OA\Property(property: 'status_project', type: 'string', example: 'draft', nullable: true, description: 'Status project (misal: draft, pengisian, review, submit)'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Project akreditasi berhasil dibuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}',
        summary: 'Mendapatkan detail project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail project berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/projects/{id}',
        summary: 'Memperbarui project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1),
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenjang', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenis_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'nama_project', type: 'string', example: 'Akreditasi Program Studi D4 Rekayasa Perangkat Lunak 2026 (Updated)'),
                    new OA\Property(property: 'tahun_target_submit', type: 'integer', example: 2026),
                    new OA\Property(property: 'status_project', type: 'string', example: 'pengisian'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Project berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/projects/{id}',
        summary: 'Menghapus project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Project berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Post(
        path: '/projects/{id}/mapping-tim',
        summary: 'Menyimpan pembagian tugas tim per indikator untuk project tertentu',
        description: 'Menugaskan user/dosen untuk indikator pada project akreditasi (mendukung format single assignment atau batch assignments).',
        tags: ['Akreditasi - Mapping Tim'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_user', type: 'integer', example: 101, description: 'Diisi jika single penugasan'),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1, description: 'Diisi jika single penugasan'),
                    new OA\Property(property: 'role', type: 'string', example: 'Penyusun', nullable: true),
                    new OA\Property(
                        property: 'assignments',
                        type: 'array',
                        description: 'Diisi jika batch penugasan sekaligus',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id_user', type: 'integer', example: 101),
                                new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                                new OA\Property(property: 'role', type: 'string', example: 'Penyusun', nullable: true),
                            ]
                        )
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Pembagian tugas tim akreditasi berhasil disimpan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function projectDocs() {}

    // ==========================================
    // MAPPING TIM AKREDITASI
    // ==========================================
    #[OA\Get(
        path: '/mapping-tim',
        summary: 'Mendapatkan daftar semua penugasan tim akreditasi',
        description: 'Menampilkan list seluruh mapping penugasan tim beserta relasi project dan indikator.',
        tags: ['Akreditasi - Mapping Tim'],
        responses: [
            new OA\Response(response: 200, description: 'Daftar penugasan berhasil dimuat', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )),
        ]
    )]
    #[OA\Post(
        path: '/mapping-tim',
        summary: 'Menyimpan penugasan tim akreditasi',
        description: 'Endpoint umum untuk menyimpan penugasan tim baik single record maupun batch array.',
        tags: ['Akreditasi - Mapping Tim'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_user', type: 'integer', example: 101, description: 'Wajib jika bukan batch assignments'),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1, description: 'Wajib jika bukan batch assignments'),
                    new OA\Property(property: 'role', type: 'string', example: 'Penyusun', nullable: true),
                    new OA\Property(
                        property: 'assignments',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id_user', type: 'integer', example: 101),
                                new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                                new OA\Property(property: 'role', type: 'string', example: 'Penyusun', nullable: true),
                            ]
                        )
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Penugasan berhasil disimpan', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Penugasan berhasil disimpan'),
                    new OA\Property(property: 'data', type: 'object'),
                ]
            )),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Delete(
        path: '/mapping-tim/{id}',
        summary: 'Menghapus penugasan tim akreditasi',
        tags: ['Akreditasi - Mapping Tim'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Penugasan Mapping Tim'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Penugasan berhasil dihapus', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Penugasan berhasil dihapus'),
                ]
            )),
            new OA\Response(response: 404, description: 'Penugasan tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function mappingTimDocs() {}

    // ==========================================
    // SELF ASSESSMENT
    // ==========================================
    #[OA\Get(
        path: '/self-assessment',
        summary: 'Mendapatkan daftar penilaian mandiri',
        description: 'Menampilkan list penilaian mandiri dengan opsional filter id_project dan id_indikator.',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project'),
            new OA\Parameter(name: 'id_indikator', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Indikator'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar self-assessment', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Get(
        path: '/self-assessment/{id}',
        summary: 'Mendapatkan detail penilaian mandiri',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail self-assessment berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/self-assessment/{id}',
        summary: 'Menghapus data penilaian mandiri',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data self-assessment berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Post(
        path: '/self-assessment',
        summary: 'Mengisi atau memperbarui penilaian mandiri (Self Assessment)',
        description: 'Menyimpan penilaian reviewer untuk indikator pada project. Jika id_rubrik disertakan, sistem secara otomatis menghitung skor_terbobot = rubrik.skor * bobot.nilai_bobot.',
        tags: ['Akreditasi - Self Assessment'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project', 'id_indikator'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'id_rubrik', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'reviewer_id', type: 'integer', example: 301, nullable: true, description: 'ID User Reviewer'),
                    new OA\Property(property: 'catatan_reviewer', type: 'string', example: 'Bukti dukung sangat komprehensif dan implementasi terlaksana dengan sangat baik.', nullable: true),
                    new OA\Property(property: 'tanggal_penilaian', type: 'string', format: 'date', example: '2026-10-24', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Penilaian mandiri berhasil disimpan dengan perhitungan skor terbobot otomatis', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    public function selfAssessmentDocs() {}
}
