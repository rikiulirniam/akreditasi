<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class MasterDataDocs
{
    // ==========================================
    // LEMBAGA AKREDITASI
    // ==========================================
    #[OA\Get(
        path: '/master/lembaga-akreditasi',
        summary: 'Mendapatkan daftar lembaga akreditasi',
        description: 'Menampilkan list master lembaga akreditasi (misal: LAM INFOKOM, BAN-PT).',
        tags: ['Master Data - Lembaga Akreditasi'],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar lembaga akreditasi', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/lembaga-akreditasi',
        summary: 'Menambahkan lembaga akreditasi baru',
        tags: ['Master Data - Lembaga Akreditasi'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_lembaga'],
                properties: [
                    new OA\Property(property: 'nama_lembaga', type: 'string', example: 'LAM INFOKOM'),
                    new OA\Property(property: 'keterangan', type: 'string', example: 'Lembaga Akreditasi Mandiri Informatika dan Komputer', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Lembaga akreditasi berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/lembaga-akreditasi/{id}',
        summary: 'Mendapatkan detail lembaga akreditasi',
        tags: ['Master Data - Lembaga Akreditasi'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail lembaga akreditasi berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Lembaga akreditasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/lembaga-akreditasi/{id}',
        summary: 'Memperbarui data lembaga akreditasi',
        tags: ['Master Data - Lembaga Akreditasi'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nama_lembaga', type: 'string', example: 'LAM INFOKOM'),
                    new OA\Property(property: 'keterangan', type: 'string', example: 'Keterangan diperbarui', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lembaga akreditasi berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Lembaga akreditasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/lembaga-akreditasi/{id}',
        summary: 'Menghapus lembaga akreditasi',
        tags: ['Master Data - Lembaga Akreditasi'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lembaga akreditasi berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Lembaga akreditasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function lembagaDocs() {}

    // ==========================================
    // VERSI INSTRUMEN
    // ==========================================
    #[OA\Get(
        path: '/master/versi-instrumen',
        summary: 'Mendapatkan daftar versi instrumen akreditasi',
        description: 'Menampilkan list versi instrumen dengan filter id_lembaga dan status_aktif.',
        tags: ['Master Data - Versi Instrumen'],
        parameters: [
            new OA\Parameter(name: 'id_lembaga', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Lembaga'),
            new OA\Parameter(name: 'status_aktif', in: 'query', required: false, schema: new OA\Schema(type: 'boolean'), description: 'Filter status aktif (true/false)'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar versi instrumen', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/versi-instrumen',
        summary: 'Menambahkan versi instrumen baru',
        tags: ['Master Data - Versi Instrumen'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_lembaga', 'nomor_versi', 'tanggal_berlaku'],
                properties: [
                    new OA\Property(property: 'id_lembaga', type: 'integer', example: 1),
                    new OA\Property(property: 'nomor_versi', type: 'string', example: '2.1'),
                    new OA\Property(property: 'tanggal_berlaku', type: 'string', format: 'date', example: '2026-01-25'),
                    new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Versi instrumen berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/versi-instrumen/{id}',
        summary: 'Mendapatkan detail versi instrumen',
        tags: ['Master Data - Versi Instrumen'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail versi instrumen berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Versi instrumen tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/versi-instrumen/{id}',
        summary: 'Memperbarui data versi instrumen',
        tags: ['Master Data - Versi Instrumen'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_lembaga', type: 'integer', example: 1),
                    new OA\Property(property: 'nomor_versi', type: 'string', example: '2.1'),
                    new OA\Property(property: 'tanggal_berlaku', type: 'string', format: 'date', example: '2026-01-25'),
                    new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Versi instrumen berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Versi instrumen tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/versi-instrumen/{id}',
        summary: 'Menghapus versi instrumen',
        tags: ['Master Data - Versi Instrumen'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Versi instrumen berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Versi instrumen tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function versiInstrumenDocs() {}

    // ==========================================
    // KRITERIA
    // ==========================================
    #[OA\Get(
        path: '/master/kriteria',
        summary: 'Mendapatkan daftar kriteria',
        description: 'Menampilkan list master kriteria dengan opsional filter id_versi_instrumen.',
        tags: ['Master Data - Kriteria'],
        parameters: [
            new OA\Parameter(name: 'id_versi_instrumen', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Versi Instrumen'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar kriteria', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/kriteria',
        summary: 'Menambahkan kriteria baru',
        tags: ['Master Data - Kriteria'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_versi_instrumen', 'kode_kriteria', 'nama_kriteria'],
                properties: [
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'kode_kriteria', type: 'string', example: 'C.1'),
                    new OA\Property(property: 'nama_kriteria', type: 'string', example: 'Visi, Misi, Tujuan, dan Strategi'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Kriteria berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/kriteria/{id}',
        summary: 'Mendapatkan detail kriteria',
        tags: ['Master Data - Kriteria'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail kriteria berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Kriteria tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/kriteria/{id}',
        summary: 'Memperbarui kriteria',
        tags: ['Master Data - Kriteria'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_versi_instrumen', 'kode_kriteria', 'nama_kriteria'],
                properties: [
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'kode_kriteria', type: 'string', example: 'C.1'),
                    new OA\Property(property: 'nama_kriteria', type: 'string', example: 'Visi, Misi, Tujuan, dan Strategi Revisi'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Kriteria berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Kriteria tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/kriteria/{id}',
        summary: 'Menghapus kriteria',
        tags: ['Master Data - Kriteria'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Kriteria berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Kriteria tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function kriteriaDocs() {}

    // ==========================================
    // INDIKATOR
    // ==========================================
    #[OA\Get(
        path: '/master/indikator',
        summary: 'Mendapatkan daftar indikator',
        description: 'Menampilkan list master indikator dengan opsional filter id_subkriteria.',
        tags: ['Master Data - Indikator'],
        parameters: [
            new OA\Parameter(name: 'id_subkriteria', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Subkriteria'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar indikator', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/indikator',
        summary: 'Menambahkan indikator baru',
        tags: ['Master Data - Indikator'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_subkriteria', 'kode_indikator', 'nama_indikator'],
                properties: [
                    new OA\Property(property: 'id_subkriteria', type: 'integer', example: 1),
                    new OA\Property(property: 'kode_indikator', type: 'string', example: 'IND-1.1'),
                    new OA\Property(property: 'nama_indikator', type: 'string', example: 'Kejelasan dan Realisme Visi Misi'),
                    new OA\Property(property: 'deskripsi', type: 'string', example: 'Visi keilmuan PS mencerminkan keunikan dan masa depan prodi.', nullable: true),
                    new OA\Property(property: 'standar_minimum', type: 'number', format: 'float', example: 3.0, nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Indikator berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/indikator/{id}',
        summary: 'Mendapatkan detail indikator',
        tags: ['Master Data - Indikator'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail indikator berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Indikator tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/indikator/{id}',
        summary: 'Memperbarui indikator',
        tags: ['Master Data - Indikator'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_subkriteria', 'kode_indikator', 'nama_indikator'],
                properties: [
                    new OA\Property(property: 'id_subkriteria', type: 'integer', example: 1),
                    new OA\Property(property: 'kode_indikator', type: 'string', example: 'IND-1.1'),
                    new OA\Property(property: 'nama_indikator', type: 'string', example: 'Kejelasan dan Realisme Visi Misi Revisi'),
                    new OA\Property(property: 'deskripsi', type: 'string', example: 'Deskripsi diperbarui.', nullable: true),
                    new OA\Property(property: 'standar_minimum', type: 'number', format: 'float', example: 3.5, nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Indikator berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Indikator tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/indikator/{id}',
        summary: 'Menghapus indikator',
        tags: ['Master Data - Indikator'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Indikator berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Indikator tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function indikatorDocs() {}

    // ==========================================
    // RUBRIK
    // ==========================================
    #[OA\Get(
        path: '/master/rubrik',
        summary: 'Mendapatkan daftar rubrik penilaian',
        description: 'Menampilkan list master rubrik penilaian dengan opsional filter id_indikator.',
        tags: ['Master Data - Rubrik'],
        parameters: [
            new OA\Parameter(name: 'id_indikator', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Indikator'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar rubrik', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/rubrik',
        summary: 'Menambahkan rubrik penilaian baru',
        tags: ['Master Data - Rubrik'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_indikator', 'skor', 'deskripsi_kondisi'],
                properties: [
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'skor', type: 'number', format: 'float', example: 4.0),
                    new OA\Property(property: 'deskripsi_kondisi', type: 'string', example: 'Visi keilmuan PS sangat jelas, realistis, dan gayut dengan visi PT.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Rubrik berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/rubrik/{id}',
        summary: 'Mendapatkan detail rubrik',
        tags: ['Master Data - Rubrik'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail rubrik berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Rubrik tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/rubrik/{id}',
        summary: 'Memperbarui rubrik',
        tags: ['Master Data - Rubrik'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_indikator', 'skor', 'deskripsi_kondisi'],
                properties: [
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'skor', type: 'number', format: 'float', example: 4.0),
                    new OA\Property(property: 'deskripsi_kondisi', type: 'string', example: 'Deskripsi kondisi penilaian diperbarui.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Rubrik berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Rubrik tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/rubrik/{id}',
        summary: 'Menghapus rubrik',
        tags: ['Master Data - Rubrik'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Rubrik berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Rubrik tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function rubrikDocs() {}

    // ==========================================
    // STANDAR MUTU
    // ==========================================
    #[OA\Get(
        path: '/master/standar-mutu',
        summary: 'Mendapatkan daftar standar mutu',
        tags: ['Master Data - Standar Mutu'],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar standar mutu', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/standar-mutu',
        summary: 'Menambahkan standar mutu baru',
        tags: ['Master Data - Standar Mutu'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kode_standar', 'nama_standar', 'pernyataan_standar'],
                properties: [
                    new OA\Property(property: 'kode_standar', type: 'string', example: 'SM-01'),
                    new OA\Property(property: 'nama_standar', type: 'string', example: 'Standar Kompetensi Lulusan'),
                    new OA\Property(property: 'pernyataan_standar', type: 'string', example: 'Program studi wajib menetapkan profil dan capaian pembelajaran lulusan.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Standar mutu berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/standar-mutu/{id}',
        summary: 'Mendapatkan detail standar mutu',
        tags: ['Master Data - Standar Mutu'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail standar mutu berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Standar mutu tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/standar-mutu/{id}',
        summary: 'Memperbarui standar mutu',
        tags: ['Master Data - Standar Mutu'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kode_standar', 'nama_standar', 'pernyataan_standar'],
                properties: [
                    new OA\Property(property: 'kode_standar', type: 'string', example: 'SM-01'),
                    new OA\Property(property: 'nama_standar', type: 'string', example: 'Standar Kompetensi Lulusan Revisi'),
                    new OA\Property(property: 'pernyataan_standar', type: 'string', example: 'Pernyataan standar diperbarui.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Standar mutu berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Standar mutu tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/standar-mutu/{id}',
        summary: 'Menghapus standar mutu',
        tags: ['Master Data - Standar Mutu'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Standar mutu berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Standar mutu tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function standarMutuDocs() {}

    // ==========================================
    // JENIS BUKTI
    // ==========================================
    #[OA\Get(
        path: '/master/jenis-bukti',
        summary: 'Mendapatkan daftar jenis bukti dukung',
        tags: ['Master Data - Jenis Bukti'],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar jenis bukti', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/jenis-bukti',
        summary: 'Menambahkan jenis bukti baru',
        tags: ['Master Data - Jenis Bukti'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_jenis'],
                properties: [
                    new OA\Property(property: 'nama_jenis', type: 'string', example: 'Surat Keputusan (SK)'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Jenis bukti berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/jenis-bukti/{id}',
        summary: 'Mendapatkan detail jenis bukti',
        tags: ['Master Data - Jenis Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail jenis bukti berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Jenis bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/jenis-bukti/{id}',
        summary: 'Memperbarui jenis bukti',
        tags: ['Master Data - Jenis Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_jenis'],
                properties: [
                    new OA\Property(property: 'nama_jenis', type: 'string', example: 'Surat Keputusan Rektor'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Jenis bukti berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Jenis bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/jenis-bukti/{id}',
        summary: 'Menghapus jenis bukti',
        tags: ['Master Data - Jenis Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Jenis bukti berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Jenis bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function jenisBuktiDocs() {}

    // ==========================================
    // JENIS PEMBIAYAAN
    // ==========================================
    #[OA\Get(
        path: '/master/jenis-pembiayaan',
        summary: 'Mendapatkan daftar jenis pembiayaan',
        tags: ['Master Data - Jenis Pembiayaan'],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar jenis pembiayaan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/master/jenis-pembiayaan',
        summary: 'Menambahkan jenis pembiayaan baru',
        tags: ['Master Data - Jenis Pembiayaan'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_pembiayaan', 'kategori'],
                properties: [
                    new OA\Property(property: 'nama_pembiayaan', type: 'string', example: 'Biaya Operasional Pendidikan'),
                    new OA\Property(property: 'kategori', type: 'string', example: 'operasional'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Jenis pembiayaan berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/master/jenis-pembiayaan/{id}',
        summary: 'Mendapatkan detail jenis pembiayaan',
        tags: ['Master Data - Jenis Pembiayaan'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail jenis pembiayaan berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Jenis pembiayaan tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/master/jenis-pembiayaan/{id}',
        summary: 'Memperbarui jenis pembiayaan',
        tags: ['Master Data - Jenis Pembiayaan'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_pembiayaan', 'kategori'],
                properties: [
                    new OA\Property(property: 'nama_pembiayaan', type: 'string', example: 'Biaya Operasional Mahasiswa'),
                    new OA\Property(property: 'kategori', type: 'string', example: 'operasional'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Jenis pembiayaan berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Jenis pembiayaan tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/master/jenis-pembiayaan/{id}',
        summary: 'Menghapus jenis pembiayaan',
        tags: ['Master Data - Jenis Pembiayaan'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Jenis pembiayaan berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Jenis pembiayaan tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function jenisPembiayaanDocs() {}
}
