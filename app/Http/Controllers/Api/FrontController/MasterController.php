<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Services\FrontService\MasterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    /**
     * 获取博主信息
     * @param MasterService $service
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getMaster(MasterService $service, AdminRepository $repository): JsonResponse
    {
        return $service->getMaster($repository);
    }
}
