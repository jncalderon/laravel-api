<?php

namespace Jncalderon\LaravelApi\Http\Middleware;

use Closure;
use Transformer;
use Illuminate\Http\Request;

class ConvertRequestFieldsToCamelCase
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
        $request->replace(transformer()->snakecaseArray($request->all()));
        return $next($request);
    }
}
