<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Repositories\PartnerRepository;
use App\Services\BackService\PartnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * 获取友情链接列表
     * @param PartnerService $service
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function getPartnerList(PartnerService $service,PartnerRepository $repository): JsonResponse
    {
        return $service->getPartnerList($repository);
    }
}
