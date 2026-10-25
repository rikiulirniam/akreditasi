<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\JwtAuthenticate;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'jwt.auth' => JwtAuthenticate::class,
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint atau data tidak ditemukan.',
                    'data' => null,
                    'errors' => null,
                ], 404);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                if ($e instanceof HttpExceptionInterface) {
                    $status = $e->getStatusCode();
                    $defaultMessages = [
                        401 => 'Unauthenticated. Silakan login terlebih dahulu.',
                        403 => 'Forbidden. Anda tidak memiliki hak akses untuk resource ini.',
                        404 => 'Endpoint atau data tidak ditemukan.',
                        405 => 'Metode HTTP tidak diizinkan untuk endpoint ini.',
                    ];

                    return response()->json([
                        'success' => false,
                        'message' => $defaultMessages[$status] ?? ($e->getMessage() ?: 'Terjadi kesalahan pada request.'),
                        'data' => null,
                        'errors' => null,
                    ], $status);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi data gagal.',
                        'data' => null,
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
                        'data' => null,
                        'errors' => null,
                    ], 401);
                }

                // Default 500 - Internal Server Error
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan internal pada server.',
                    'data' => null,
                    'errors' => config('app.debug') ? [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ] : null,
                ], 500);
            }
        });
    })->create();
