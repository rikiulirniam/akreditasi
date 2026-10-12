<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreSelfAssessmentRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'id_indikator' => 'required|integer|exists:indikator,id',
            'id_rubrik' => 'required|integer|exists:rubrik,id',
            'catatan_reviewer' => 'nullable|string',
            'asesor_id' => 'nullable|integer',
            'reviewer_id' => 'nullable|integer',
            'tanggal_penilaian' => 'nullable|date',
        ];
    }
}
