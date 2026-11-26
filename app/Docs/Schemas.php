<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ApiResponseSuccess',
    title: 'Standar Respons Sukses',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Data berhasil diproses.'),
        new OA\Property(property: 'data', type: 'object'),
        new OA\Property(property: 'errors', type: 'null', example: null),
    ]
)]
#[OA\Schema(
    schema: 'ApiResponseListSuccess',
    title: 'Standar Respons Daftar Data',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Data berhasil dimuat.'),
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(type: 'object')),
        new OA\Property(property: 'errors', type: 'null', example: null),
    ]
)]
#[OA\Schema(
    schema: 'ApiResponseValidationError',
    title: 'Standar Respons Error Validasi (422)',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Validasi data gagal.'),
        new OA\Property(property: 'data', type: 'null', example: null),
        new OA\Property(
            property: 'errors',
            type: 'object',
            additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(type: 'string'))
        ),
    ]
)]
#[OA\Schema(
    schema: 'ApiResponseNotFound',
    title: 'Standar Respons Tidak Ditemukan (404)',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Data tidak ditemukan.'),
        new OA\Property(property: 'data', type: 'null', example: null),
        new OA\Property(property: 'errors', type: 'null', example: null),
    ]
)]
#[OA\Schema(
    schema: 'VersiInstrumen',
    title: 'Skema Versi Instrumen Akreditasi',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'id_lembaga', type: 'integer', example: 1),
        new OA\Property(property: 'nomor_versi', type: 'string', example: '2.1'),
        new OA\Property(property: 'nama_lembaga', type: 'string', example: 'LAM-INFOKOM', nullable: true),
        new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
        new OA\Property(property: 'keterangan', type: 'string', example: 'Instrumen Akreditasi Program Studi Sarjana Terapan TRK (Aktif)', nullable: true),
        new OA\Property(property: 'tanggal_berlaku', type: 'string', format: 'date', example: '2026-01-25'),
    ]
)]
#[OA\Schema(
    schema: 'EvidenceSpmiOverview',
    title: 'Skema Rekapitulasi Evidence Overview 4 Pilar',
    properties: [
        new OA\Property(property: 'project', type: 'object', properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'nama_project', type: 'string', example: 'Akreditasi TRK 2026'),
            new OA\Property(property: 'status_project', type: 'string', example: 'Pengisian'),
        ]),
        new OA\Property(property: 'kelengkapan_pilar', type: 'object', properties: [
            new OA\Property(property: 'total_pilar', type: 'integer', example: 4),
            new OA\Property(property: 'terisi', type: 'integer', example: 3),
            new OA\Property(property: 'belum_terisi', type: 'integer', example: 1),
            new OA\Property(property: 'persentase', type: 'string', example: '75.0%'),
        ]),
        new OA\Property(property: 'evidence_pilar', type: 'object'),
        new OA\Property(property: 'evidence', type: 'object', nullable: true),
        new OA\Property(property: 'assigned_indicators', type: 'array', items: new OA\Items(type: 'object')),
    ]
)]
class Schemas {}
