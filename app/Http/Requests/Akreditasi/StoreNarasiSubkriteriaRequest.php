<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreNarasiSubkriteriaRequest extends BaseApiRequest
{
    /**
     * Permintaan diverifikasi oleh middleware role; payload tetap wajib divalidasi di sini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Menentukan isi narasi yang dapat diterima, panjang minimum, dan panjang maksimum.
     */
    public function rules(): array
    {
        return [
            'narasi' => ['required', 'string', 'min:10', 'max:10000'],
        ];
    }
}
