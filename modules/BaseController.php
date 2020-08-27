<?php

namespace Hamlet\Modules;

use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\ArraySerializer;

class BaseController extends Controller
{
    use Helpers, DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    /**
     *
     * Format paginated data from a collection
     *
     * @param   [type]  $paginator    [$paginator description]
     * @param   [type]  $transformer  [$transformer description]
     *
     * @return  [type]                [return description]
     */
    protected function successWithPages($paginator, $transformer, $resourceName = null)
    {
        $collection = $paginator->getCollection();

        if (!$resourceName) {
            $resourceName = "items";
        }

        $data = fractal()
            ->collection($collection)
            ->transformWith($transformer)
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceName)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();

        return response()->json([
            'status' => "success",
            'data' => $data,
        ]);
    }

    protected function transformPages($paginator, $transformer, $resourceName = null)
    {
        $collection = $paginator->getCollection();

        if (!$resourceName) {
            $resourceName = "items";
        }

        return fractal()
            ->collection($collection)
            ->transformWith($transformer)
            ->serializeWith(new ArraySerializer())
            ->withResourceName($resourceName)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();


    }

    protected function transform($model, $transformer)
    {
        $data = fractal($model, $transformer)->serializeWith(new \Spatie\Fractalistic\ArraySerializer());
        return $this->success($data);
    }

    /**
     * Format successful request response
     *
     * @param   [mixed]  $data  A string or array
     *
     * @return  [object]        JSON object
     */
    protected function success($data)
    {
        return response()->json(
            [
                'status' => "success",
                'data' => $data,
            ]
        );
    }

    protected function handleErrorResponse($response)
    {
        $nextAction = isset($response['next_action']) ? $response['next_action'] : null;
        if (isset($response['error'])) {
            return $this->error($response['message'], $response['status_code'], $nextAction);
        }

        return $this->fail($response['message'], $response['status_code'], $nextAction);
    }

    /**
     * This handle formatted API error responses
     * @param $data
     * @param $code (optional) HTTP Error code
     */
    protected function error($data, $code = null, $nextAction)
    {
        if (!$code || is_string($code)) {
            $code = 422;
        }

        return response()->json([
            'status' => "error",
            'message' => $data,
            'next_action' => $nextAction

        ], $code);
    }

    protected function fail($data, $code = null, $nextAction = null)
    {
        if (!$code || is_string($code)) {
            $code = 422;
        }

        return response()->json([
            'status' => "fail",
            'data' => $data,
            'next_action' => $nextAction

        ], $code);
    }
}
