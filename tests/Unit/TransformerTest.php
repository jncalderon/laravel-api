<?php

namespace Jncalderon\LaravelApi\Tests\Unit;

use Jncalderon\LaravelApi\Tests\TestCase;

class TransformerTest extends TestCase
{
    /** @test */
    public function array_camel_transform_test()
    {
        $camel = transformer()->camelcaseArray([
            'key_1' => 'value_1',
        ]);
        $snake = transformer()->snakecaseArray([
            'key_1' => 'value_1',
            'camelCase' => 'value_2',
        ]);

        $this->assertArrayHasKey('key1', $camel);
        $this->assertArrayHasKey('camel_case', $snake);
    }

    /** @test */
    public function fractal_array_test()
    {
        $data = transformer()->serialize([
            'key_1' => 'value_1',
        ]);

        $this->assertIsArray($data, 'serialize must be array');
    }
}
