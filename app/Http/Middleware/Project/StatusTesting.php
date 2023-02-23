<?php

namespace App\Http\Middleware\Project;

use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Traits\HttpCode;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 此中间件用于判断用户，接口等本身状态信息来给对应的请求拒绝或接受
 */
class StatusTesting extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public $roleRepository;
    public $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        if (auth('back_auth')->user()!=null){
            if ($role_id = auth('back_auth')->user()->role_id) {
                if ($this->roleRepository->findBy('id', $role_id)->status == 0) {
                    return $this->Json("接口访问失败，此用户角色以被禁用", null, HttpCode::HTTP_BAN_REGISTER, false, "此用户角色以被禁用");
                }
            }
            $route = explode('api', $request->url())[1];
            if ($this->permissionRepository->exists('back_api', $route)) {
                if ($this->permissionRepository->findBy('back_api',$route)->status==0){
                    return $this->Json("接口访问失败，此接口以被禁用", null, HttpCode::HTTP_BAN_REGISTER, false, "此接口以被禁用");
                }
            }
            return $next($request);
        }
        return $this->Json("用户未登录", null, HttpCode::HTTP_BAN_REGISTER, false, "token失效或无效");
    }
}
