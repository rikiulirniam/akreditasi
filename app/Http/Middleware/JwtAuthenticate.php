<?php

namespace App\Http\Middleware;

use App\Auth\JwtUser;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticate
{
    public function __construct(protected JwtService $jwtService) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token otentikasi tidak ditemukan. Harap sertakan header Authorization: Bearer <token>.',
                'data' => null,
                'errors' => null,
            ], 401);
        }

        $payload = $this->jwtService->decodeAndVerify($token);

        if (! $payload) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Token tidak valid atau telah kedaluwarsa. Silakan login kembali.',
                'data' => null,
                'errors' => null,
            ], 401);
        }

        // Susun objek user dari klaim payload token API Auth
        $userData = [
            'id' => $payload['sub'] ?? ($payload['user']['id'] ?? null),
            'nama' => $payload['nama'] ?? ($payload['user']['nama'] ?? ''),
            'email' => $payload['email'] ?? ($payload['user']['email'] ?? ''),
            'role' => strtoupper((string) ($payload['role'] ?? ($payload['user']['role'] ?? ''))),
            'permissions' => $payload['permissions'] ?? [],
        ];

        $authUser = new JwtUser($userData);

        // Bind user ke request Laravel (dapat diakses via $request->user())
        $request->setUserResolver(fn () => $authUser);
        $request->attributes->set('jwt_user', $userData);
        $request->attributes->set('jwt_payload', $payload);

        return $next($request);
    }
}
