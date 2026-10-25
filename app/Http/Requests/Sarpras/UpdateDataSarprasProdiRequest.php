<?php

namespace App\Http\Requests\Sarpras;

use App\Http\Requests\BaseApiRequest;

class UpdateDataSarprasProdiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'id_project' => 'sometimes|required|integer|exists:project_akreditasi,id',
            'keterangan' => 'nullable|string',
        ];
    }
}
