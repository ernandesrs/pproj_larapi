<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if (\Request::is('api/*')) {
            $exceptions->renderable(function (\Exception $e, $request) {
                $currentExceptionClass = get_class($e);
                $customException = match ($currentExceptionClass) {
                    \Illuminate\Validation\ValidationException::class => \App\Exceptions\Api\InvalidDataException::class,
                    \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => \App\Exceptions\Api\NotFoundException::class,

                    default => null
                };

                throw_if($customException, $customException);
            });

            $exceptions->dontReport([
                \App\Exceptions\Api\InvalidDataException::class,
                \App\Exceptions\Api\NotFoundException::class
            ]);
        }
    })->create();
