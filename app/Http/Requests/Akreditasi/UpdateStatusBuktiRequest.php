<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class UpdateStatusBuktiRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'status_validasi' => 'required|string|in:Pending,Approved,Revision',
        ];
    }
}
