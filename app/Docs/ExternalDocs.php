<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class ExternalDocs
{
    #[OA\Get(
        path: '/external/prodi',
        summary: 'Mendapatkan daftar program studi dari Kelompok 1',
        description: 'Mengambil data seluruh program studi aktif dari sistem Akademik (Kelompok 1) via API service.',
        tags: ['Integrasi Eksternal'],
        security: [['BearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar program studi berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Daftar program studi berhasil diambil.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    #[OA\Get(
        path: '/external/prodi/default',
        summary: 'Mendapatkan program studi default (TRK) dari Kelompok 1',
        description: 'Mengambil data program studi default TRK (Teknologi Rekayasa Komputer) dari Kelompok 1.',
        tags: ['Integrasi Eksternal'],
        security: [['BearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Program studi default (TRK) berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Program studi default (TRK) berhasil diambil.'),
                        new OA\Property(property: 'data', type: 'object'),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    #[OA\Get(
        path: '/external/dosen',
        summary: 'Mendapatkan profil dosen & agregasi DTPS dari Kelompok 2 (B1)',
        description: 'Mengambil data live dosen dari API Tridharma (Kelompok 2) dan mengagregasikan 23 data Dosen Tetap Program Studi (DTPS) lengkap dengan persentase S3, pengelompokan jabatan fungsional, dan status sertifikasi dosen.',
        tags: ['Integrasi Eksternal'],
        security: [['BearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Data dosen DTPS berhasil diambil dari API Tridharma',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Data dosen DTPS berhasil diambil dari API Tridharma'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'total_dosen', type: 'integer', example: 23),
                                new OA\Property(property: 'total_s3_doktor', type: 'integer', example: 5),
                                new OA\Property(property: 'persentase_s3', type: 'string', example: '21.74%'),
                                new OA\Property(
                                    property: 'jabatan_fungsional',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'guru_besar', type: 'integer', example: 1),
                                        new OA\Property(property: 'lektor_kepala', type: 'integer', example: 6),
                                        new OA\Property(property: 'lektor', type: 'integer', example: 11),
                                        new OA\Property(property: 'asisten_ahli', type: 'integer', example: 5),
                                    ]
                                ),
                                new OA\Property(property: 'dosen_tersertifikasi', type: 'integer', example: 19),
                                new OA\Property(
                                    property: 'daftar_dosen',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'nidn', type: 'string', example: '0012058001'),
                                            new OA\Property(property: 'nama', type: 'string', example: 'Dr. Eng. Riki Ulir, M.T.'),
                                            new OA\Property(property: 'pendidikan_terakhir', type: 'string', example: 'S3'),
                                            new OA\Property(property: 'jabatan_akademik', type: 'string', example: 'Lektor Kepala'),
                                            new OA\Property(property: 'status_dosen', type: 'string', example: 'DTPS'),
                                        ]
                                    )
                                ),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    #[OA\Get(
        path: '/external/tridharma-summary',
        summary: 'Mendapatkan ringkasan agregat Tridharma dari Kelompok 2 (B2)',
        description: 'Mengambil dan merangkum agregat penelitian, PkM, publikasi, HKI, dan kerja sama DUDIKA dari server API Kelompok 2 untuk kebutuhan akreditasi.',
        tags: ['Integrasi Eksternal'],
        security: [['BearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Ringkasan Tridharma berhasil diambil dari API Kelompok 2',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Ringkasan Tridharma berhasil diambil dari API Kelompok 2'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'penelitian',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'total_kegiatan', type: 'integer', example: 42),
                                        new OA\Property(property: 'melibatkan_mahasiswa', type: 'integer', example: 35),
                                        new OA\Property(property: 'hibah_nasional_bima', type: 'integer', example: 8),
                                        new OA\Property(property: 'hibah_internal_polines', type: 'integer', example: 26),
                                        new OA\Property(property: 'mandiri', type: 'integer', example: 8),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'pkm',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'total_kegiatan', type: 'integer', example: 28),
                                        new OA\Property(property: 'melibatkan_mahasiswa', type: 'integer', example: 24),
                                        new OA\Property(property: 'hibah_pkm_nasional', type: 'integer', example: 4),
                                        new OA\Property(property: 'hibah_internal', type: 'integer', example: 24),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'publikasi',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'jurnal_internasional_scopus', type: 'integer', example: 18),
                                        new OA\Property(property: 'jurnal_nasional_sinta', type: 'integer', example: 64),
                                        new OA\Property(property: 'prosiding_seminar_ieee', type: 'integer', example: 32),
                                        new OA\Property(property: 'buku_isbn', type: 'integer', example: 12),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'hki',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'paten_terdaftar', type: 'integer', example: 3),
                                        new OA\Property(property: 'hak_cipta_program_komputer', type: 'integer', example: 22),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'kerjasama_dudika_aktif',
                                    type: 'integer',
                                    example: 15
                                ),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function externalDocs(): void {}
}
