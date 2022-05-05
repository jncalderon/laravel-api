<?php

namespace Jncalderon\LaravelApi\Facades;

use Illuminate\Support\Facades\Facade;

class Transform extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'transformer';
    }
}
