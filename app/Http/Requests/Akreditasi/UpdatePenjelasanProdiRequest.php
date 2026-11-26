<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePenjelasanProdiRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        $role = strtoupper((string) ($this->user()?->role ?? ''));

        return in_array($role, ['KAPRODI', 'ADMINISTRATOR'], true);
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Akses ditolak: Hanya Kaprodi atau Administrator yang berhak mengisi tanggapan prodi',
            'data' => null,
            'errors' => null,
        ], 403));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggapan_kaprodi' => 'required|string|min:5',
        ];
    }
}
