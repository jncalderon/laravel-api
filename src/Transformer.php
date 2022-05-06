<?php

namespace Jncalderon\LaravelApi;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Jncalderon\LaravelApi\Serializer\ApiSerializer;

class Transformer
{
    /**
     * Transform collection or model with fractal
     * @param null|mixed $data
     * @param null|string $transformer
     * 
     * @return array|null|string
     */
    public function serialize($data, $tranformer = null): array|null|string
    {
        if ($data === null) {
            return null;
        }
        // if is array can't tranform
        if (is_array($data)) {
            return $data;
        }
        if (is_string($data)) {
            return $data;
        }
        if ($data instanceof Collection) {
            // if collection is empty not transform
            if ($data->isEmpty()) {
                return [];
            }
        }
        // https://fractal.thephpleague.com/pagination/
        // https://github.com/spatie/fractalistic#using-pagination
        if ($data instanceof LengthAwarePaginator) {
            $collection = $data->getCollection();
            if ($collection->isEmpty()) {
                return [];
            }
            $tranformer = $tranformer !== null ? $tranformer : $this->findTransformerClass($collection);

            return fractal($collection, $tranformer)
                ->serializeWith(new ApiSerializer)
                ->toArray();
        }

        try {
            // get transformer name
            $tranformer = $tranformer !== null ? $tranformer :  $this->findTransformerClass($data);
        } catch (\Error $e) {
            return $data->toArray(); // example GeneralSettings
        }

        // if not exists transformer only return array
        if ($tranformer === null) {
            return $data->toArray();
        }
        // apply transformer
        return  fractal(
            $data,
            $tranformer,
        )->toArray();
    }

    private function findModel($data)
    {
        if ($data instanceof Collection) {
            // if collection is empty not transform
            if ($data->isEmpty()) {
                return null;
            }
            return $data->first();
        }

        if ($data instanceof LengthAwarePaginator) {
            $collection = $data->getCollection();
            if ($collection->isEmpty()) {
                return null;
            }
            return $collection->first();
        }

        if ($data instanceof Model) {
            return $data;
        }

        return null;
    }

    private function className(Model $model)
    {
        return str_replace('App\\Models\\', '', get_class($model));
    }

    private function findTransformerClass($data): string|null
    {
        $model = $this->findModel($data);
        if ($model === null) {
            return null;
        }
        $name = $this->className($model);

        $path = "App\\Transformers\\{$name}Transformer";
        return class_exists($path) ? $path : null;
    }

    /**
     * convert an array to camelcase key recursive
     * @param null|mixed $data
     * 
     * @return array
     */
    public function camelcaseArray($data): array|null
    {
        if ($data === null) {
            return null;
        }
        $newArray = [];
        foreach ($data as $key => $item) {
            $newArray[Str::camel($key)] =  is_array($item) ? $this->camelcaseArray($item) : $item;
        }
        return $newArray;
    }
    /**
     * convert an arrary to snakecase key recursive
     * @param null|mixed $data
     *
     * @return array
     */
    public function snakecaseArray($data): array|null
    {
        if ($data === null) {
            return null;
        }
        $newArray = [];
        foreach ($data as $key => $item) {
            $newArray[Str::snake($key)] =  is_array($item) ? $this->snakecaseArray($item) : $item;
        }
        return $newArray;
    }
}
