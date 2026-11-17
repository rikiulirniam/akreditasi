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
        description: 'Mengambil data seluruh dosen aktif dari sistem Tridharma (Kelompok 2) untuk kebutuhan penugasan tim (PJ & PIC).',
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
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function externalDocs(): void {}
}
