<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreLembarProdiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'id_indikator' => 'required|integer|exists:indikator,id',
            'penjelasan_prodi' => 'nullable|string',
        ];
    }
}
