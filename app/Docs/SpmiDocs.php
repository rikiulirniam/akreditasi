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
        description: 'Menampilkan list data audit SPMI dengan filter id_prodi, tahun, dan status_audit.',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id_prodi', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter ID Program Studi'),
            new OA\Parameter(name: 'tahun', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Filter Tahun Audit'),
            new OA\Parameter(name: 'status_audit', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Filter status (Open / Closed / In Progress)'),
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
                required: ['id_prodi', 'id_standar_mutu', 'id_auditor', 'tahun', 'hasil_audit', 'kondisi_temuan', 'status_audit', 'tanggal_audit'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1),
                    new OA\Property(property: 'id_standar_mutu', type: 'integer', example: 1),
                    new OA\Property(property: 'id_auditor', type: 'integer', example: 401),
                    new OA\Property(property: 'tahun', type: 'integer', example: 2026),
                    new OA\Property(property: 'hasil_audit', type: 'string', example: 'Observasi', description: 'Kesesuaian / Ketidaksesuaian Mayor / Minor / Observasi'),
                    new OA\Property(property: 'kondisi_temuan', type: 'string', example: 'Dokumen SOP pelaksanaan RPS belum diperbarui sesuai kurikulum OBE terbaru.'),
                    new OA\Property(property: 'akar_masalah', type: 'string', example: 'Keterbatasan waktu koordinasi tim kurikulum pada semester gasal.', nullable: true),
                    new OA\Property(property: 'rekomendasi', type: 'string', example: 'Lakukan workshop review SOP dan penyelarasan RPS serentak sebelum semester genap.', nullable: true),
                    new OA\Property(property: 'status_audit', type: 'string', example: 'Open'),
                    new OA\Property(property: 'tanggal_audit', type: 'string', format: 'date', example: '2026-10-15'),
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
                required: ['id_prodi', 'id_standar_mutu', 'id_auditor', 'tahun', 'hasil_audit', 'kondisi_temuan', 'status_audit', 'tanggal_audit'],
                properties: [
                    new OA\Property(property: 'id_prodi', type: 'integer', example: 1),
                    new OA\Property(property: 'id_standar_mutu', type: 'integer', example: 1),
                    new OA\Property(property: 'id_auditor', type: 'integer', example: 401),
                    new OA\Property(property: 'tahun', type: 'integer', example: 2026),
                    new OA\Property(property: 'hasil_audit', type: 'string', example: 'Ketidaksesuaian Minor'),
                    new OA\Property(property: 'kondisi_temuan', type: 'string', example: 'Revisi kondisi temuan audit oleh auditor.'),
                    new OA\Property(property: 'akar_masalah', type: 'string', example: 'Akar masalah diperbarui.', nullable: true),
                    new OA\Property(property: 'rekomendasi', type: 'string', example: 'Rekomendasi audit diperbarui.', nullable: true),
                    new OA\Property(property: 'status_audit', type: 'string', example: 'In Progress'),
                    new OA\Property(property: 'tanggal_audit', type: 'string', format: 'date', example: '2026-10-15'),
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
        description: 'Auditee (Ketua Prodi / Gugus Mutu) mengisi rencana tindak lanjut, tanggal efektif, dan evaluasi hasil perbaikan.',
        tags: ['SPMI - Audit Mutu Internal'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Audit SPMI'),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rencana_tindak_lanjut', 'status_tindak_lanjut'],
                properties: [
                    new OA\Property(property: 'rencana_tindak_lanjut', type: 'string', example: 'Mengadakan rapat konsinyasi penyelarasan RPS dan revisi SOP pembelajaran.'),
                    new OA\Property(property: 'status_tindak_lanjut', type: 'string', enum: ['Belum Dilaksanakan', 'Sedang Berjalan', 'Selesai', 'Efektif'], example: 'Selesai'),
                    new OA\Property(property: 'tanggal_efektif', type: 'string', format: 'date', example: '2026-11-01', nullable: true),
                    new OA\Property(property: 'evaluasi_efektivitas', type: 'string', example: 'Seluruh RPS telah sesuai panduan kurikulum OBE terbaru.', nullable: true),
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
