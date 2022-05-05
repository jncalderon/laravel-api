<?php

namespace Jncalderon\LaravelApi;

use Jncalderon\LaravelApi\ApiResponse;
use Illuminate\Support\ServiceProvider;

class LaravelApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }
    public function register()
    {
        $this->app->bind('api', function () {
            return new ApiResponse;
        });
        $this->app->bind('transformer', function () {
            return new Transformer;
        });
    }
}
