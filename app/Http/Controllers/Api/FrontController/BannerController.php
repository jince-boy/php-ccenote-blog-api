<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use App\Services\BackService\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * 获取banner列表
     * @param BannerService $bannerService
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function getList(BannerService $bannerService,BannerRepository $repository): JsonResponse
    {
        return $bannerService->getBannerList($repository);
    }
}
