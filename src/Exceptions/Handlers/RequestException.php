<?php

namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

class RequestException
{
    const CLIENT_NOT_FOUND_EXCEPTION_MESSAGE = 'No entity satisfies the condition.';

    public function __invoke(GuzzleRequestException $exception): ?JsonResponse
    {
        Log::error('GuzzleRequestException: ' . $exception->getMessage());
        $response = $exception->getResponse();
        if (isset($response)) {
            $body = $response->getBody();
            Log::error('Code: ' . $response->getStatusCode());
            if (isset($body)) {
                $content = $body->getContents();
                Log::error('Body: ' . $content);
                $jsonDecoded = json_decode($content, true);
                if (!empty($jsonDecoded['exceptionMessage'])) {
                    if ($jsonDecoded['exceptionMessage'] == self::CLIENT_NOT_FOUND_EXCEPTION_MESSAGE) {
                        return response()->json(['error' => 'The requested resource was not found'], 404);
                    }
                    return response()->json([
                        'error' => $jsonDecoded['exceptionMessage']
                    ], 400);
                }
            }
        }
        return null;
    }
}
