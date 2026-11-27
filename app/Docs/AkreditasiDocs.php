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
    #[OA\Put(
        path: '/projects/{id}/status',
        summary: 'Memperbarui status lifecycle project akreditasi (Kaprodi & Administrator)',
        description: 'Memperbarui status project menjadi Draft, Pengisian, Review, On Progress, Pending, Cancel, atau Selesai oleh role KAPRODI atau ADMINISTRATOR. Nomor SK dan tanggal verifikasi/kedaluwarsa bersifat opsional (nullable) termasuk saat status diubah menjadi Selesai.',
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
                    new OA\Property(property: 'status_project', type: 'string', enum: ['Draft', 'Pengisian', 'Review', 'On Progress', 'Pending', 'Cancel', 'Selesai'], example: 'Selesai'),
                    new OA\Property(property: 'nomor_sk', type: 'string', example: null, nullable: true, description: 'Opsional (tidak wajib meskipun status Selesai)'),
                    new OA\Property(property: 'tanggal_kedaluwarsa', type: 'string', format: 'date', example: null, nullable: true),
                    new OA\Property(property: 'nomor_sk_akreditasi', type: 'string', example: null, nullable: true),
                    new OA\Property(property: 'tanggal_verifikasi_akreditasi', type: 'string', format: 'date', example: null, nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status project berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 403, description: 'Akses ditolak (khusus role KAPRODI atau ADMINISTRATOR)'),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
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
        summary: 'Simulasi skor kuantitatif LAM-INFOKOM (SDM Dosen, Riset, Publikasi, PkM, & Suplemen)',
        description: 'Menghitung simulasi skor kuantitatif otomatis LAM-INFOKOM 2.1 untuk seluruh butir yang datanya tersedia dari API Kelompok 1 & Kelompok 2 (DTPR/RMD/PDS3/PJLK, Penelitian, Publikasi & HKI, PkM, Kemitraan DUDIKA, dan Suplemen 1-5) beserta proyeksi predikat kelulusan.',
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
                                new OA\Property(property: 'rincian_butir_kuantitatif', type: 'array', items: new OA\Items(type: 'object')),
                                new OA\Property(
                                    property: 'ringkasan_kuantitatif',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'jumlah_butir_terhitung', type: 'integer', example: 9),
                                        new OA\Property(property: 'total_bobot_kuantitatif', type: 'number', format: 'float', example: 97),
                                        new OA\Property(property: 'total_skor_kuantitatif', type: 'number', format: 'float', example: 368.5),
                                        new OA\Property(property: 'skor_maksimal_kuantitatif', type: 'number', format: 'float', example: 388),
                                        new OA\Property(property: 'persentase_capaian', type: 'number', format: 'float', example: 94.97),
                                        new OA\Property(property: 'proyeksi_skor_skala_400', type: 'number', format: 'float', example: 379.89),
                                        new OA\Property(property: 'predikat_proyeksi', type: 'string', example: 'Terakreditasi Unggul'),
                                    ]
                                ),
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
        path: '/projects/{id}/data-summary',
        summary: 'Mengambil ringkasan data sumber akreditasi',
        description: 'Menggabungkan data project, program studi, mahasiswa, dosen, dan Tridharma dari layanan terkait.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Ringkasan data akreditasi berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Ringkasan data akreditasi berhasil diambil'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'project', type: 'object', properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 1),
                                    new OA\Property(property: 'id_prodi', type: 'integer', example: 101),
                                    new OA\Property(property: 'tahun', type: 'integer', example: 2026),
                                ]),
                                new OA\Property(property: 'prodi', type: 'object', description: 'Data program studi dari API Akademik'),
                                new OA\Property(property: 'mahasiswa', type: 'object', properties: [
                                    new OA\Property(property: 'total_aktif', type: 'integer', example: 345),
                                    new OA\Property(property: 'source', type: 'string', example: 'akademik:/api/mahasiswa'),
                                ]),
                                new OA\Property(property: 'dosen', type: 'object', description: 'Profil DTPS dari API Dosen'),
                                new OA\Property(property: 'tridharma', type: 'object', description: 'Ringkasan penelitian, PkM, publikasi, HKI, dan kerja sama'),
                                new OA\Property(property: 'meta', type: 'object', properties: [
                                    new OA\Property(property: 'is_simulation', type: 'boolean', example: false),
                                    new OA\Property(property: 'pending', type: 'array', items: new OA\Items(type: 'string')),
                                ]),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Get(
        path: '/narasi-templates',
        summary: 'Mendapatkan daftar template narasi',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'kategori_data', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter kategori sumber data'),
            new OA\Parameter(name: 'is_active', in: 'query', required: false, schema: new OA\Schema(type: 'boolean'), description: 'Filter status aktif'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar template narasi berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Daftar template narasi berhasil diambil'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'id_subkriteria', type: 'integer', nullable: true, example: 12),
                                new OA\Property(property: 'kategori_data', type: 'string', example: 'dosen'),
                                new OA\Property(property: 'nama_template', type: 'string', example: 'Template data dosen'),
                                new OA\Property(property: 'template_tersedia', type: 'string'),
                                new OA\Property(property: 'template_tidak_tersedia', type: 'string', nullable: true),
                                new OA\Property(property: 'sumber_data', type: 'array', items: new OA\Items(type: 'string')),
                                new OA\Property(property: 'field_mapping', type: 'array', items: new OA\Items(type: 'string')),
                                new OA\Property(property: 'prioritas', type: 'integer', example: 1),
                                new OA\Property(property: 'is_active', type: 'boolean', example: true),
                            ]
                        )),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    #[OA\Post(
        path: '/narasi-templates',
        summary: 'Membuat template narasi',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kategori_data', 'nama_template', 'template_tersedia'],
                properties: [
                    new OA\Property(property: 'id_subkriteria', type: 'integer', nullable: true, example: 12),
                    new OA\Property(property: 'kategori_data', type: 'string', maxLength: 80, example: 'dosen'),
                    new OA\Property(property: 'nama_template', type: 'string', maxLength: 255, example: 'Template data dosen'),
                    new OA\Property(property: 'template_tersedia', type: 'string', maxLength: 20000, example: 'Terdapat {jumlah_dosen_homebase} dosen pada program studi.'),
                    new OA\Property(property: 'template_tidak_tersedia', type: 'string', nullable: true, maxLength: 20000),
                    new OA\Property(property: 'sumber_data', type: 'array', items: new OA\Items(type: 'string', maxLength: 255)),
                    new OA\Property(property: 'field_mapping', type: 'array', items: new OA\Items(type: 'string', maxLength: 120)),
                    new OA\Property(property: 'prioritas', type: 'integer', minimum: 1, maximum: 65535, example: 1),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Template narasi berhasil dibuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/narasi-templates/{id}',
        summary: 'Mendapatkan detail template narasi',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail template narasi berhasil diambil', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Template narasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/narasi-templates/{id}',
        summary: 'Memperbarui template narasi',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kategori_data', 'nama_template', 'template_tersedia'],
                properties: [
                    new OA\Property(property: 'id_subkriteria', type: 'integer', nullable: true, example: 12),
                    new OA\Property(property: 'kategori_data', type: 'string', maxLength: 80, example: 'dosen'),
                    new OA\Property(property: 'nama_template', type: 'string', maxLength: 255, example: 'Template data dosen'),
                    new OA\Property(property: 'template_tersedia', type: 'string', maxLength: 20000),
                    new OA\Property(property: 'template_tidak_tersedia', type: 'string', nullable: true, maxLength: 20000),
                    new OA\Property(property: 'sumber_data', type: 'array', items: new OA\Items(type: 'string', maxLength: 255)),
                    new OA\Property(property: 'field_mapping', type: 'array', items: new OA\Items(type: 'string', maxLength: 120)),
                    new OA\Property(property: 'prioritas', type: 'integer', minimum: 1, maximum: 65535),
                    new OA\Property(property: 'is_active', type: 'boolean'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Template narasi berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Template narasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Delete(
        path: '/narasi-templates/{id}',
        summary: 'Menghapus template narasi',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Template narasi berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 404, description: 'Template narasi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
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
        path: '/projects/{id}/placeholder-modules',
        summary: 'Mendapatkan metadata modul kriteria placeholder (Tata Pamong, Keuangan & Sarpras)',
        description: 'Mengembalikan daftar kriteria read-only non-handle (C.2 & C.5 dengan total bobot 40, subkriteria 5.1 & 5.2 berstatus Statis / Read-Only, is_editable: false) yang tidak dapat di-plotting pada penugasan tim agar struktur 9 kriteria LAM-INFOKOM tetap lengkap di frontend. Dapat diakses oleh ADMINISTRATOR, KAPRODI, dan DOSEN.',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Metadata modul placeholder berhasil dimuat', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'message', type: 'string', example: 'Data modul placeholder berhasil diambil.'),
                    new OA\Property(property: 'data', type: 'array', items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'kode_kriteria', type: 'string', example: 'C.5'),
                            new OA\Property(property: 'nama_kriteria', type: 'string', example: 'Keuangan, Sarana, dan Prasarana'),
                            new OA\Property(property: 'total_bobot', type: 'integer', example: 40, nullable: true),
                            new OA\Property(property: 'is_placeholder', type: 'boolean', example: true),
                            new OA\Property(property: 'mode', type: 'string', example: 'read_only'),
                            new OA\Property(property: 'status', type: 'string', example: 'Aktif (Placeholder LAM-INFOKOM)'),
                            new OA\Property(property: 'catatan_sistem', type: 'string', example: 'Komponen Read-Only LAM-INFOKOM (Data dikelola oleh SPMI Pusat Polines)', nullable: true),
                            new OA\Property(property: 'keterangan', type: 'string', example: 'Modul Keuangan, Sarana, dan Prasarana disajikan sebagai komponen display data statis/read-only tanpa transaksi form input borang.'),
                            new OA\Property(property: 'subkriteria', type: 'array', nullable: true, items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'kode_subkriteria', type: 'string', example: '5.1'),
                                    new OA\Property(property: 'nama_subkriteria', type: 'string', example: 'Standar Tata Kelola Otonom & Transparan'),
                                    new OA\Property(property: 'is_editable', type: 'boolean', example: false),
                                    new OA\Property(property: 'status', type: 'string', example: 'Statis / Read-Only'),
                                ]
                            )),
                        ]
                    )),
                    new OA\Property(property: 'meta', type: 'object'),
                ]
            )),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
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
        summary: 'Menyimpan batch/single penugasan dosen (Plotting PJ & PIC) untuk project',
        description: 'Menugaskan user/dosen dengan role PJ atau PIC pada indikator aktif (menolak indikator dari Kriteria Statis/Non-Handle K5 dan role selain PJ/PIC dengan HTTP 422). Hanya dapat diakses oleh role ADMINISTRATOR dan KAPRODI (403 Forbidden untuk role lain).',
        tags: ['Akreditasi - Mapping Tim'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_user', type: 'integer', example: 101, description: 'Diisi jika single penugasan'),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1, description: 'Diisi jika single penugasan (harus indikator aktif non-K5)'),
                    new OA\Property(property: 'role', type: 'string', enum: ['PJ', 'PIC'], example: 'PJ', nullable: true),
                    new OA\Property(
                        property: 'assignments',
                        type: 'array',
                        description: 'Diisi jika batch penugasan sekaligus (min: 1)',
                        items: new OA\Items(
                            required: ['id_user', 'id_indikator', 'role'],
                            properties: [
                                new OA\Property(property: 'id_user', type: 'integer', example: 10),
                                new OA\Property(property: 'id_indikator', type: 'integer', example: 4),
                                new OA\Property(property: 'role', type: 'string', enum: ['PJ', 'PIC'], example: 'PIC'),
                            ]
                        )
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Pembagian tugas tim akreditasi berhasil disimpan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 403, description: 'Akses ditolak (hanya ADMINISTRATOR dan KAPRODI)'),
            new OA\Response(response: 422, description: 'Validasi gagal (role selain PJ/PIC atau indikator termasuk Kriteria 5 statis)', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
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
        description: 'Menampilkan daftar butir indikator aktif yang ditugaskan kepada pengguna yang sedang login (PIC/PJ), secara otomatis mengecualikan indikator dari Kriteria Statis / Non-Handle (K5), serta menyertakan kelengkapan bukti (has_bukti, status_narasi, status_evidence). Dapat diakses oleh role DOSEN, KAPRODI, dan ADMINISTRATOR (403 Forbidden untuk role REVIEWER yang telah dinonaktifkan).',
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
                        new OA\Property(property: 'message', type: 'string', example: 'Daftar penugasan dosen berhasil diambil.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'id_mapping', type: 'integer', example: 16),
                                new OA\Property(property: 'role', type: 'string', example: 'PIC'),
                                new OA\Property(property: 'id_project', type: 'integer', example: 1),
                                new OA\Property(property: 'nama_project', type: 'string', example: 'Akreditasi TRK 2026'),
                                new OA\Property(property: 'status_project', type: 'string', example: 'Draft'),
                                new OA\Property(property: 'id_indikator', type: 'integer', example: 4),
                                new OA\Property(property: 'kode_indikator', type: 'string', example: '2.1.B'),
                                new OA\Property(property: 'deskripsi', type: 'string', example: 'Standar isi pembelajaran & kurikulum OBE'),
                                new OA\Property(property: 'bobot', type: 'number', example: 4),
                                new OA\Property(property: 'kriteria', type: 'string', example: 'Kriteria 2: Relevansi Pendidikan', nullable: true),
                                new OA\Property(property: 'has_bukti', type: 'boolean', example: false),
                                new OA\Property(property: 'status_narasi', type: 'string', example: 'Belum Terisi'),
                                new OA\Property(property: 'status_evidence', type: 'string', example: 'Belum Terunggah'),
                            ]
                        )),
                        new OA\Property(property: 'meta', type: 'object'),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 403, description: 'Akses ditolak (role REVIEWER dinonaktifkan)'),
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
    #[OA\Get(
        path: '/projects/{id}/composite-overview',
        summary: 'Overview komposit project (Profil, Progres 9 Kriteria, Evidence, & Skor)',
        description: 'Endpoint agregasi yang menggabungkan profil project, progress kelengkapan 9 kriteria, ringkasan evidence, dan skor penilaian dalam 1 request untuk efisiensi loading frontend.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Overview komposit project berhasil dimuat',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Data berhasil diambil'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'profil_project', type: 'object'),
                                new OA\Property(property: 'progress', type: 'object'),
                                new OA\Property(property: 'scoring', type: 'object'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Project akreditasi tidak ditemukan'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/subkriteria/{subkriteriaId}/narasi-template',
        summary: 'Mendapatkan template narasi subkriteria dengan angka agregasi aktual (B3)',
        description: 'Menghasilkan template narasi terinjeksi nilai pakem untuk subkriteria tertentu (misal Kriteria C.4 SDM Dosen) berdasarkan data agregasi API Tridharma Kelompok 2. Mendukung graceful fallback 200 OK dengan penanda data kosong/parsial (seperti Tracer Study pada Subkriteria 2.4).',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
            new OA\Parameter(name: 'subkriteriaId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Subkriteria'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Template narasi subkriteria berhasil dibuat',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Template narasi subkriteria berhasil di-generate'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id_project', type: 'integer', example: 1),
                                new OA\Property(property: 'id_subkriteria', type: 'integer', example: 2),
                                new OA\Property(property: 'kode_subkriteria', type: 'string', example: '2.2'),
                                new OA\Property(property: 'nama_subkriteria', type: 'string', example: 'Dosen dan Tenaga Kependidikan'),
                                new OA\Property(property: 'status_ketersediaan_data', type: 'string', example: 'Tersedia Lengkap'),
                                new OA\Property(
                                    property: 'variabel_pakem',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'NDTPS', type: 'integer', example: 23),
                                        new OA\Property(property: 'NDTPS_S3', type: 'integer', example: 5),
                                        new OA\Property(property: 'Persentase_S3', type: 'string', example: '21.74%'),
                                        new OA\Property(property: 'Rasio_Mhs_Dosen', type: 'string', example: '1:18.5'),
                                    ]
                                ),
                                new OA\Property(property: 'draf_narasi', type: 'string', example: 'Program Studi Sarjana Terapan Teknologi Rekayasa Komputer (TRK)...'),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Project atau Subkriteria tidak ditemukan'),
        ]
    )]
    #[OA\Put(
        path: '/projects/{id}/subkriteria/{subkriteriaId}/narasi',
        summary: 'Menyimpan teks narasi subkriteria hasil editan (B4)',
        description: 'Menyimpan teks narasi yang telah disesuaikan/diedit oleh Kaprodi atau PIC butir subkriteria terkait dengan validasi minimal 20 karakter serta catatan revisi.',
        tags: ['Akreditasi - Project'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
            new OA\Parameter(name: 'subkriteriaId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Subkriteria'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['narasi_disunting'],
                properties: [
                    new OA\Property(property: 'narasi_disunting', type: 'string', minLength: 20, example: 'Program Studi Teknologi Rekayasa Komputer memiliki 23 orang dosen tetap yang berkualifikasi...'),
                    new OA\Property(property: 'catatan_revisi', type: 'string', example: 'Penyesuaian narasi profil dosen', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Narasi subkriteria berhasil disimpan',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Narasi subkriteria berhasil disimpan'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'id_project', type: 'integer', example: 1),
                                new OA\Property(property: 'id_subkriteria', type: 'integer', example: 2),
                                new OA\Property(property: 'narasi_final', type: 'string', example: 'Program Studi Teknologi Rekayasa Komputer memiliki 23 orang dosen tetap yang berkualifikasi...'),
                                new OA\Property(property: 'status_ketersediaan_data', type: 'string', example: 'Tersedia Lengkap'),
                                new OA\Property(property: 'disunting_oleh', type: 'string', example: 'Kaprodi'),
                                new OA\Property(property: 'catatan_revisi', type: 'string', example: 'Penyesuaian narasi profil dosen'),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 403, description: 'Tidak memiliki hak akses menyimpan narasi pada butir ini'),
            new OA\Response(response: 404, description: 'Project atau Subkriteria tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}/review-summary',
        summary: 'Mendapatkan rekapitulasi penilaian review project akreditasi',
        description: 'Menampilkan ringkasan total nilai terbobot, skor akhir, dan rincian butir yang sudah dinilai oleh Kaprodi/Administrator. Dapat diakses oleh ADMINISTRATOR, KAPRODI, dan DOSEN (role REVIEWER telah dinonaktifkan).',
        tags: ['Akreditasi - Self Assessment'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Rekapitulasi review penilaian project berhasil diambil'),
            new OA\Response(response: 403, description: 'Akses ditolak (role REVIEWER dinonaktifkan)'),
            new OA\Response(response: 404, description: 'Project tidak ditemukan'),
        ]
    )]
    #[OA\Put(
        path: '/self-assessment/{id}/penjelasan-prodi',
        summary: 'Menambahkan tanggapan / klarifikasi resmi prodi (Kaprodi & Administrator)',
        description: 'Kaprodi atau Administrator memberikan tanggapan/klarifikasi resmi atas catatan evaluasi pada butir self assessment (minimal 5 karakter). Role DOSEN dan REVIEWER ditolak dengan HTTP 403 Forbidden.',
        tags: ['Akreditasi - Self Assessment'],
        security: [['BearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Self Assessment'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['tanggapan_kaprodi'],
                properties: [
                    new OA\Property(property: 'tanggapan_kaprodi', type: 'string', minLength: 5, example: 'SK Kurikulum OBE 2024 dan Berita Acara DUDIKA telah disematkan pada tautan bukti pilar 2.'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Penjelasan / tanggapan prodi berhasil disimpan'),
            new OA\Response(response: 403, description: 'Akses ditolak: Hanya Kaprodi atau Administrator yang berhak mengisi tanggapan prodi'),
            new OA\Response(response: 404, description: 'Data penilaian mandiri tidak ditemukan'),
            new OA\Response(response: 422, description: 'Validasi gagal (tanggapan_kaprodi wajib minimal 5 karakter)'),
        ]
    )]
    #[OA\Post(
        path: '/self-assessment',
        summary: 'Mengisi atau memperbarui penilaian mandiri (Kaprodi & Administrator)',
        description: 'Menyimpan penilaian evaluasi untuk indikator pada project oleh KAPRODI atau ADMINISTRATOR (role REVIEWER dinonaktifkan). Jika id_rubrik disertakan, sistem otomatis menghitung skor_terbobot = rubrik.skor * bobot.',
        tags: ['Akreditasi - Self Assessment'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project', 'id_indikator'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'id_rubrik', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'reviewer_id', type: 'integer', example: 2, nullable: true, description: 'ID User Penilai (Kaprodi / Administrator)'),
                    new OA\Property(property: 'catatan_reviewer', type: 'string', example: 'Bukti dukung sangat komprehensif dan implementasi terlaksana dengan sangat baik.', nullable: true),
                    new OA\Property(property: 'tanggal_penilaian', type: 'string', format: 'date', example: '2026-10-24', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Penilaian mandiri berhasil disimpan dengan perhitungan skor terbobot otomatis', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 403, description: 'Akses ditolak (hanya KAPRODI atau ADMINISTRATOR)'),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    public function selfAssessmentDocs() {}
}
