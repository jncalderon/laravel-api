<?php

namespace Jncalderon\LaravelApi\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
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

    /** @test */
    public function json_response_from_collection_test()
    {
        $collection = collect([
            'collection_value_key_1' => 'value 1'
        ]);

        $response = api()->jsonResponse($collection);

        $this->assertTrue($response->getData()->count === 1, 'Count must be 1');
        $this->assertTrue(property_exists($response->getData()->data, 'collectionValueKey1'), 'keys not transformed to camel case');
    }

    /** @test */
    public function json_response_from_model_test()
    {
        $model = new TestModel;
        $model->id = 1;
        $model->name_model = 'test_model';

        $response = api()->jsonResponse($model);
        $this->assertTrue($response->getData()->count === 2, 'Count must be 2');
        $this->assertTrue(property_exists($response->getData()->data, 'nameModel'), 'keys not transformed to camel case');
    }

    /** @test */
    public function json_response_from_models_test()
    {
        $model1 = new TestModel;
        $model1->id = 1;
        $model1->name_model = 'test_model';

        $model2 = new TestModel;
        $model2->id = 2;
        $model2->name_model = 'test_model2';

        $response = api()->jsonResponse(collect([$model1, $model2]));

        $this->assertTrue($response->getData()->count === 2, 'Count must be 2');
        $this->assertTrue(property_exists($response->getData()->data[0], 'nameModel'), 'keys not transformed to camel case');
    }
}

class TestModel extends Model
{
}
