<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateJenisBuktiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'nama_jenis_bukti' => 'sometimes|required|string|max:255',
        ];
    }
}
