<?php
namespace App\Services\FrontService;
use App\Repositories\CategoryRepository;
use App\Repositories\ConfigRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

class ConfigService extends BaseService{

    /**
     * 网站配置信息
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function getWebConfig(ConfigRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->findById(1));
    }

    /**
     * 获取菜单
     * @param CategoryRepository $repository
     * @return JsonResponse
     */
    public function getMenu(CategoryRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->toMenu());
    }

}
