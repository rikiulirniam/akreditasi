<?php

namespace App\Http\Requests\Spmi;

use App\Http\Requests\BaseApiRequest;

class UpdateDataSpmiAuditRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'sometimes|required|integer|exists:project_akreditasi,id',
            'id_standar' => 'sometimes|required|integer|exists:standar_mutu,id',
            'id_indikator' => 'nullable|integer|exists:indikator,id',
            'jenis_kegiatan' => 'sometimes|required|string|in:PPEPP,AMI,RTM',
            'tanggal_pelaksanaan' => 'sometimes|required|date',
            'tahun_audit' => 'sometimes|required|digits:4|integer|min:1900|max:2099',
            'temuan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'status_penyelesaian' => 'sometimes|required|string|max:50',
        ];
    }
}
