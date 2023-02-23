<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Services\BackService\HomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 获取系统数据
     * @param HomeService $service
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function getWebData(HomeService $service,UserRepository $userRepository,ArticleRepository $articleRepository,CategoryRepository $categoryRepository,TagRepository $tagRepository,CommentRepository $commentRepository): JsonResponse
    {
        return $service->getWebData($userRepository,$articleRepository,$categoryRepository,$tagRepository,$commentRepository);
    }
}
