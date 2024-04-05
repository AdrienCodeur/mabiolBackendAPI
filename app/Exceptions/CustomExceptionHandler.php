<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;



namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomExceptionHandler extends Exception
{
    //


    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */
    // public function render(Request $request): Response
    // {
    //     return new response([
    //         'statusCode' => 500,
    //         'message' => $exception->getMessage(),
    //     ], 500);
    //     // return response(/* ... */);
    // }
}
