<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php', // Include API routing if necessary
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware that applies to every request
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        // Middleware aliases for route-specific usage
        $middleware->alias([
            'guest' => \App\Http\Middleware\Guest::class,
            'dekan' => \App\Http\Middleware\Dekan::class,
            'akademik' => \App\Http\Middleware\Akademik::class,
            'dosenwali' => \App\Http\Middleware\Dosenwali::class,
            'kaprodi' => \App\Http\Middleware\Kaprodi::class,
            'mahasiswa' => \App\Http\Middleware\Mahasiswa::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions if needed, e.g., custom exception handlers
    })
    ->create();