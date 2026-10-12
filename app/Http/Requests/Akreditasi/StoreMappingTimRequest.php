<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;

class StoreMappingTimRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            // Mendukung single assignment maupun batch assignments
            'id_user' => 'required_without:assignments|integer',
            'id_indikator' => 'required_without:assignments|integer|exists:indikator,id',
            'assignments' => 'sometimes|array',
            'assignments.*.id_user' => 'required_with:assignments|integer',
            'assignments.*.id_indikator' => 'required_with:assignments|integer|exists:indikator,id',
        ];
    }
}
