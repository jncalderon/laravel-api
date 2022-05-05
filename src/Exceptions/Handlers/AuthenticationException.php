<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class AuthenticationException
{
    public function __invoke(\Exception $exception): ?JsonResponse
    {
        return response()->json([
            'error' => __('auth.failed'),
            'hint' => __('auth.failed')
        ], 401);
    }
}
