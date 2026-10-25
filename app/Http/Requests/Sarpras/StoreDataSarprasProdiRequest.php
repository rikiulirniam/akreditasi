<?php

namespace App\Http\Requests\Sarpras;

use App\Http\Requests\BaseApiRequest;

class StoreDataSarprasProdiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'required|integer|exists:project_akreditasi,id',
            'kapasitas' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
        ];
    }
}
