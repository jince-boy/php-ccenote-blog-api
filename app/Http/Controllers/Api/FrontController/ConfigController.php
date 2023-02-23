<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ConfigRepository;
use App\Services\FrontService\ConfigService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * 获取网站配置
     * @param ConfigService $service
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function getWebConfig(ConfigService $service,ConfigRepository $repository): JsonResponse
    {
        return $service->getWebConfig($repository);
    }

    /**
     * 获取菜单
     * @param ConfigService $service
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getMenu(ConfigService $service,CategoryRepository $repository): JsonResponse
    {
        return $service->getMenu($repository);
    }
}
