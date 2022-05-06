# Laravel API

This package help me to some repetitive things in my backend projects.

## Packages required

- [Laravel fractal](https://github.com/spatie/laravel-fractal) (Required)
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) (Optional)
- [Sentry SDK Laravel](https://github.com/getsentry/sentry-laravel) (Optional)

## Installation

```shell
composer require jncalderon/laravel-api
```

# Usage

## Json response

```json
{
  "count": 2,
  "data": [
    {
      "id": 1,
      "name": "Jonh",
      "lastName": "Smith"
    },
    {
      "id": 2,
      "name": "Jonh",
      "lastName": "Smith"
    }
  ]
}
```

## Facades

| Facade                      | Description                           |
| --------------------------- | ------------------------------------- |
| Api::jsonResponse()         | Transform any data to a json Response |
| Transform::serialize()      | Serialize data to a camelcase array   |
| Transform::camecaseArray()  | Camel case all keys in an array       |
| Transform::snakecaseArray() | Snake case all keys in an array       |

## Helpers

Can access to the facades through below helpers

```php
api()->jsonResponse();
transformer()->camelcaseArray();
```

## Error handler

Handler no exceptions to Json, change the extends of the file `app\Exceptions\Handler.php` to:

```php
<?php

namespace App\Exceptions;

use Jncalderon\LaravelApi\Exceptions\Handler as JnHandler;

class Handler extends JnHandler
{
    // no require additional methods and properties
}
```

## Middlewares

In `app\Http\Kernel.php` can add below middlewares.

```php
    protected $middlewareGroups = [
        'api' => [
           ...
           \Jncalderon\LaravelApi\Http\Middleware\JsonDebugbar::class,
           \Jncalderon\LaravelApi\Http\Middleware\ConvertRequestFieldsToCamelCase::class,
           \Jncalderon\LaravelApi\Http\Middleware\Localization::class,
           \Jncalderon\LaravelApi\Http\Middleware\SentryUser::class,
        ],
    ];
```

| Middleware                      | Description                                        |
| ------------------------------- | -------------------------------------------------- |
| JsonDebugbar                    | Attanch to the JsonResponse the debugbar response  |
| ConvertRequestFieldsToCamelCase | All keys of paramaters send force to snake case    |
| Localization                    | Change language adding the header `X-Localization` |
| SentryUser                      | Tracking of the user in Sentry                     |

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](./LICENSE.md)
