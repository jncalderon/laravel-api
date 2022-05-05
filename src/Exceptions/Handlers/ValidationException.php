<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;

class ValidationException
{
    public function __invoke(\Illuminate\Validation\ValidationException $exception): ?JsonResponse
    {
        // $errors = array_map(function ($message): string {
        //     return is_array($message) ? reset($message) : $message;
        // }, $exception->errors());
        $errors = $exception->validator->errors()->getMessages();

        return response()->json(['error' => $errors], 422);
    }
}
