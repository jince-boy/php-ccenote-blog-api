<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Services\FrontService\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 获取分类文章
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getCategoryArticle(CategoryRequest $request,CategoryService $service,CategoryRepository $repository): JsonResponse
    {
        return $service->getCategoryArticle($request,$repository);
    }
}
