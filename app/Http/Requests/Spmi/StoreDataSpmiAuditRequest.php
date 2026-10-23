<?php

namespace App\Http\Requests\Spmi;

use App\Http\Requests\BaseApiRequest;

class StoreDataSpmiAuditRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'id_standar' => 'required|integer|exists:standar_mutu,id',
            'id_indikator' => 'nullable|integer|exists:indikator,id',
            'jenis_kegiatan' => 'nullable|string|in:PPEPP,AMI,RTM',
            'tanggal_pelaksanaan' => 'required|date',
            'tahun_audit' => 'required|digits:4|integer|min:1900|max:2099',
            'temuan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'status_penyelesaian' => 'nullable|string|max:50',
        ];
    }
}
