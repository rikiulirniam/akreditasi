<?php

namespace App\Http\Requests\Spmi;

use App\Http\Requests\BaseApiRequest;

class UpdateTindakLanjutSpmiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'tindak_lanjut' => 'required|string',
            'status_penyelesaian' => 'nullable|string|max:50',
        ];
    }
}
