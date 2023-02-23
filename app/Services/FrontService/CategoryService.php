<?php
namespace App\Services\FrontService;
use App\Repositories\CategoryRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class CategoryService extends BaseService{
    /**
     * 获取分类下的文章
     * @param $request
     * @param CategoryRepository $categoryRepository
     * @return JsonResponse
     */
    public function getCategoryArticle($request,CategoryRepository $categoryRepository): JsonResponse
    {
        if($categoryRepository->exists('id',$request->id)){
            return $this->Json('ok',$categoryRepository->getCategoryArticle($request->id));
        }
        return $this->Json('分类id不存在',null,false,HttpCode::HTTP_TYPE_ERROR,'分类id不存在');
    }
}
