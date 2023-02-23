<?php

namespace App\Services\BackService;

use App\Repositories\TagRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class TagService extends BaseService
{
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
     * 获取标签列表分页
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getTagsList(TagRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->backPage());
    }

    /**
     * 获取标签详情
     * @param $request
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getTag($request, TagRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->findById($request->id));
    }

    /**
     * 添加标签
     * @param $request
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function addTags($request, TagRepository $repository): JsonResponse
    {
        if ($tag = $repository->create(['name' => strtoupper($request->name)])) {
            return $this->Json('标签添加成功', $tag);
        }
        return $this->Json("标签添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, '服务器错误');
    }

    /**
     * 修改标签
     * @param $request
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function updateTags($request, TagRepository $repository): JsonResponse
    {
        if ($repository->exists('name', $request->name)) {
            if ($repository->findBy('name', $request->name)->id != $request->id) {
                return $this->Json("标签修改失败", null, HttpCode::HTTP_TYPE_ERROR, false, '标签名称以存在');
            }
        }
        if ($repository->update($request->id, ['name' => strtoupper($request->name)])) {
            return $this->Json('标签修改成功');
        }
        return $this->Json("标签修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, '服务器错误');
    }

    /**
     * 删除标签
     * @param $request
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function deleteTags($request, TagRepository $repository): JsonResponse
    {
        foreach ($request->ids as $value) {
            if ($repository->exists('id', $value)) {
                $repository->detach($value);
                $repository->delete($value);
            }
        }
        return $this->Json("标签删除成功");
    }
}
