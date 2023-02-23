<?php

namespace App\Services\FrontService;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use App\Utils\Keyword;
use Illuminate\Http\JsonResponse;

class CommentService extends BaseService
{

    public $isKeyword;

    /**
     * 前台添加评论
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
                'user_id' => auth('front_auth')->id(),
                'article_id' => $request->article_id,
                'parent_id' => $request->parent_id,
                'content' => $request->content
            ])) {
                return $this->Json("评论成功");
            }
            return $this->Json("评论失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json("评论错误", null, HttpCode::HTTP_TYPE_ERROR, false, "该评论含有违规字词,请重新输入");
    }

    /**
     * 最新评论
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function newComment(CommentRepository $commentRepository): JsonResponse
    {
        return $this->Json('ok',$commentRepository->newCommentList());
    }

    /**
     * 评论列表
     * @param $request
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function CommentList($request,CommentRepository $commentRepository): JsonResponse
    {
        return $this->Json('ok',$commentRepository->getFrontArticleComments($request->article_id));
    }
}
