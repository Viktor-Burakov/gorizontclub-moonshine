<?php

namespace App\Http\Controllers\API\Admin\ContentBlock;

use App\Http\Controllers\Post\BaseController;
use App\Http\Requests\Post\StoreDetailRequest;
use App\Http\Requests\Post\StoreRequest;


class StoreController extends BaseController
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {

        $contentBlock = array(
            '12312',
            123124444
        );

        return response()->json($contentBlock);
    }
}
