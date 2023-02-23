<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Repositories\PartnerRepository;
use App\Services\BackService\PartnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * 友情链接列表
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function getPartnerList(PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->getPartnerList($repository);
    }

    /**
     * 获取友情链接
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function getPartner(PartnerRequest $request,PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->getPartner($request,$repository);
    }
    /**
     * 添加友情链接
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function addPartner(PartnerRequest $request,PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->addPartner($request,$repository);
    }

    /**
     * 修改友情链接
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function updatePartner(PartnerRequest $request,PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->updatePartner($request,$repository);
    }

    /**
     * 删除友情链接
     * @param PartnerRequest $request
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function deletePartner(PartnerRequest $request,PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->deletePartner($request,$repository);
    }
}
