<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class SarprasDocs
{
    // ==========================================
    // PRASARANA PRODI
    // ==========================================
    #[OA\Get(
        path: '/sarpras-prodi',
        summary: 'Mendapatkan daftar data prasarana prodi',
        description: 'Menampilkan list data prasarana dengan opsional filter id_project.',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar prasarana', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/sarpras-prodi',
        summary: 'Menambahkan data prasarana prodi baru',
        tags: ['Sarpras - Sarana & Prasarana'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'keterangan', type: 'string', example: 'Laboratorium Rekayasa Perangkat Lunak Gedung A', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Data prasarana berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/sarpras-prodi/{id}',
        summary: 'Mendapatkan detail data prasarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail prasarana berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Prasarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/sarpras-prodi/{id}',
        summary: 'Memperbarui data prasarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'keterangan', type: 'string', example: 'Laboratorium RPL Gedung A (Renovasi)', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Data prasarana berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Prasarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/sarpras-prodi/{id}',
        summary: 'Menghapus data prasarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data prasarana berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Prasarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function sarprasDocs() {}

    // ==========================================
    // SARANA PRODI
    // ==========================================
    #[OA\Get(
        path: '/sarana-prodi',
        summary: 'Mendapatkan daftar data sarana prodi',
        description: 'Menampilkan list data sarana dengan opsional filter id_prasarana.',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id_prasarana', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Prasarana'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar sarana', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/sarana-prodi',
        summary: 'Menambahkan data sarana prodi baru',
        tags: ['Sarpras - Sarana & Prasarana'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_prasarana', 'nama_sarana'],
                properties: [
                    new OA\Property(property: 'id_prasarana', type: 'integer', example: 1),
                    new OA\Property(property: 'nama_sarana', type: 'string', example: 'PC Workstation Core i7 32GB RAM'),
                    new OA\Property(property: 'jumlah', type: 'integer', example: 30, nullable: true),
                    new OA\Property(property: 'kondisi', type: 'string', example: 'Baik', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Data sarana berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/sarana-prodi/{id}',
        summary: 'Mendapatkan detail data sarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail sarana berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Sarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/sarana-prodi/{id}',
        summary: 'Memperbarui data sarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nama_sarana', type: 'string', example: 'PC Workstation Core i7 32GB RAM (Upgrade SSD)', nullable: true),
                    new OA\Property(property: 'jumlah', type: 'integer', example: 35, nullable: true),
                    new OA\Property(property: 'kondisi', type: 'string', example: 'Sangat Baik', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Data sarana berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Sarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/sarana-prodi/{id}',
        summary: 'Menghapus data sarana prodi',
        tags: ['Sarpras - Sarana & Prasarana'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data sarana berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Sarana tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function saranaDocs() {}
}
