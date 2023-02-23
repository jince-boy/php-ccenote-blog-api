<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Services\FrontService\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * 获取热门文章
     * @param ArticleService $service
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function hotArticle(ArticleService $service,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->hotArticle($articleRepository);
    }

    /**
     * 获取文章列表
     * @param ArticleService $service
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function getArticleList(ArticleService $service,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->getArticleList($articleRepository);
    }

    /**
     * 搜索文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function searchFrontArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $articleRepository): JsonResponse{
        return $service->searchFrontArticle($request,$articleRepository);
    }

    /**
     * 获取文章详情
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function getArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->getArticle($request,$articleRepository);
    }
}
