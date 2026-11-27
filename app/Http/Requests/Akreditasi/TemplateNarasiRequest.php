<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class TemplateNarasiRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_subkriteria' => ['nullable', 'integer', 'exists:subkriteria,id'],
            'kategori_data' => ['required', 'string', 'max:80'],
            'nama_template' => ['required', 'string', 'max:255'],
            'template_tersedia' => ['required', 'string', 'max:20000'],
            'template_tidak_tersedia' => ['nullable', 'string', 'max:20000'],
            'sumber_data' => ['nullable', 'array'],
            'sumber_data.*' => ['string', 'max:255'],
            'field_mapping' => ['nullable', 'array'],
            'field_mapping.*' => ['string', 'max:120'],
            'prioritas' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
