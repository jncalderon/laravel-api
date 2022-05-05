<?php

/**
 * https://gist.github.com/osibg/c58afbe2616a584751caab98c3f0b33e
 * https://gist.github.com/osibg/8ace6831e978e916b9d2f578f55f073a
 * https://www.objectsystems.com/blog/improving-laravels-error-handler/
 */

namespace Jncalderon\LaravelApi\Exceptions;

use Throwable;
use App\Exceptions\Handlers;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        \League\OAuth2\Server\Exception\OAuthServerException::class,
    ];

    protected $handlerCasts = [
        ModelNotFoundException::class        => Handlers\ModelNotFoundException::class,
        QueryException::class                => Handlers\QueryException::class,
        RequestException::class              => Handlers\RequestException::class,
        ValidationException::class           => Handlers\ValidationException::class,
        FileCannotBeAdded::class             => Handlers\FileCannotBeAdded::class,
        AuthorizationException::class        => Handlers\AuthorizationException::class,
        UnauthorizedHttpException::class     => Handlers\AuthorizationException::class,
        AuthenticationException::class       => Handlers\AuthenticationException::class,
        MethodNotAllowedHttpException::class => Handlers\MethodNotAllowedHttpException::class,
        NotFoundHttpException::class         => Handlers\NotFoundHttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->reportable(function (Throwable $exception) {

            if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 3) {
                return; // not important
            }
            if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 6) {
                return; // not important
            }
            if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 8) {
                return; // error token refresh, not important
            }
            if ($exception instanceof \League\OAuth2\Server\Exception\OAuthServerException && $exception->getCode() == 9) {
                return;
            }

            //parent::report($exception);
        });
    }

    public function render($request, Throwable $exception)
    {
        // dd($exception);
        // if (($request instanceof Request && !$request->expectsJson()) || config('app.debug', false)) {
        //     return parent::render($request, $exception);
        // }
        foreach ($this->handlerCasts as $class => $handlerClass) {
            if (!$exception instanceof $class) {
                continue;
            }
            $response = (new $handlerClass)($exception);
            if (isset($response)) {
                return $response;
            }
        }
        return response()->json(['error' => $exception->getMessage()], 500);
    }
}
