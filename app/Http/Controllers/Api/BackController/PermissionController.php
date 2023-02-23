<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use App\Services\BackService\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    /**
     * 获取权限列表
     * 2022-7-13
     * @param PermissionService $permissionService
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function getPermissionList(PermissionService $permissionService, PermissionRepository $repository): JsonResponse
    {
        return $permissionService->getPermissionList($repository);
    }

    /**
     * 获取权限信息
     * 2022-7-20
     * @param PermissionRequest $request
     * @param PermissionService $permissionService
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function getPermissionData(PermissionRequest $request,PermissionService $permissionService,PermissionRepository $repository): JsonResponse
    {
        return $permissionService->getPermissionData($request,$repository);
    }
    /**
     * 添加权限
     * 2022-7-13
     * @param PermissionRequest $request
     * @param PermissionService $permissionService
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function addPermission(PermissionRequest $request,PermissionService $permissionService,PermissionRepository $repository): JsonResponse
    {
        return $permissionService->addPermission($request,$repository);
    }

    /**
     * 修改权限
     * 2022-7-14
     * @param PermissionRequest $request
     * @param PermissionService $permissionService
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function updatePermission(PermissionRequest $request,PermissionService $permissionService,PermissionRepository $repository): JsonResponse
    {
        return $permissionService->updatePermission($request,$repository);
    }

    /**
     * 删除权限
     * 2022-7-14
     * @param PermissionRequest $request
     * @param PermissionService $permissionService
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function deletePermission(PermissionRequest $request,PermissionService $permissionService,PermissionRepository $repository): JsonResponse
    {
        return $permissionService->deletePermission($request,$repository);
    }
}
