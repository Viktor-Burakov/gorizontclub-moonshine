<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Admin;

use App\Actions\Category\CategoryIndexAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(CategoryIndexAction $action): JsonResponse
    {
        return response()->json($action());
    }
}
