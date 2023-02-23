<?php

namespace App\Services\BackService;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class CategoryService extends BaseService
{

    /**
     * 获取分类列表
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getCategorysList(CategoryRepository $repository): JsonResponse
    {
        return $this->Json("ok", $repository->list());
    }

    /**
     * 获取分类详情
     * @param $request
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getCategory($request, CategoryRepository $repository): JsonResponse
    {
        if ($repository->exists('id', $request->id)) {
            return $this->Json("ok", $repository->findById($request->id));
        }
        return $this->Json("分类获取失败", null, HttpCode::HTTP_TYPE_ERROR, false, "分类id不存在");
    }

    /**
     * 添加分类
     * @param $request
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function addCategory($request, CategoryRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        if($request->parent_id!=null){
            if ($repository->exists('id', $request->parent_id)) {
                if ($repository->findById($request->parent_id)->parent_id != null) {
                    return $this->Json("分类添加失败", null, HttpCode::HTTP_TYPE_ERROR, false, "只允许为二级分类");
                }
                if($articleRepository->exists('category_id',$request->parent_id)){
                    return $this->Json("分类添加失败", null, HttpCode::HTTP_TYPE_ERROR, false, "当前一级分类下存在文章");
                }
            }else{
                return $this->Json("分类添加失败", null, HttpCode::HTTP_TYPE_ERROR, false, "父分类不存在");
            }
        }

        if ($repository->create($request->all())) {
            return $this->Json("分类添加成功");
        }
        return $this->Json("分类添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改分类
     * @param $request
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function updateCategory($request, CategoryRepository $repository,ArticleRepository $articleRepository): JsonResponse
    {
        if ($repository->exists('name', $request->name)) {
            if ($repository->findBy('name', $request->name)->id != $request->id) {
                return $this->Json("分类修改失败", null, HttpCode::HTTP_TYPE_ERROR, false, "分类名称已存在");
            }
        }
        if ($request->parent_id != null) {
            if (!$repository->exists('id', $request->parent_id)) {
                return $this->Json("分类修改失败", null, HttpCode::HTTP_TYPE_ERROR, false, "父分类不存在");
            }
            if ($repository->findById($request->parent_id)->parent_id != null) {
                return $this->Json("分类修改失败", null, HttpCode::HTTP_TYPE_ERROR, false, "只允许为二级分类");
            }
            if($articleRepository->exists('category_id',$request->parent_id)){
                return $this->Json("分类添加失败", null, HttpCode::HTTP_TYPE_ERROR, false, "当前一级分类下存在文章");
            }
        }
        if ($repository->update($request->id, $request->all())) {
            return $this->Json("分类修改成功");
        }
        return $this->Json("分类修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 删除分类
     * @param $request
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function deleteCategory($request, CategoryRepository $repository, ArticleRepository $articleRepository): JsonResponse
    {
        foreach ($request->ids as $id) {
            if($id==1){
                return $this->Json("分类删除失败", null, HttpCode::HTTP_TYPE_ERROR, false, "系统分类（未分类）不能删除");
            }
            if ($id == null) {
                return $this->Json("分类删除失败", null, HttpCode::HTTP_TYPE_ERROR, false, "ids数组不能为空");
            }
            if (!$repository->exists('id', $id)) {
                return $this->Json("分类删除失败", null, HttpCode::HTTP_TYPE_ERROR, false, "分类id不存在");
            }
            if ($articleRepository->exists('category_id', $id)) {
                return $this->Json("分类删除失败", null, HttpCode::HTTP_TYPE_ERROR, false, "当前分类下存在文章");
            }
        }
        foreach ($request->ids as $id) {
            $repository->delete($id);
        }
        return $this->Json("删除成功");
    }
}
