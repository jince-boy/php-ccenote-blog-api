<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use App\Services\FrontService\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * 获取标签列表
     * @param TagService $service
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function getTagList(TagService $service,TagRepository $tagRepository): JsonResponse
    {
        return $service->getAll($tagRepository);
    }

    /**
     * 获取文章标签
     * @param TagRequest $request
     * @param TagService $service
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function getTagArticle(TagRequest $request,TagService $service,TagRepository $tagRepository): JsonResponse
    {
        return $service->getTagArticle($request,$tagRepository);
    }
}
