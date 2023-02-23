<?php

namespace App\Services\BackService;

use App\Repositories\AdminRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use App\Utils\Keyword;
use Illuminate\Http\JsonResponse;

class CommentService extends BaseService
{

    public $isKeyword;

    /**
     * 添加评论
     * @param $request
     * @param CommentRepository $commentRepository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function addComment($request, CommentRepository $commentRepository, ArticleRepository $articleRepository): JsonResponse
    {
        if (!$articleRepository->exists("id", $request->article_id)) {
            return $this->Json("评论错误", null, HttpCode::HTTP_TYPE_ERROR, false, "该文章不存在");
        }
        if ($request->parent_id != null) {
            if (!$commentRepository->exists("id", $request->parent_id)) {
                return $this->Json("评论错误", null, HttpCode::HTTP_TYPE_ERROR, false, "父评论不存在");
            }
        }
        if($articleRepository->findById($request->article_id)->comment_status!=='1'){
            return $this->Json("评论错误", null, HttpCode::HTTP_TYPE_ERROR, false, "该文章禁止评论");
        }
        $this->isKeyword = new Keyword();
        if (!$this->isKeyword->isKeyword($request->content)) {
            if ($commentRepository->create([
                'user_id' => auth('back_auth')->id(),
                'article_id' => $request->article_id,
                'parent_id' => $request->parent_id,
                'content' => $request->content,
                'user_mark' => 'back',
            ])) {
                return $this->Json("评论成功");
            }
            return $this->Json("评论失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json("评论错误", null, HttpCode::HTTP_TYPE_ERROR, false, "该评论含有违规字词,请重新输入");
    }

    /**
     * 获取评论列表
     * @param CommentRepository $repository
     * @return JsonResponse
     */
    public function getCommentList(CommentRepository $repository): JsonResponse
    {
        return $this->Json("ok",$repository->getCommentList());
    }

    /**
     * 删除评论
     * @param $request
     * @param CommentRepository $repository
     * @return JsonResponse
     */
    public function deleteComment($request,CommentRepository $repository): JsonResponse
    {
        if($repository->exists("id",$request->id)){
            $repository->delete($repository->getCommentIds($repository->findById($request->id)));
            return $this->Json("评论删除成功");
        }
        return $this->Json("评论删除错误错误", null, HttpCode::HTTP_TYPE_ERROR, false, "该评论不存在");
    }

    /**
     * 评论搜索
     * @param $request
     * @param CommentRepository $commentRepository
     * @param UserRepository $userRepository
     * @param AdminRepository $adminRepository
     * @return JsonResponse
     */
    public function searchComment($request,CommentRepository $commentRepository,UserRepository $userRepository,AdminRepository $adminRepository): JsonResponse
    {
        return $this->Json('ok',$commentRepository->searchComment($request->username,$request->usertype,$userRepository,$adminRepository));
    }
}
