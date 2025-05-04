<?php

use App\Http\Middleware\BlockRequest;
use App\Http\Middleware\CheckRequest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Block requests from bad servers
        $middleware->append(BlockRequest::class);

        // Check request and return zip-bomb
        $middleware->append(CheckRequest::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
