<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class AkreditasiDocs
{
    // ==========================================
    // PROJECTS AKREDITASI
    // ==========================================
    #[OA\Get(
        path: '/projects',
        summary: 'Mendapatkan daftar project akreditasi',
        description: 'Menampilkan list project akreditasi dengan filter id_prodi dan status.',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id_prodi', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Prodi'),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter berdasarkan status project')
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar project akreditasi', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess'))
        ]
    )]
    #[OA\Post(
        path: '/projects',
        summary: 'Membuat project akreditasi baru',
        tags: ['Akreditasi - Project'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_prodi', 'id_versi_instrumen', 'id_jenjang', 'id_jenis_instrumen', 'tahun_akreditasi', 'status'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1),
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenjang', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenis_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'tahun_akreditasi', type: 'string', example: '2026/2027'),
                    new OA\Property(property: 'status', type: 'string', example: 'draft'),
                    new OA\Property(property: 'target_peringkat', type: 'string', example: 'Unggul', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Project akreditasi berhasil dibuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError'))
        ]
    )]
    #[OA\Get(
        path: '/projects/{id}',
        summary: 'Mendapatkan detail project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail project berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Put(
        path: '/projects/{id}',
        summary: 'Memperbarui project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_prodi', 'id_versi_instrumen', 'id_jenjang', 'id_jenis_instrumen', 'tahun_akreditasi', 'status'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1),
                    new OA\Property(property: 'id_versi_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenjang', type: 'integer', example: 1),
                    new OA\Property(property: 'id_jenis_instrumen', type: 'integer', example: 1),
                    new OA\Property(property: 'tahun_akreditasi', type: 'string', example: '2026/2027'),
                    new OA\Property(property: 'status', type: 'string', example: 'pengisian'),
                    new OA\Property(property: 'target_peringkat', type: 'string', example: 'Baik Sekali', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Project berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Delete(
        path: '/projects/{id}',
        summary: 'Menghapus project akreditasi',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Project berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Post(
        path: '/projects/{id}/mapping-tim',
        summary: 'Menyimpan pembagian tugas tim per indikator',
        description: 'Menugaskan user (dosen/PIC) untuk mengisi indikator tertentu pada suatu project akreditasi.',
        tags: ['Akreditasi - Project'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_user', 'id_indikator', 'role'],
                properties: [
                    new OA\Property(property: 'id_user', type: 'integer', example: 101, description: 'ID User / Dosen penyusun'),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'role', type: 'string', example: 'Penyusun', description: 'Peran dalam tim (Ketua / Penyusun / Reviewer)')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Mapping tim berhasil disimpan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    public function projectDocs() {}

    // ==========================================
    // LEMBAR PRODI
    // ==========================================
    #[OA\Get(
        path: '/lembar-prodi',
        summary: 'Mendapatkan narasi lembar prodi',
        description: 'Mengambil catatan atau narasi lembar kerja prodi berdasarkan id_project dan id_indikator.',
        tags: ['Akreditasi - Lembar Prodi'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'id_indikator', in: 'query', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lembar prodi berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Lembar prodi belum diisi atau tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Post(
        path: '/lembar-prodi',
        summary: 'Menyimpan atau memperbarui narasi lembar prodi',
        description: 'Operator atau dosen mengisi narasi penjelasan prodi untuk indikator terkait.',
        tags: ['Akreditasi - Lembar Prodi'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project', 'id_indikator', 'penjelasan_prodi'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'penjelasan_prodi', type: 'string', example: 'Program studi telah merumuskan visi keilmuan yang terintegrasi dengan rencana strategis fakultas.')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lembar prodi berhasil disimpan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError'))
        ]
    )]
    #[OA\Get(
        path: '/lembar-prodi/{id}',
        summary: 'Mendapatkan detail lembar prodi berdasarkan ID',
        tags: ['Akreditasi - Lembar Prodi'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail lembar prodi berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Lembar prodi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Delete(
        path: '/lembar-prodi/{id}',
        summary: 'Menghapus data lembar prodi',
        tags: ['Akreditasi - Lembar Prodi'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lembar prodi berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Lembar prodi tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    public function lembarProdiDocs() {}

    // ==========================================
    // BUKTI DUKUNG
    // ==========================================
    #[OA\Get(
        path: '/bukti',
        summary: 'Mendapatkan daftar bukti dukung',
        description: 'Menampilkan list berkas bukti dukung dengan opsional filter id_lembar_prodi.',
        tags: ['Akreditasi - Bukti'],
        parameters: [
            new OA\Parameter(name: 'id_lembar_prodi', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Lembar Prodi')
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar bukti', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess'))
        ]
    )]
    #[OA\Get(
        path: '/bukti/{id}',
        summary: 'Mendapatkan detail berkas bukti dukung',
        tags: ['Akreditasi - Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail bukti berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Post(
        path: '/bukti',
        summary: 'Upload berkas bukti dukung',
        description: 'Mengunggah file bukti dokumen (pdf, doc, docx, xlsx, zip, jpg, png max 20MB) atau menyertakan tautan eksternal.',
        tags: ['Akreditasi - Bukti'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['id_lembar_prodi', 'id_jenis_bukti', 'nama_bukti', 'uploaded_by'],
                    properties: [
                        new OA\Property(property: 'id_lembar_prodi', type: 'integer', example: 1),
                        new OA\Property(property: 'id_jenis_bukti', type: 'integer', example: 1),
                        new OA\Property(property: 'nama_bukti', type: 'string', example: 'SK Penetapan Visi Misi Prodi'),
                        new OA\Property(property: 'file_dokumen', type: 'string', format: 'binary', description: 'File berkas fisik'),
                        new OA\Property(property: 'tautan_eksternal', type: 'string', example: 'https://prodi.ac.id/dokumen/sk-visi-misi.pdf', nullable: true),
                        new OA\Property(property: 'uploaded_by', type: 'integer', example: 101, description: 'ID User Pengunggah')
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Bukti dukung berhasil diunggah', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError'))
        ]
    )]
    #[OA\Put(
        path: '/bukti/{id}/status',
        summary: 'Memperbarui status validasi bukti',
        description: 'Reviewer/asesor menyetujui, menolak, atau meminta revisi bukti dukung.',
        tags: ['Akreditasi - Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Berkas Bukti')
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status_validasi', 'validated_by'],
                properties: [
                    new OA\Property(property: 'status_validasi', type: 'string', enum: ['Menunggu', 'Disetujui', 'Ditolak', 'Perlu Revisi'], example: 'Disetujui'),
                    new OA\Property(property: 'catatan_validasi', type: 'string', example: 'Dokumen SK telah lengkap dan ditandatangani Dekan.', nullable: true),
                    new OA\Property(property: 'validated_by', type: 'integer', example: 201, description: 'ID Asesor / Reviewer')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status validasi berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Delete(
        path: '/bukti/{id}',
        summary: 'Menghapus berkas bukti',
        description: 'Menghapus catatan bukti dan berkas fisik pada storage Laravel.',
        tags: ['Akreditasi - Bukti'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berkas bukti berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Bukti tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    public function buktiDocs() {}

    // ==========================================
    // SELF ASSESSMENT
    // ==========================================
    #[OA\Get(
        path: '/self-assessment',
        summary: 'Mendapatkan daftar penilaian mandiri',
        description: 'Menampilkan list penilaian mandiri dengan opsional filter id_project.',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project')
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar self-assessment', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess'))
        ]
    )]
    #[OA\Get(
        path: '/self-assessment/{id}',
        summary: 'Mendapatkan detail penilaian mandiri',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail self-assessment berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Delete(
        path: '/self-assessment/{id}',
        summary: 'Menghapus data penilaian mandiri',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data self-assessment berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    #[OA\Post(
        path: '/self-assessment',
        summary: 'Mengisi atau memperbarui penilaian mandiri (Self Assessment)',
        description: 'Reviewer memilih rubrik penilaian. Sistem secara otomatis menghitung skor_terbobot = skor * nilai_bobot.',
        tags: ['Akreditasi - Self Assessment'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project', 'id_indikator', 'id_rubrik', 'id_reviewer'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1),
                    new OA\Property(property: 'id_rubrik', type: 'integer', example: 1),
                    new OA\Property(property: 'id_reviewer', type: 'integer', example: 301),
                    new OA\Property(property: 'catatan_reviewer', type: 'string', example: 'Bukti dukung sangat komprehensif dan implementasi terlaksana dengan sangat baik.', nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Penilaian mandiri berhasil disimpan dan skor terbobot terhitung otomatis', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError'))
        ]
    )]
    #[OA\Get(
        path: '/self-assessment/rekap/{projectId}',
        summary: 'Mendapatkan rekapitulasi penilaian mandiri per project',
        description: 'Menghitung dan mengelompokkan total nilai skor terbobot per indikator dan total keseluruhan untuk project akreditasi.',
        tags: ['Akreditasi - Self Assessment'],
        parameters: [
            new OA\Parameter(name: 'projectId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi')
        ],
        responses: [
            new OA\Response(response: 200, description: 'Rekapitulasi berhasil dihitung dan dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Project tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound'))
        ]
    )]
    public function selfAssessmentDocs() {}
}
