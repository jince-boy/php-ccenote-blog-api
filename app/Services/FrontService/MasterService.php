<?php
namespace App\Services\FrontService;
use App\Repositories\AdminRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

class MasterService extends BaseService{

    /**
     * 获取站长信息
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getMaster(AdminRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->findById(1)->makeHidden(['token','password','username','status','roles','created_at','updated_at','role_id','id']));
    }

}
