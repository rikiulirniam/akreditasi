<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class AuthDocs
{
    // ==========================================
    // 1. LOGIN SSO AKADEMIK
    // ==========================================
    #[OA\Post(
        path: '/api/auth/login',
        summary: 'Login SSO Akademik (Layanan Autentikasi Terpusat)',
        description: "Melakukan login akun pengguna ke server SSO Akademik (`https://akademik.fayra.my.id`).\n\n**Kredensial Demo:**\n* Administrator: `administrator@polines.ac.id` / `password`\n* Output token Bearer JWT digunakan untuk mengakses seluruh endpoint API Akreditasi & SPMI.",
        tags: ['Autentikasi - SSO Akademik'],
        servers: [
            new OA\Server(url: 'https://akademik.fayra.my.id', description: 'Server SSO Akademik'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'administrator@polines.ac.id', description: 'Email pengguna terdaftar'),
                    new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password', description: 'Kata sandi pengguna'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login berhasil, token JWT access_token diterbitkan.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'code', type: 'integer', example: 200),
                        new OA\Property(property: 'message', type: 'string', example: 'Login berhasil'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'user',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'integer', example: 1),
                                        new OA\Property(property: 'nama', type: 'string', example: 'Administrator Sistem'),
                                        new OA\Property(property: 'email', type: 'string', example: 'administrator@polines.ac.id'),
                                        new OA\Property(property: 'role', type: 'string', example: 'ADMINISTRATOR'),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'authorization',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'access_token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'),
                                        new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                                        new OA\Property(property: 'expires_in', type: 'integer', example: 3600),
                                        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'string')),
                                    ]
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Kredensial tidak valid (email atau password salah).'
            ),
        ]
    )]
    public function login(): void {}

    // ==========================================
    // 2. LOGOUT SSO AKADEMIK
    // ==========================================
    #[OA\Post(
        path: '/api/auth/logout',
        summary: 'Logout SSO Akademik',
        description: 'Mencabut dan mengakhiri sesi token JWT yang sedang aktif pada server SSO Akademik.',
        security: [['BearerAuth' => []]],
        tags: ['Autentikasi - SSO Akademik'],
        servers: [
            new OA\Server(url: 'https://akademik.fayra.my.id', description: 'Server SSO Akademik'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout berhasil.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'code', type: 'integer', example: 200),
                        new OA\Property(property: 'message', type: 'string', example: 'Logout berhasil'),
                        new OA\Property(property: 'data', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Token tidak valid atau belum login.'),
        ]
    )]
    public function logout(): void {}

    // ==========================================
    // 3. ME (PROFIL SSO AKADEMIK)
    // ==========================================
    #[OA\Get(
        path: '/api/auth/me',
        summary: 'Ambil Profil Pengguna (SSO Akademik)',
        description: 'Mendapatkan data identitas profil pengguna terautentikasi langsung dari server SSO Akademik.',
        security: [['BearerAuth' => []]],
        tags: ['Autentikasi - SSO Akademik'],
        servers: [
            new OA\Server(url: 'https://akademik.fayra.my.id', description: 'Server SSO Akademik'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Data profil berhasil diambil.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'code', type: 'integer', example: 200),
                        new OA\Property(property: 'message', type: 'string', example: 'Data profil berhasil diambil'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'id', type: 'integer', example: 1),
                                new OA\Property(property: 'nama', type: 'string', example: 'Administrator Sistem'),
                                new OA\Property(property: 'email', type: 'string', example: 'administrator@polines.ac.id'),
                                new OA\Property(property: 'role', type: 'string', example: 'ADMINISTRATOR'),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Token tidak valid atau kedaluwarsa.'),
        ]
    )]
    public function meSso(): void {}

    // ==========================================
    // 4. ME (VERIFIKASI TOKEN DI API AKREDITASI)
    // ==========================================
    #[OA\Get(
        path: '/auth/me',
        summary: 'Verifikasi Profil & Role Pengguna (API Akreditasi)',
        description: 'Memverifikasi klaim token JWT pengguna lokal di subsistem Akreditasi & SPMI (memeriksa user id, nama, email, role, dan permissions).',
        security: [['BearerAuth' => []]],
        tags: ['Autentikasi - SSO Akademik'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Profil pengguna terautentikasi berhasil diverifikasi oleh subsistem Akreditasi.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Profil pengguna terautentikasi berhasil diambil.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'user',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(property: 'id', type: 'integer', example: 1),
                                        new OA\Property(property: 'nama', type: 'string', example: 'Administrator Sistem'),
                                        new OA\Property(property: 'email', type: 'string', example: 'administrator@polines.ac.id'),
                                        new OA\Property(property: 'role', type: 'string', example: 'ADMINISTRATOR'),
                                        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'string')),
                                    ]
                                ),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', example: null),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Token tidak valid atau kedaluwarsa.'),
        ]
    )]
    public function meLocal(): void {}
}
