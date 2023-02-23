<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\AdminRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\BackService\CommentService;
use Illuminate\Http\JsonResponse;

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
     * 获取评论列表
     * @param CommentService $service
     * @param CommentRepository $repository
     * @return JsonResponse
     */
    public function getCommentList(CommentService $service,CommentRepository $repository): JsonResponse
    {
        return $service->getCommentList($repository);
    }

    /**
     * 删除评论
     * @param CommentRequest $request
     * @param CommentService $service
     * @param CommentRepository $repository
     * @return JsonResponse
     */
    public function deleteComment(CommentRequest $request,CommentService $service,CommentRepository $repository): JsonResponse
    {
        return $service->deleteComment($request,$repository);
    }

    /**
     * 评论搜索
     * @param CommentRequest $request
     * @param CommentService $service
     * @param CommentRepository $commentRepository
     * @param UserRepository $userRepository
     * @param AdminRepository $adminRepository
     * @return JsonResponse
     */
    public function searchComment(CommentRequest $request,CommentService $service,CommentRepository $commentRepository,UserRepository $userRepository,AdminRepository $adminRepository): JsonResponse
    {
        return $service->searchComment($request,$commentRepository,$userRepository,$adminRepository);
    }
}
