<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->renderable(function (Throwable $e) {
            if ($e->getMessage() === 'Unauthenticated.' || $e->getMessage() === 'Unauthenticated' || $e->getMessage() === 'Unauthorized.' || $e->getMessage() === 'Unauthorized') {
                return response()->json([
                    'statusCode' => ($e->getCode() > 0 ? $e->getCode() : 401),
                    'message' => $e->getMessage()
                ]);
            }
        });
//        $this->reportable(function (Throwable $e) {
//            //
//        });
    }
}
