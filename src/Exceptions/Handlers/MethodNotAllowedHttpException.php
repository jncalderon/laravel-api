<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class MethodNotAllowedHttpException
{
    public function __invoke(\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception): ?JsonResponse
    {
        return response()->json((['error' => 'Method Not Allowed']), 405);
    }
}
