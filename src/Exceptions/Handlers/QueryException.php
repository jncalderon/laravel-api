<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class QueryException
{
    const ERROR_CODE_DB_QUERY_UNIQUE_CONSTRAINT_VIOLATION = 1062;

    public function __invoke(\Illuminate\Database\QueryException $exception): ?JsonResponse
    {
        if (count($exception->errorInfo) > 1) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == self::ERROR_CODE_DB_QUERY_UNIQUE_CONSTRAINT_VIOLATION) {
                return response()->json([
                    'error' => "Entry cannot be created because already exists"
                ], 400);
            }
        }
        return null;
    }
}
