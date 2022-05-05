<?php

namespace Jncalderon\LaravelApi\Http\Middleware;

use Closure;
use Sentry\State\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SentryUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && app()->bound('sentry')) {
            \Sentry\configureScope(function (Scope $scope): void {
                $scope->setUser([
                    'id'    => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'name'  => Auth::user()->name,
                ]);
            });
        }

        return $next($request);
    }
}
