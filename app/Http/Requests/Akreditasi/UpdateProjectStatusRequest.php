<?php

namespace App\Http\Requests\Akreditasi;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProjectStatusRequest extends BaseApiRequest
{
    /**
     * Otorisasi:
     * - PATCH /projects/{id}/status: Eksklusif untuk role Kaprodi.
     * - PUT /projects/{id}/status: Role Kaprodi dan Administrator.
     */
    public function authorize(): bool
    {
        $role = strtoupper((string) ($this->user()?->role ?? ''));

        if ($this->isMethod('PUT')) {
            return in_array($role, ['KAPRODI', 'ADMINISTRATOR'], true);
        }

        return $role === 'KAPRODI';
    }

    protected function prepareForValidation(): void
    {
        $merges = [];

        if ($this->has('nomor_sk') && ! $this->has('nomor_sk_akreditasi')) {
            $merges['nomor_sk_akreditasi'] = $this->input('nomor_sk');
        }
        if ($this->has('tanggal_kedaluwarsa') && ! $this->has('tanggal_verifikasi_akreditasi')) {
            $merges['tanggal_verifikasi_akreditasi'] = $this->input('tanggal_kedaluwarsa');
        }

        if (! empty($merges)) {
            $this->merge($merges);
        }
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
            'status_project' => 'required|string|in:Draft,On Progress,Pending,Cancel,Pengisian,Review,Selesai',
            'tanggal_verifikasi_akreditasi' => 'nullable|date',
            'nomor_sk_akreditasi' => 'nullable|string|max:255',
            'nomor_sk' => 'nullable|string|max:255',
            'tanggal_kedaluwarsa' => 'nullable|date',
        ];
    }
}
