<?php

declare(strict_types=1);

use Jncalderon\LaravelApi\ApiResponse;
use Jncalderon\LaravelApi\Transformer;

/**
 * Used to Json Responses
 * 
 * @return Jncalderon\LaravelApi\ApiResponse
 */
if (!function_exists('api')) {
    /** @return api */
    function api()
    {
        return app(ApiResponse::class);
    }
}

/**
 * Used to transform data helpers
 * 
 * @return Jncalderon\LaravelApi\Transformer
 */
if (!function_exists('transformer')) {
    /** @return transformer */
    function transformer()
    {
        return app(Transformer::class);
    }
}
