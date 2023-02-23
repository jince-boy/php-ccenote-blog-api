<?php
namespace App\Services\FrontService;
use App\Repositories\ArticleRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

class ArticleService extends BaseService{

    /**
     * 获取热门文章
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function hotArticle(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->Json('ok',$articleRepository->getHotArticle());
    }

    /**
     * 获取文章列表
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function getArticleList(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->Json('ok',$articleRepository->getFrontArticleList('1'));
    }

    /**
     * 搜索文章
     * @param $request
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function searchFrontArticle($request,ArticleRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->searchFrontArticle($request->title));
    }

    /**
     * 获取文章详情
     * @param $request
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function getArticle($request,ArticleRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->getFrontArticle($request->id));
    }
}
