<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\AdminRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Services\BackService\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * 获取角色列表
     * 2022-7-14
     * @param RoleService $roleService
     * @param RoleRepository $repository
     * @return JsonResponse
     */
    public function getRoleList(RoleService $roleService,RoleRepository $repository): JsonResponse
    {
        return $roleService->getRoleList($repository);
    }

    /**
     * 获取角色详情
     * @param RoleRequest $request
     * @param RoleService $roleService
     * @param RoleRepository $repository
     * @return JsonResponse
     */
    public function getRoleData(RoleRequest $request,RoleService $roleService,RoleRepository $repository): JsonResponse
    {
        return $roleService->getRoleData($request,$repository);
    }
    /**
     * 添加角色
     * 2022-7-14
     * @param RoleRequest $request
     * @param RoleService $roleService
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     * @return JsonResponse
     */
    public function addRole(RoleRequest $request,RoleService $roleService,RoleRepository $repository,PermissionRepository $permissionRepository): JsonResponse
    {
        return $roleService->addRole($request,$repository,$permissionRepository);
    }

    /**
     * 修改角色
     * 2022-7-14
     * @param RoleRequest $request
     * @param RoleService $roleService
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     * @return JsonResponse
     */
    public function updateRole(RoleRequest $request,RoleService $roleService,RoleRepository $repository,PermissionRepository $permissionRepository): JsonResponse
    {
        return $roleService->updateRole($request,$repository,$permissionRepository);
    }

    /**
     * 删除角色
     * 2022-7-14
     * @param RoleRequest $request
     * @param RoleService $roleService
     * @param RoleRepository $repository
     * @param AdminRepository $userRepository
     * @return JsonResponse
     */
    public function deleteRole(RoleRequest $request, RoleService $roleService, RoleRepository $repository, AdminRepository $userRepository): JsonResponse
    {
        return $roleService->deleteRole($request,$repository,$userRepository);
    }
}
