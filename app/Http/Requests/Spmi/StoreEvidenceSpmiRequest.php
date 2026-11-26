<?php

namespace App\Http\Requests\Spmi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreEvidenceSpmiRequest extends BaseApiRequest
{
    protected function prepareForValidation(): void
    {
        $merges = [];

        if ($this->has('id_project') && ! $this->has('project_id')) {
            $merges['project_id'] = $this->id_project;
        }

        // Alias kompatibilitas untuk 4 pilar dokumen mutu (A6)
        if ($this->has('link_dokumen_kebijakan') && ! $this->has('link_bukti_pengendalian')) {
            $merges['link_bukti_pengendalian'] = $this->input('link_dokumen_kebijakan');
        }
        if ($this->has('link_dokumen_manual') && ! $this->has('link_bukti_dampak')) {
            $merges['link_bukti_dampak'] = $this->input('link_dokumen_manual');
        }
        if ($this->has('link_dokumen_formulir') && ! $this->has('link_dokumen_implementasi')) {
            $merges['link_dokumen_implementasi'] = $this->input('link_dokumen_formulir');
        }

        if (! empty($merges)) {
            $this->merge($merges);
        }
    }

    /**
     * Aturan validasi untuk menyimpan atau memperbarui data evidence SPMI.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => [
                'required',
                'integer',
                'exists:project_akreditasi,id',
            ],
            'link_bukti_evaluasi' => 'required|url:http,https',
            'deskripsi_bukti_evaluasi' => 'nullable|string',
            'link_bukti_pengendalian' => 'nullable|url:http,https',
            'deskripsi_bukti_pengendalian' => 'nullable|string',
            'link_bukti_dampak' => 'nullable|url:http,https',
            'deskripsi_bukti_dampak' => 'nullable|string',
            'link_dokumen_implementasi' => 'nullable|url:http,https',
            'deskripsi_dokumen_implementasi' => 'nullable|string',
            'link_dokumen_kebijakan' => 'nullable|url:http,https',
            'link_dokumen_manual' => 'nullable|url:http,https',
            'link_dokumen_formulir' => 'nullable|url:http,https',
        ];
    }
}
