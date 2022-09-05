<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (Str::contains($e->getMessage(), 'Duplicate entry')) {
            return response()->json([
                'message' => 'Duplicate entry',
                'errors' => $e->getMessage()
            ], 400);
        }

        $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $statusCode =  $e->getCode();
        $details = [
            'message' => $e->getMessage(),
        ];
        if ($e instanceof ValidationException) {
            $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $details['message'] = $e->getMessage();
            foreach ($e->errors() as $key => $error) {
                $details['errors'][$key] = $error[0] ?? 'Unknown error';
            }
        }

        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            $httpCode = Response::HTTP_NOT_FOUND;
            $statusCode = Response::HTTP_NOT_FOUND;
            $details['message'] = 'Not Found';
        }

        if ($e instanceof BadRequestHttpException) {
            $httpCode = Response::HTTP_BAD_REQUEST;
            $statusCode = Response::HTTP_BAD_REQUEST;
            $details['message'] = 'Bad Request';
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $httpCode = Response::HTTP_METHOD_NOT_ALLOWED;
            $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
            $details['message'] = 'Method Not Allowed';
        }

        if ($e instanceof AuthorizationException) {
            $httpCode = Response::HTTP_UNAUTHORIZED;
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $details['message'] = 'Unauthorized';
        }

        $data = [
            'status'  => $statusCode,
            'errors' => $details,
        ];

        if ($httpCode === Response::HTTP_INTERNAL_SERVER_ERROR && !config('app.debug')) {
            $data['errors'] = [
                'message' => 'Server error',
            ];
        }

        return response()->json($data, $httpCode);
    }
}
