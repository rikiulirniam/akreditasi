<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\BaseApiRequest;

class StoreJenisBuktiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'nama_jenis_bukti' => 'required|string|max:255',
        ];
    }
}
