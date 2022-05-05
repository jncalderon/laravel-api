<?php

namespace Jncalderon\LaravelApi;

use Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    /**
     * Json Response
     * @param null|mixed $data
     * @param null|int $code
     * @param null|string $transformer
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function jsonResponse($data, $code = 200, string $transformer = null): JsonResponse
    {
        return response()->json($this->transform($data, $transformer), $code);
    }

    private function transform($data, $transformer = null)
    {
        if ($data == null) {
            return $this->normalizeResult(0, null);
        }
        if (is_string($data)) {
            return $this->normalizeResult(1, $data);
        }
        if (is_array($data)) {
            // if are collections, try to transform all
            if (array_key_exists('collections', $data)) {
                $items = [];
                foreach ($data['collections'] as $key => $value) {
                    $items[$key] = transformer()->serialize($value);
                }
                // all items collections or model
                return $this->normalizeResult(count($data['collections']), $items);
            }
        }
        $transformed = transformer()->serialize($data, $transformer);
        return $this->normalizeResult(count($transformed), transformer()->camelcaseArray($transformed), $data instanceof LengthAwarePaginator ? $data : null);
    }

    private function normalizeResult($count, $object, $paginator = null)
    {
        $result = ['count' => $count, 'data' => $object];
        if ($paginator !== null) {
            $pagination = [
                'total' => (int) $paginator->total(),
                'count' => (int) $paginator->count(),
                'perPage' => (int) $paginator->perPage(),
                'currentPage' => (int) $paginator->currentPage(),
            ];
            $result['pagination'] = $pagination;
        }
        return $result;
    }
}
