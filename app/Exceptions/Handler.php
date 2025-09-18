<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
use Illuminate\Session\TokenMismatchException;


class Handler extends ExceptionHandler
{
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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view('error_method_not_allowed', [
                'errorMessage' => 'Access denied, method not allowed',
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        return parent::render($request, $exception);
    }

    /**
     * Render the given MethodNotAllowedHttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderMethodNotAllowedHttpException(MethodNotAllowedHttpException $e)
    {
        return response()->json(['error' => 'Metode HTTP tidak didukung.'], Response::HTTP_METHOD_NOT_ALLOWED);
    }

}
