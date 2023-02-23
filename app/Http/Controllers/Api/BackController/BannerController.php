<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Repositories\BannerRepository;
use App\Services\BackService\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * 获取Banner列表
     * @param BannerService $service
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function getBannerList(BannerService $service,BannerRepository $repository): JsonResponse
    {
        return $service->getBannerList($repository);
    }

    /**
     * 获取Banner信息
     * @param BannerRequest $request
     * @param BannerService $service
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function getBanner(BannerRequest $request,BannerService $service,BannerRepository $repository): JsonResponse
    {
        return $service->getBanner($request,$repository);
    }
    /**
     * 添加Banner
     * @param BannerRequest $request
     * @param BannerService $service
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function addBanner(BannerRequest $request,BannerService $service,BannerRepository $repository): JsonResponse
    {
        return $service->addBanner($request,$repository);
    }

    /**
     * 修改Banner
     * @param BannerRequest $request
     * @param BannerService $service
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function updateBanner(BannerRequest $request,BannerService $service,BannerRepository $repository): JsonResponse
    {
        return $service->updateBanner($request,$repository);
    }

    /**
     * 删除Banner
     * @param BannerRequest $request
     * @param BannerService $service
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function deleteBanner(BannerRequest $request,BannerService $service,BannerRepository $repository): JsonResponse
    {
        return $service->deleteBanner($request,$repository);
    }
}
