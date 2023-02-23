<?php
namespace App\Services\FrontService;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

class CountService extends BaseService{

    /**
     * 获取前台网站统计信息
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function getCount(ArticleRepository $articleRepository,CategoryRepository $categoryRepository,TagRepository $tagRepository,CommentRepository $commentRepository): JsonResponse
    {
        $data=[];
        $data['article_num']=$articleRepository->getCount();
        $data['views_num']=$articleRepository->all()->sum('page_views');
        $data['category_num']=$categoryRepository->getCount();
        $data['tag_num']=$tagRepository->getCount();
        $data['comment_num']=$commentRepository->getCount();
        return $this->Json('ok',$data);
    }

}
