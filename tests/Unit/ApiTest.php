<?php

namespace Jncalderon\LaravelApi\Tests\Unit;

use Jncalderon\LaravelApi\Tests\TestCase;

class ApiTest extends TestCase
{
    /** @test */
    public function json_response_test()
    {
        $response = api()->jsonResponse([
            'key_1' => 'value_1',
            'key_2' => 'value_2',
            'key_3' => 'value_3',
        ]);

        $this->assertTrue($response->getData()->count === 3, 'Count must be 3');
        $this->assertTrue(property_exists($response->getData()->data, 'key1'), 'keys not transformed to camel case');
    }
}
