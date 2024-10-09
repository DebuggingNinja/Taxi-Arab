<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        $data = [
            'success' => false,
            'message' => $exception->getMessage(),
        ];

        if (env('APP_DEBUG')) {
            if ($exception instanceof ValidationException) {
                $data['errors'] = $exception->errors();
            }

            if ($exception->getTrace() ?? false) {
                $data['trace'] = $exception->getTrace();
            }
        }

        $status = $response->getStatusCode();

        // Check if it's an API request based on the Accept header
        if ($request->expectsJson()) {
            return response()->json($data, $status);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access.',
            ], 401);
        }

        return parent::unauthenticated($request, $exception);
    }
}
