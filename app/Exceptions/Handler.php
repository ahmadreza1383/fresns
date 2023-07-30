<?php

/*
 * Fresns (https://fresns.org)
 * Copyright (C) 2021-Present Jevan Tang
 * Released under the Apache-2.0 License.
 */

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        ApiException::class,
        DTOException::class,
        \Fresns\DTO\Exceptions\DTOException::class,
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof \Fresns\DTO\Exceptions\DTOException) {
            throw new DTOException($e->getMessage());
        }

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            if (! $request->wantsJson()) {
                return back()->with('failure', $e->validator->errors()->first());
            }

            throw new \RuntimeException($e->validator->errors()->first());
        }

        return parent::render($request, $e);
    }
}
