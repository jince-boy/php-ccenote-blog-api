<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\FrontService\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * 添加评论
     * @param CommentRequest $request
     * @param CommentService $service
     * @param CommentRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function addComment(CommentRequest $request,CommentService $service,CommentRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        return $service->addComment($request,$repository,$articleRepository);
    }

    /**
     * 最新评论列表
     * @param CommentService $service
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function newCommentList(CommentService $service,CommentRepository $commentRepository): JsonResponse
    {
        return $service->newComment($commentRepository);
    }

    /**
     * 获取文章评论
     * @param CommentRequest $request
     * @param CommentService $service
     * @param CommentRepository $repository
     * @return JsonResponse
     */
    public function getArticleCommentList(CommentRequest $request,CommentService $service,CommentRepository $repository): JsonResponse
    {
        return $service->CommentList($request,$repository);
    }
}
