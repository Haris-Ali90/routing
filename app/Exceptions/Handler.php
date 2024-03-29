<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App\Helpers\RESTAPIHelper;

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
        HttpResponseException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (
            $request->is('api/*') &&
            !($e instanceof \Illuminate\Http\Exception\HttpResponseException) &&
            !($e instanceof \Exception\ValidationException)
        ) {
            return RESTAPIHelper::response( $e->getMessage(), false, snake_case(class_basename(get_class($e))) );
        }
        // elseif( $request->is('backend/*') &&
        // !($e instanceof \Illuminate\Http\Exception\HttpResponseException) &&
        // !($e instanceof \Exception\ValidationException))
        // {
        //   echo (' 404 Page not found');
        //   die();
        // }
        // else
        // {

        // }

        return parent::render($request, $e);
    }
}
