<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Services\BackService\ArticleService;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * 获取文章列表
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function getArticleList(ArticleRequest $request,ArticleService $service,ArticleRepository $repository): JsonResponse
    {
        return $service->getArticleList($request,$repository);
    }

    /**
     * 获取文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function getArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $repository): JsonResponse
    {
        return $service->getArticle($request,$repository);
    }

    /**
     * 添加文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function addArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $repository,CategoryRepository $categoryRepository,TagRepository $tagRepository): JsonResponse
    {
        return $service->addArticle($request,$repository,$categoryRepository,$tagRepository);
    }

    /**
     * 修改文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function UpdateArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $repository,CategoryRepository $categoryRepository,TagRepository $tagRepository): JsonResponse
    {
        return $service->updateArticle($request,$repository,$categoryRepository,$tagRepository);
    }

    /**
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @return JsonResponse
     * 上传文章图片
     */
    public function addArticleImg(ArticleRequest $request,ArticleService $service): JsonResponse
    {
        return $service->addArticleImg($request);
    }

    /**
     * 上传文章视频
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function addArticleVideo(ArticleRequest $request,ArticleService $service): JsonResponse
    {
        return $service->addArticleVideo($request);
    }

    /**
     * 删除文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        return $service->deleteArticle($request,$repository,$commentRepository);
    }

    /**
     * 搜索文章
     * @param ArticleRequest $request
     * @param ArticleService $service
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function searchArticle(ArticleRequest $request,ArticleService $service,ArticleRepository $repository): JsonResponse
    {
        return $service->searchArticle($request->title,$repository);
    }
}
