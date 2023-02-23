<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Services\FrontService\CountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountController extends Controller
{
    /**
     * 获取网站信息
     * @param CountService $service
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function getCount(CountService $service,ArticleRepository $articleRepository,CategoryRepository $categoryRepository,TagRepository $tagRepository,CommentRepository $commentRepository): JsonResponse
    {
        return $service->getCount($articleRepository,$categoryRepository,$tagRepository,$commentRepository);
    }
}
