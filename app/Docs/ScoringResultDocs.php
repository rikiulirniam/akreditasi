<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

class ScoringResultDocs
{
    #[OA\Get(
        path: '/projects/{id}/scoring-result',
        summary: 'Mendapatkan hasil simulasi akreditasi',
        description: 'Menghitung Nilai Akhir (total_na), predikat kelayakan, rekapitulasi skor per subkriteria, serta detail simulasi indikator non-data.',
        tags: ['Akreditasi - Project'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), description: 'ID Project Akreditasi'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Hasil simulasi akreditasi berhasil dihitung',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Hasil simulasi akreditasi berhasil dihitung'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'project_id', type: 'integer', example: 1),
                                new OA\Property(property: 'nama_project', type: 'string', example: 'Akreditasi D4 Teknik Informatika'),
                                new OA\Property(property: 'total_na', type: 'number', format: 'float', example: 362.5),
                                new OA\Property(property: 'predikat', type: 'string', example: 'Terakreditasi Unggul'),
                                new OA\Property(
                                    property: 'skor_per_subkriteria',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'id_subkriteria', type: 'integer', example: 10),
                                            new OA\Property(property: 'kode_subkriteria', type: 'string', example: 'A.1'),
                                            new OA\Property(property: 'nama_subkriteria', type: 'string', example: 'Visi, Misi, Tujuan dan Strategi'),
                                            new OA\Property(property: 'total_skor_terbobot', type: 'number', format: 'float', example: 12.0),
                                            new OA\Property(property: 'jumlah_indikator', type: 'integer', example: 3),
                                            new OA\Property(property: 'jumlah_dinilai', type: 'integer', example: 3),
                                        ]
                                    )
                                ),
                                new OA\Property(property: 'is_simulated', type: 'boolean', example: false),
                                new OA\Property(property: 'minimum_not_met', type: 'boolean', example: false),
                                new OA\Property(
                                    property: 'detail_simulasi',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: 'id_indikator', type: 'integer', example: 15),
                                            new OA\Property(property: 'kode_indikator', type: 'string', example: 'E.1.1'),
                                            new OA\Property(property: 'nama_indikator', type: 'string', example: 'Penjaminan Mutu Tata Kelola'),
                                            new OA\Property(property: 'skor_default', type: 'integer', example: 3),
                                            new OA\Property(property: 'keterangan', type: 'string', example: 'Menggunakan skor default simulasi (indikator non-data)'),
                                        ]
                                    )
                                ),
                            ]
                        ),
                        new OA\Property(property: 'errors', type: 'null', nullable: true),
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 403, description: 'Unauthorized / Forbidden'),
            new OA\Response(response: 404, description: 'Project tidak ditemukan'),
        ]
    )]
    public function scoringResultDocs(): void {}
}
