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
        description: 'Menampilkan list project akreditasi dengan filter opsional.',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id_prodi', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Program Studi'),
            new OA\Parameter(name: 'id_jenjang', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Jenjang'),
            new OA\Parameter(name: 'status_project', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter berdasarkan status project (draft, pengisian, review, submit)'),
        ],
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
        path: '/projects/quick-create',
        summary: 'Pembuatan Cepat Project TRK (1-Klik)',
        description: 'Membuat project akreditasi baru secara instan untuk TRK (Teknologi Rekayasa Komputer) menggunakan versi 2.1 aktif, jenjang Sarjana Terapan, dan instrumen APS Unggul.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_prodi'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 101, description: 'ID Program Studi TRK'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Project TRK berhasil dibuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Master data aktif belum lengkap', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Patch(
        path: '/projects/{id}/status',
        summary: 'Memperbarui status lifecycle project akreditasi (Khusus Kaprodi)',
        description: 'Memperbarui status project menjadi Draft, On Progress, Pending, Cancel, atau Selesai (eksklusif hanya dapat dilakukan oleh role Kaprodi). Nomor SK akreditasi dan tanggal verifikasi bersifat opsional untuk seluruh status termasuk status Selesai.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status_project'],
                properties: [
                    new OA\Property(property: 'status_project', type: 'string', enum: ['Draft', 'On Progress', 'Pending', 'Cancel', 'Selesai'], example: 'Selesai'),
                    new OA\Property(property: 'tanggal_verifikasi_akreditasi', type: 'string', format: 'date', example: '2026-12-14', nullable: true),
                    new OA\Property(property: 'nomor_sk_akreditasi', type: 'string', example: 'SK-BANPT-2026-001', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status project berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 403, description: 'Akses ditolak (hanya role Kaprodi yang berwenang)'),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/scoring-simulation',
        summary: 'Simulasi skor kuantitatif LAM-INFOKOM (SDM Dosen)',
        description: 'Menghitung simulasi skor 3 butir kuantitatif SDM Dosen (RMD, PDS3, PJLK) berdasarkan integrasi data live Kelompok 2 pada skala 0 - 4.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
            new OA\Parameter(name: 'jumlah_mahasiswa', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Jumlah mahasiswa aktif (opsional / override nilai default)'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Simulasi skor LAM-INFOKOM berhasil dihitung',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Simulasi skor LAM-INFOKOM berhasil dihitung'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'skor_per_subkriteria',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(
                                            property: 'rmd',
                                            type: 'object',
                                            properties: [
                                                new OA\Property(property: 'nilai', type: 'number', format: 'float', example: 18.5),
                                                new OA\Property(property: 'skor', type: 'number', format: 'float', example: 4.0),
                                            ]
                                        ),
                                        new OA\Property(
                                            property: 'pds3',
                                            type: 'object',
                                            properties: [
                                                new OA\Property(property: 'persentase', type: 'number', format: 'float', example: 50.0),
                                                new OA\Property(property: 'skor', type: 'number', format: 'float', example: 4.0),
                                            ]
                                        ),
                                        new OA\Property(
                                            property: 'pjlk',
                                            type: 'object',
                                            properties: [
                                                new OA\Property(property: 'persentase', type: 'number', format: 'float', example: 40.0),
                                                new OA\Property(property: 'skor', type: 'number', format: 'float', example: 3.14),
                                            ]
                                        ),
                                    ]
                                ),
                                new OA\Property(property: 'total_na', type: 'number', format: 'float', example: 3.71),
                                new OA\Property(property: 'is_simulated', type: 'boolean', example: true),
                                new OA\Property(property: 'minimum_not_met', type: 'boolean', example: false),
                                new OA\Property(property: 'warning', type: 'string', nullable: true, example: 'Jumlah dosen tetap homebase kurang dari 5 (syarat minimum LAM-INFOKOM tidak terpenuhi).'),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Project tidak ditemukan'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/dashboard-progress',
        summary: 'Metrik progres keterisian bukti 9 Kriteria',
        description: 'Menghitung persentase progres keterisian bukti dukung untuk masing-masing dari 9 Kriteria dan total persentase project.',
        tags: ['Dashboard & Readiness'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Metrik progres dashboard berhasil dihitung',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Metrik progres dashboard berhasil dihitung'),
                        new OA\Property(property: 'data', type: 'object'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Project tidak ditemukan'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/readiness',
        summary: 'Pengecekan kesiapan submit akreditasi',
        description: 'Memvalidasi kelengkapan seluruh butir indikator (PIC, bukti link evidence, dan penilaian reviewer) sebelum submit.',
        tags: ['Dashboard & Readiness'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Pengecekan kesiapan submit berhasil dilakukan',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Pengecekan kesiapan submit berhasil dilakukan'),
                        new OA\Property(property: 'data', type: 'object'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Project tidak ditemukan'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/indicators/{indicatorId}/evidence',
        summary: 'Melihat link bukti dukung butir indikator',
        description: 'Mengambil link evidence Google Drive/dokumen untuk butir indikator tertentu.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project'),
            new OA\Parameter(name: 'indicatorId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Indikator'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Bukti indikator berhasil diambil'),
            new OA\Response(response: 404, description: 'Project atau indikator tidak ditemukan'),
        ]
    )]
    #[OA\Put(
        path: '/projects/{id}/indicators/{indicatorId}/evidence',
        summary: 'Mengunggah / memperbarui link bukti dukung butir indikator',
        description: 'Menyimpan link evidence Google Drive/dokumen untuk butir indikator project.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project'),
            new OA\Parameter(name: 'indicatorId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Indikator'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['link_evidence'],
                properties: [
                    new OA\Property(property: 'link_evidence', type: 'string', example: 'https://drive.google.com/drive/folders/evidence-kriteria-1'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Bukti indikator berhasil disimpan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
            new OA\Response(response: 404, description: 'Project atau indikator tidak ditemukan'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/mapping-tim',
        summary: 'Mendapatkan daftar penugasan tim akreditasi untuk project tertentu',
        description: 'Menampilkan list penugasan tim per indikator untuk ID project yang ditentukan pada path URL.',
        tags: ['Akreditasi - Mapping Tim'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
            new OA\Parameter(name: 'role', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter berdasarkan peran / role (contoh: PJ, PIC, Penyusun)'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Daftar penugasan tim berhasil dimuat', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )),
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
        description: 'Menampilkan list seluruh mapping penugasan tim beserta relasi project dan indikator. Filter id_project dikirimkan melalui query parameter (bukan body request).',
        tags: ['Akreditasi - Mapping Tim'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project Akreditasi (Query Parameter)'),
            new OA\Parameter(name: 'project_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Alias filter berdasarkan ID Project Akreditasi (Query Parameter)'),
            new OA\Parameter(name: 'role', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter berdasarkan peran / role (contoh: PJ, PIC, Penyusun)'),
        ],
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
    #[OA\Get(
        path: '/dosen/my-assignments',
        summary: 'Daftar butir indikator tugas dosen login (PIC & PJ)',
        description: 'Menampilkan daftar butir indikator yang ditugaskan kepada dosen yang sedang login (sebagai PIC atau PJ), dilengkapi status keterisian bukti dan hak akses edit.',
        tags: ['Dosen - Penugasan PIC'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar penugasan berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Daftar penugasan berhasil diambil'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
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
