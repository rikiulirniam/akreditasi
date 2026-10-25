<?php

namespace App\Services;

class JwtService
{
    protected string $secret;

    protected string $algo;

    public function __construct(?string $secret = null, ?string $algo = null)
    {
        $this->secret = $secret ?? (string) config('jwt.secret', env('JWT_SECRET', ''));
        $this->algo = strtoupper($algo ?? (string) config('jwt.algo', env('JWT_ALGO', 'HS256')));
    }

    /**
     * Memverifikasi dan mendekode token JWT.
     * Mengembalikan array payload jika valid, atau null jika tidak valid/kedaluwarsa.
     */
    public function decodeAndVerify(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $signatureB64] = $parts;

        $headerJson = $this->base64UrlDecode($headerB64);
        $payloadJson = $this->base64UrlDecode($payloadB64);
        $signature = $this->base64UrlDecode($signatureB64);

        if (! $headerJson || ! $payloadJson) {
            return null;
        }

        $header = json_decode($headerJson, true);
        $payload = json_decode($payloadJson, true);

        if (! is_array($header) || ! is_array($payload)) {
            return null;
        }

        // Verifikasi kesesuaian algoritma
        $tokenAlgo = strtoupper($header['alg'] ?? '');
        if ($tokenAlgo !== $this->algo) {
            return null;
        }

        // Hitung signature HMAC yang diharapkan
        $hashAlgo = $this->getHashAlgorithm($tokenAlgo);
        if (! $hashAlgo) {
            return null;
        }

        $dataToSign = $headerB64.'.'.$payloadB64;
        $expectedSignature = hash_hmac($hashAlgo, $dataToSign, $this->secret, true);

        if (! hash_equals($expectedSignature, $signature)) {
            return null;
        }

        // Validasi waktu kedaluwarsa (exp)
        if (isset($payload['exp']) && (int) $payload['exp'] < time()) {
            return null;
        }

        // Validasi waktu aktif sebelum (nbf)
        if (isset($payload['nbf']) && (int) $payload['nbf'] > time()) {
            return null;
        }

        return $payload;
    }

    /**
     * Membuat token JWT baru (sangat berguna untuk automated test atau mocking).
     */
    public function generateToken(array $payload, int $ttl = 3600): string
    {
        $header = [
            'typ' => 'JWT',
            'alg' => $this->algo,
        ];

        $now = time();
        $defaultPayload = [
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $ttl,
        ];

        $finalPayload = array_merge($defaultPayload, $payload);

        $headerB64 = $this->base64UrlEncode(json_encode($header));
        $payloadB64 = $this->base64UrlEncode(json_encode($finalPayload));

        $dataToSign = $headerB64.'.'.$payloadB64;
        $hashAlgo = $this->getHashAlgorithm($this->algo) ?? 'sha256';
        $signature = hash_hmac($hashAlgo, $dataToSign, $this->secret, true);
        $signatureB64 = $this->base64UrlEncode($signature);

        return $headerB64.'.'.$payloadB64.'.'.$signatureB64;
    }

    protected function getHashAlgorithm(string $jwtAlgo): ?string
    {
        return match ($jwtAlgo) {
            'HS256' => 'sha256',
            'HS384' => 'sha384',
            'HS512' => 'sha512',
            default => null,
        };
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function base64UrlDecode(string $data): string|false
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padLen = 4 - $remainder;
            $data .= str_repeat('=', $padLen);
        }

        return base64_decode(strtr($data, '-_', '+/'));
    }
}
