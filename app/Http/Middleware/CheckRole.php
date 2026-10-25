<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  string  ...$roles  Daftar role yang diizinkan (misal: administrator, reviewer, kaprodi, dosen)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Unauthenticated: Sesi pengguna tidak ditemukan.',
                'data' => null,
                'errors' => null,
            ], 401);
        }

        $userRole = strtoupper((string) ($user->role ?? ''));

        // Normalisasi daftar role yang diperbolehkan menjadi huruf besar
        $allowedRoles = array_map('strtoupper', $roles);

        // Jika ADMINISTRATOR, berikan akses penuh (super role), atau jika role user ada dalam daftar yang diizinkan
        if (in_array('ADMINISTRATOR', $allowedRoles, true) && $userRole === 'ADMINISTRATOR') {
            return $next($request);
        }

        // Administrator memiliki akses bypass jika fitur ini tidak eksklusif dibatasi
        if ($userRole === 'ADMINISTRATOR' || in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        return new JsonResponse([
            'success' => false,
            'message' => "Akses ditolak: Role Anda ({$userRole}) tidak memiliki hak akses untuk fitur ini.",
            'data' => [
                'current_role' => $userRole,
                'required_roles' => $allowedRoles,
            ],
            'errors' => null,
        ], 403);
    }
}
