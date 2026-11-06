<?php

namespace App\Http\Requests\Spmi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class StoreEvidenceSpmiRequest extends BaseApiRequest
{
    /**
     * Aturan validasi untuk menyimpan atau memperbarui data evidence SPMI.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $projectTable = Schema::hasTable('projects') ? 'projects' : 'project_akreditasi';

        return [
            'project_id' => [
                'required',
                'integer',
                Rule::exists($projectTable, 'id'),
            ],
            'link_bukti_evaluasi' => 'nullable|string',
            'deskripsi_bukti_evaluasi' => 'nullable|string',
            'link_bukti_pengendalian' => 'nullable|string',
            'deskripsi_bukti_pengendalian' => 'nullable|string',
            'link_bukti_dampak' => 'nullable|string',
            'deskripsi_bukti_dampak' => 'nullable|string',
            'link_dokumen_implementasi' => 'nullable|string',
            'deskripsi_dokumen_implementasi' => 'nullable|string',
        ];
    }
}
