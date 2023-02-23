<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\BackService\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 获取分类列表
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getCategorysList(CategoryService $service,CategoryRepository $repository): JsonResponse
    {
        return $service->getCategorysList($repository);
    }

    /**
     * 获取分类详情
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getCategory(CategoryRequest $request,CategoryService $service,CategoryRepository $repository): JsonResponse
    {
        return $service->getCategory($request,$repository);
    }

    /**
     * 添加分类
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function addCategory(CategoryRequest $request,CategoryService $service,CategoryRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->addCategory($request,$repository,$articleRepository);
    }

    /**
     * 修改分类
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function updateCategory(CategoryRequest $request,CategoryService $service,CategoryRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->updateCategory($request,$repository,$articleRepository);
    }

    /**
     * 删除分类
     * @param CategoryRequest $request
     * @param CategoryService $service
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function deleteCategory(CategoryRequest $request,CategoryService $service,CategoryRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->deleteCategory($request,$repository,$articleRepository);
    }
}
