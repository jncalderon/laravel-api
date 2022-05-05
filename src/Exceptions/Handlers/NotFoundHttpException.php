<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class NotFoundHttpException
{
    public function __invoke(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception): JsonResponse
    {
        return response()->json(['error' => 'The requested resource was not found'], 404);
    }
}
