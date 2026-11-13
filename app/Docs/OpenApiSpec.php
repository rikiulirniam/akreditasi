<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: 'BearerAuth',
    type: 'http',
    bearerFormat: 'JWT',
    scheme: 'bearer',
    description: 'Masukkan token JWT akses dari SSO Akademik (contoh: eyJ0eXAiOiJKV1QiLCJhbGci...)'
)]
#[OA\Tag(name: 'Autentikasi - SSO Akademik', description: 'Layanan Autentikasi Terpusat SSO Akademik (https://akademik.fayra.my.id)')]
#[OA\Tag(name: 'Master Data - Lembaga Akreditasi', description: 'Manajemen Data Master Lembaga Akreditasi (LAM INFOKOM, BAN-PT, dll)')]
#[OA\Tag(name: 'Master Data - Versi Instrumen', description: 'Manajemen Versi Instrumen Akreditasi (1.0, 2.0, 2.1, dll)')]
#[OA\Tag(name: 'Master Data - Jenjang', description: 'Manajemen Data Master Jenjang Pendidikan (D3, D4, S1, dll)')]
#[OA\Tag(name: 'Master Data - Instrumen', description: 'Manajemen Instrumen Akreditasi (Jembatan Versi Instrumen, Jenjang, dan Jenis Instrumen)')]
#[OA\Tag(name: 'Master Data - Kriteria', description: 'Manajemen Data Master Kriteria')]
#[OA\Tag(name: 'Master Data - Subkriteria', description: 'Manajemen Data Master Subkriteria')]
#[OA\Tag(name: 'Master Data - Indikator', description: 'Manajemen Data Master Indikator')]
#[OA\Tag(name: 'Master Data - Rubrik', description: 'Manajemen Data Master Rubrik Penilaian')]
#[OA\Tag(name: 'Master Data - Jenis Pembiayaan', description: 'Manajemen Data Master Jenis Pembiayaan')]
#[OA\Tag(name: 'Akreditasi - Project', description: 'Manajemen Project Akreditasi')]
#[OA\Tag(name: 'Akreditasi - Mapping Tim', description: 'Pembagian Tugas dan Penugasan Tim Akreditasi')]
#[OA\Tag(name: 'Akreditasi - Self Assessment', description: 'Penilaian Mandiri oleh Reviewer & Asesor')]
#[OA\Tag(name: 'SPMI - Audit Mutu Internal', description: 'Audit SPMI dan Tindak Lanjut Temuan')]
#[OA\Tag(name: 'SPMI - Evidence Mutu', description: 'Manajemen Evidence SPMI (4 Pilar Bukti) per Project Akreditasi')]
#[OA\Tag(name: 'Sarpras - Sarana & Prasarana', description: 'Manajemen Data Sarana dan Prasarana Program Studi')]
class OpenApiSpec {}
