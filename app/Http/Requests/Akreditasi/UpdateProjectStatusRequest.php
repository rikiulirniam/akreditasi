<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProjectStatusRequest extends BaseApiRequest
{
    /**
     * Otorisasi eksklusif untuk role Kaprodi.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return strtoupper((string) ($user?->role ?? '')) === 'KAPRODI';
    }

    /**
     * Tangani jika otorisasi gagal (bukan role Kaprodi).
     */
    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Akses ditolak: Hanya role Kaprodi yang berwenang memperbarui status siklus project akreditasi.',
            'data' => null,
            'errors' => null,
        ], 403));
    }

    /**
     * Aturan validasi status project akreditasi.
     * Nomor SK dan Tanggal Verifikasi akreditasi dilonggarkan menjadi nullable
     * untuk seluruh status termasuk status 'Selesai'.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status_project' => 'required|string|in:Draft,On Progress,Pending,Cancel,Selesai',
            'tanggal_verifikasi_akreditasi' => 'nullable|date',
            'nomor_sk_akreditasi' => 'nullable|string|max:255',
        ];
    }
}
