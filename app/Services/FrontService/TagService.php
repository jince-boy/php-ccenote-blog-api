<?php
namespace App\Services\FrontService;
use App\Repositories\TagRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class TagService extends BaseService{

    /**
     * 获取全部标签
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getAll(TagRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->all());
    }

    /**
     * 获取文章标签
     * @param $request
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getTagArticle($request,TagRepository $repository): JsonResponse
    {
        if($repository->exists('id',$request->id)){
            return $this->Json('ok',$repository->getTagArticle($request->id));
        }
        return $this->Json('分类id不存在',null,false,HttpCode::HTTP_TYPE_ERROR,'分类id不存在');
    }

}
