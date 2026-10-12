<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreJenisPembiayaanRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'nama_pembiayaan' => 'required|string|max:255',
        ];
    }
}
