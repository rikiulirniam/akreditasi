<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class UpdateJenisPembiayaanRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'nama_pembiayaan' => 'sometimes|required|string|max:255',
        ];
    }
}
