<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class SpmiDocs
{
    // ==========================================
    // SPMI AUDIT MUTU INTERNAL
    // ==========================================
    #[OA\Get(
        path: '/spmi-audit',
        summary: 'Mendapatkan daftar data audit SPMI',
        description: 'Menampilkan list data audit SPMI dengan filter id_project, jenis_kegiatan, tahun_audit, dan status_penyelesaian.',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id_project', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter berdasarkan ID Project Akreditasi'),
            new OA\Parameter(name: 'jenis_kegiatan', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['PPEPP', 'AMI', 'RTM']), description: 'Filter jenis kegiatan audit'),
            new OA\Parameter(name: 'tahun_audit', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter Tahun Audit (4 digit)'),
            new OA\Parameter(name: 'status_penyelesaian', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter status penyelesaian (Open / In Progress / Selesai)'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Berhasil memuat daftar audit SPMI', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseListSuccess')),
        ]
    )]
    #[OA\Post(
        path: '/spmi-audit',
        summary: 'Menambahkan temuan audit SPMI baru',
        tags: ['SPMI - Audit Mutu Internal'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_project', 'id_standar', 'tanggal_pelaksanaan', 'tahun_audit'],
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1),
                    new OA\Property(property: 'id_standar', type: 'integer', example: 1),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'jenis_kegiatan', type: 'string', enum: ['PPEPP', 'AMI', 'RTM'], example: 'AMI', nullable: true),
                    new OA\Property(property: 'tanggal_pelaksanaan', type: 'string', format: 'date', example: '2026-10-15'),
                    new OA\Property(property: 'tahun_audit', type: 'integer', example: 2026),
                    new OA\Property(property: 'temuan', type: 'string', example: 'Dokumen SOP pelaksanaan RPS belum diperbarui sesuai kurikulum OBE terbaru.', nullable: true),
                    new OA\Property(property: 'tindak_lanjut', type: 'string', example: 'Workshop review SOP kurikulum pada semester depan.', nullable: true),
                    new OA\Property(property: 'status_penyelesaian', type: 'string', example: 'Open', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Data audit SPMI berhasil ditambahkan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Get(
        path: '/spmi-audit/{id}',
        summary: 'Mendapatkan detail temuan audit SPMI',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail audit SPMI berhasil dimuat', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data audit SPMI tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/spmi-audit/{id}',
        summary: 'Memperbarui data audit SPMI',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_project', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'id_standar', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'id_indikator', type: 'integer', example: 1, nullable: true),
                    new OA\Property(property: 'jenis_kegiatan', type: 'string', enum: ['PPEPP', 'AMI', 'RTM'], example: 'AMI', nullable: true),
                    new OA\Property(property: 'tanggal_pelaksanaan', type: 'string', format: 'date', example: '2026-10-15', nullable: true),
                    new OA\Property(property: 'tahun_audit', type: 'integer', example: 2026, nullable: true),
                    new OA\Property(property: 'temuan', type: 'string', example: 'Revisi temuan audit SPMI.', nullable: true),
                    new OA\Property(property: 'tindak_lanjut', type: 'string', example: 'Revisi rencana tindak lanjut audit.', nullable: true),
                    new OA\Property(property: 'status_penyelesaian', type: 'string', example: 'In Progress', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Data audit SPMI berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Data audit SPMI tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Delete(
        path: '/spmi-audit/{id}',
        summary: 'Menghapus data audit SPMI',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data audit SPMI berhasil dihapus', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 404, description: 'Data audit SPMI tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    #[OA\Put(
        path: '/spmi-audit/{id}/tindak-lanjut',
        summary: 'Memperbarui tindak lanjut temuan audit SPMI',
        description: 'Auditee (Ketua Prodi / Gugus Mutu) mengisi rencana tindak lanjut dan status penyelesaian perbaikan.',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Audit SPMI'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['tindak_lanjut'],
                properties: [
                    new OA\Property(property: 'tindak_lanjut', type: 'string', example: 'Mengadakan rapat konsinyasi penyelarasan RPS dan revisi SOP pembelajaran.'),
                    new OA\Property(property: 'status_penyelesaian', type: 'string', example: 'Selesai', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Tindak lanjut audit SPMI berhasil diperbarui', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
            new OA\Response(response: 404, description: 'Data audit SPMI tidak ditemukan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseNotFound')),
        ]
    )]
    public function spmiAuditDocs() {}

    // ==========================================
    // EVIDENCE SPMI (KAPRODI)
    // ==========================================
    #[OA\Get(
        path: '/evidence-spmi',
        summary: 'Mendapatkan data evidence SPMI berdasarkan project_id',
        description: 'Mengambil data evidence SPMI untuk suatu project. Jika belum ada data, mengembalikan data: null dengan status 200 OK.',
        tags: ['SPMI - Evidence Mutu'],
        parameters: [
            new OA\Parameter(name: 'project_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Data evidence SPMI berhasil diambil', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Parameter project_id tidak disertakan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    #[OA\Post(
        path: '/evidence-spmi',
        summary: 'Menyimpan atau memperbarui data evidence SPMI project',
        description: 'Menyimpan rekaman 4 pilar bukti SPMI berbasis updateOrCreate pada project_id.',
        tags: ['SPMI - Evidence Mutu'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['project_id'],
                properties: [
                    new OA\Property(property: 'project_id', type: 'integer', example: 1),
                    new OA\Property(property: 'link_bukti_evaluasi', type: 'string', example: 'https://drive.google.com/evaluasi', nullable: true),
                    new OA\Property(property: 'deskripsi_bukti_evaluasi', type: 'string', example: 'Laporan AMI Semester Genap', nullable: true),
                    new OA\Property(property: 'link_bukti_pengendalian', type: 'string', example: 'https://drive.google.com/pengendalian', nullable: true),
                    new OA\Property(property: 'deskripsi_bukti_pengendalian', type: 'string', example: 'Tindakan korektif dan RTL rapat tinjauan manajemen', nullable: true),
                    new OA\Property(property: 'link_bukti_dampak', type: 'string', example: 'https://drive.google.com/dampak', nullable: true),
                    new OA\Property(property: 'deskripsi_bukti_dampak', type: 'string', example: 'Bukti luaran tridharma dan prestasi mahasiswa', nullable: true),
                    new OA\Property(property: 'link_dokumen_implementasi', type: 'string', example: 'https://drive.google.com/implementasi', nullable: true),
                    new OA\Property(property: 'deskripsi_dokumen_implementasi', type: 'string', example: 'SOP dan formulir operasional harian prodi', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Evidence SPMI berhasil disimpan', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseSuccess')),
            new OA\Response(response: 422, description: 'Validasi gagal', content: new OA\JsonContent(ref: '#/components/schemas/ApiResponseValidationError')),
        ]
    )]
    public function evidenceSpmiDocs() {}
}
