<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use App\Services\BackService\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * 获取全部标签
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getAll(TagService $service,TagRepository $repository): JsonResponse
    {
        return $service->getAll($repository);
    }

    /**
     * 获取分页标签
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getTagsList(TagService $service, TagRepository $repository): JsonResponse
    {
        return $service->getTagsList($repository);
    }

    /**
     * 获取标签详情
     * @param TagRequest $request
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function getTag(TagRequest $request, TagService $service, TagRepository $repository): JsonResponse
    {
        return $service->getTag($request,$repository);
    }

    /**
     * 添加标签
     * @param TagRequest $request
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function addTags(TagRequest $request, TagService $service, TagRepository $repository): JsonResponse
    {
        return $service->addTags($request,$repository);
    }

    /**
     * 修改标签
     * @param TagRequest $request
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function updateTags(TagRequest $request,TagService $service,TagRepository $repository): JsonResponse
    {
        return $service->updateTags($request,$repository);
    }

    /**
     * 删除标签
     * @param TagRequest $request
     * @param TagService $service
     * @param TagRepository $repository
     * @return JsonResponse
     */
    public function deleteTags(TagRequest $request,TagService $service,TagRepository $repository): JsonResponse
    {
        return $service->deleteTags($request,$repository);
    }
}
