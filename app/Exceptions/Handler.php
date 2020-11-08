<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        \Log::critical('Get Error On : '.url('/').' '. $exception);
        if($exception instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Data you are looking for does not found',
                'data' => null,
                'code' => 404
            ], 404)->header('Content-Type', 'application/json');
        }

        if($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => $exception->validator->errors()->all(),
                'data' => null,
                'code' => 409
            ], 409)->header('Content-Type', 'application/json');
        }

        if($exception instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'Are you lost in somewhere?',
                'data' => null,
                'code' => 404
            ], 404)->header('Content-Type', 'application/json');
        }

        if($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'success' => false,
                'message' => 'We don\'t understand what do u ask for',
                'data' => null,
                'code' => 500
            ], 500)->header('Content-Type', 'application/json');
        }

        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
            'data' => null,
                'code' => 400
        ], 400)->header('Content-Type', 'application/json');
        // return parent::render($request, $exception);
    }
}
