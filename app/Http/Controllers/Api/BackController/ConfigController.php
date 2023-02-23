<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigRequest;
use App\Http\Requests\ImagesRequest;
use App\Repositories\ConfigRepository;
use App\Services\BackService\ConfigService;
use Illuminate\Http\JsonResponse;

class ConfigController extends Controller
{
    /**
     * 获取网站配置信息
     * 2022-8-26
     * @param ConfigService $configService
     * @param ConfigRepository $repository
     * @return JsonResponse
     */

    public function getConfig(ConfigService $configService,ConfigRepository $repository): JsonResponse
    {
        return $configService->getConfig($repository);
    }

    /**
     * 修改网站配置信息
     * 2022-8-26
     * @param ConfigRequest $request
     * @param ConfigService $configService
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function setConfig(ConfigRequest $request,ConfigService $configService,ConfigRepository $repository): JsonResponse
    {
        return $configService->setConfig($request,$repository);
    }

    /**
     * 设置网站logo
     * 2022-8-26
     * @param ImagesRequest $request
     * @param ConfigService $configService
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function setLogo(ImagesRequest $request,ConfigService $configService,ConfigRepository $repository): JsonResponse
    {
        return $configService->setLogo($request,$repository);
    }

    /**
     * 获取评论关键字
     * @param ConfigService $service
     * @return JsonResponse
     */
    public function getKeywords(ConfigService $service): JsonResponse
    {
        return $service->getKeywords();
    }

    /**
     * 设置评论关键字
     * @param ConfigRequest $request
     * @param ConfigService $service
     * @return JsonResponse
     */
    public function setKeyword(ConfigRequest $request,ConfigService $service): JsonResponse
    {
        return $service->setKeyword($request);
    }
}
