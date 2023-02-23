<?php

namespace App\Services\BackService;

use App\Repositories\AdminRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class RoleService extends BaseService
{

    /**
     * 获取角色列表
     * @param RoleRepository $repository
     * @return JsonResponse
     */
    public function getRoleList(RoleRepository $repository): JsonResponse
    {
//        return $this->Json("ok", $repository->backPage());
        return $this->Json("ok",$repository->all());
    }

    /**
     * 获取角色详情
     * @param $request
     * @param RoleRepository $repository
     * @return JsonResponse
     */
    public function getRoleData($request, RoleRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->getRoleData($request->id));
    }

    //没有使用
    public function getRolePermission($id, RoleRepository $repository): JsonResponse
    {
        if ($repository->exists('id', $id)) {
            return $this->Json('ok', $repository->permission($id));
        }
        return $this->Json("角色权限获取失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "没有此角色");
    }

    /**
     * 添加角色
     * @param $request
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     * @return JsonResponse
     */
    public function addRole($request, RoleRepository $repository, PermissionRepository $permissionRepository): JsonResponse
    {
        if ($role = $repository->create($request->except('id'))) {
            $arr = array();
            foreach ($request->permissionIds as $value) {
                if ($permissionRepository->exists('id', $value)) {
                    $arr[] = $value;
                }
            }
            if ($repository->sync($role->id, $arr)) {
                return $this->Json("角色添加成功");
            }
        }
        return $this->Json("角色添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改角色
     * @param $request
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     * @return JsonResponse
     */
    public function updateRole($request, RoleRepository $repository, PermissionRepository $permissionRepository): JsonResponse
    {
        if ($role = $repository->findBy('name', $request->name)) {
            if ($role->id != $request->id) {
                return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, '角色名称以存在');
            }
        }
        if ($repository->update($request->id, $request->except('id'))) {
            $arr = array();
            foreach ($request->permissionIds as $value) {
                if ($permissionRepository->exists('id', $value)) {
                    $arr[] = $value;
                }
            }
            if ($repository->sync($request->id, $arr)) {
                return $this->Json("角色修改成功");
            }
        }
        return $this->Json("角色修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "没有此角色");
    }

    /**
     * 删除角色
     * @param $request
     * @param RoleRepository $repository
     * @param AdminRepository $userRepository
     * @return JsonResponse
     */
    public function deleteRole($request, RoleRepository $repository, AdminRepository $userRepository): JsonResponse
    {
        if (in_array(1, $request->ids) || in_array(2, $request->ids) || in_array(3, $request->ids)) {
            return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, '系统自带角色不允许删除');
        }
        foreach ($request->ids as $value) {
            if ($value == null) {
                return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, 'ids数组元素不能为null');
            }
            if ($repository->exists('id',$value)){
                return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, '角色id不存在');
            }
            if ($userRepository->exists('role_id', $value)) {
                return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, '需要删除的角色中包含了用户正在使用的角色');
            }
        }
        foreach ($request->ids as $value) {
            if ($repository->detach($value)) {
                $repository->delete($value);
            }
        }
        return $this->Json("角色删除成功");
    }
}
