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
class Schemas
{
}
