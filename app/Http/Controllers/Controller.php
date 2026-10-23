<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'REST API Sistem Penjaminan Mutu Internal (SPMI) dan Akreditasi',
    description: 'Dokumentasi interaktif OpenAPI / Swagger untuk backend REST API SPMI dan Akreditasi.'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000/api/v1',
    description: 'Local Development Server API v1'
)]
abstract class Controller
{
    //
}
