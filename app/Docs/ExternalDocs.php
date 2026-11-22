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
        summary: 'Mendapatkan daftar dosen dari Kelompok 2',
        description: 'Mengambil data seluruh dosen aktif dari sistem Tridharma (Kelompok 2) dengan standardisasi 5 field: nip_nidn, nama_lengkap, gelar, jabatan_fungsional, dan status_homebase.',
        tags: ['Integrasi Eksternal'],
        security: [['BearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Daftar dosen berhasil diambil',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Daftar dosen berhasil diambil.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: 'nip_nidn', type: 'string', example: '197504122000031001'),
                                    new OA\Property(property: 'nidn', type: 'string', example: '0012048801'),
                                    new OA\Property(property: 'nama_lengkap', type: 'string', example: 'Prof. Dr. Andi Wijaya, S.Kom., M.T.'),
                                    new OA\Property(property: 'nama', type: 'string', example: 'Prof. Dr. Andi Wijaya, S.Kom., M.T.'),
                                    new OA\Property(property: 'gelar', type: 'string', example: 'Doktor (S3)'),
                                    new OA\Property(property: 'jabatan_fungsional', type: 'string', example: 'Guru Besar'),
                                    new OA\Property(property: 'status_homebase', type: 'boolean', example: true),
                                    new OA\Property(property: 'email', type: 'string', example: 'andi.wijaya@kampus.ac.id'),
                                    new OA\Property(property: 'bidang_minat', type: 'string', example: 'Rekayasa Perangkat Lunak & Sistem Informasi'),
                                ]
                            )
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
