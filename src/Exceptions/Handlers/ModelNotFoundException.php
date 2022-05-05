<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ModelNotFoundException
{
    public function __invoke(Eloquent\ModelNotFoundException $exception): JsonResponse
    {
        if (empty($exception->getMessage()) || Str::startsWith($exception->getMessage(), 'No query results for model')) {
            $modelName = class_basename($exception->getModel());
            $message = sprintf("No results for %s", $modelName);
            if (!empty($exception->getIds())) {
                $idsString = implode(', ', (array)$exception->getIds());
                $modelKey = App::make($exception->getModel())->getKeyName();
                $message .= sprintf(" with {$modelKey} %s", $idsString);
            }
        } else {
            $message = $exception->getMessage();
        }
        return response()->json([
            'error'    => 'The requested entity was not found',
            'messages' => [$message]
        ], 404);
    }
}
