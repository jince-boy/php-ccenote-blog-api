<?php

namespace App\Http\Middleware\Project;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\AdminRepository;
use App\Traits\HttpCode;
use Closure;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 此中间件用于校验用户是否有有效的权限来访问角色对应的接口
 */
class Permission extends BaseMiddleware
{
    public $userRepository;
    public $permissionRepository;
    public $roleRepository;

    public function __construct(AdminRepository $userRepository, PermissionRepository $permissionRepository, RoleRepository $roleRepository)
    {
        $this->userRepository=$userRepository;
        $this->permissionRepository=$permissionRepository;
        $this->roleRepository=$roleRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route=explode('api',$request->url())[1];
        if(!$this->permissionRepository->exists('back_api',$route)){
            return $next($request);
        }
//        存在的话
        $roleId=auth('back_auth')->user()->roles->id;
        $permission_exists=$this->Json($this->roleRepository->isPermission($roleId,$route))->original['message'];
        if($permission_exists){
            return $next($request);
        }
         return $this->Json('用户没有权限',null,HttpCode::HTTP_PERMISSION_ERROR,false,'用户没有访问此接口的权限');

    }
}
