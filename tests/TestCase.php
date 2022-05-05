<?php

namespace Jncalderon\LaravelApi\Tests;

use Jncalderon\LaravelApi\Facades\Api;
use Jncalderon\LaravelApi\Facades\Transform;
use Jncalderon\LaravelApi\LaravelApiServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelApiServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Api' => Api::class,
            'Transformer' => Transform::class,
        ];
    }
}
