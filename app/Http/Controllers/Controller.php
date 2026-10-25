<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'REST API Sistem Penjaminan Mutu Internal (SPMI) dan Akreditasi',
    description: 'Dokumentasi interaktif OpenAPI / Swagger untuk backend REST API SPMI dan Akreditasi.'
)]
#[OA\Server(
    url: 'https://akreditasi.fayra.my.id/api/v1',
    description: 'Production Server API v1'
)]
#[OA\Server(
    url: '/api/v1',
    description: 'Current Domain Server'
)]
abstract class Controller
{
    //
}
