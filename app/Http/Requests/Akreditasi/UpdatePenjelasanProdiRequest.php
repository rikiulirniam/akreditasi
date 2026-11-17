<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdatePenjelasanProdiRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggapan_kaprodi' => 'required|string',
        ];
    }
}
