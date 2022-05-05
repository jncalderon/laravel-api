<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class AuthorizationException
{
    public function __invoke(\Illuminate\Auth\Access\AuthorizationException $exception): ?JsonResponse
    {
        return response()->json(['error' => $exception->getMessage() !== 'This action is unauthorized.' ? $exception->getMessage() : __('auth.403')], 403);
    }
}
