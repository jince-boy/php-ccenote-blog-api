<?php

namespace App\Services\BackService;

use App\Repositories\PermissionRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;

class PermissionService extends BaseService
{

    /**
     * 获取权限列表
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function getPermissionList(PermissionRepository $repository): JsonResponse
    {
        return $this->Json("ok", $repository->getPermission());
    }

    /**
     * 获取权限详情
     * @param $request
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function getPermissionData($request, PermissionRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->findById($request->id));
    }

    /**
     * 添加权限
     * @param $request
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function addPermission($request, PermissionRepository $repository): JsonResponse
    {
        if($request->parent_id&&$request->is_menu==1){
                if($repository->findById($request->parent_id)->parent_id==null){
                    if ($repository->create($request->except('id'))) {
                        return $this->Json("权限添加成功");
                    }
                }else{
                    return $this->Json('权限添加失败',null,HttpCode::HTTP_TYPE_ERROR,false,'权限菜单添加失败，上级菜单parent_id以存在');
                }
        }
        if ($repository->create($request->except('id'))) {
            return $this->Json("权限添加成功");
        }
        return $this->Json("权限添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改权限
     * @param $request
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function updatePermission($request, PermissionRepository $repository): JsonResponse
    {
        if ($permission = $repository->findBy('name', $request->name)) {
            if ($permission->id != $request->id) {
                return $this->fieldIsExists('权限名称');
            }
        }
        if ($permission = $repository->findBy('front_router', $request->front_router)) {
            if ($permission->id != $request->id) {
                return $this->fieldIsExists('前端路由');
            }
        }
        if ($permission = $repository->findBy('alias', $request->alias)) {
            if ($permission->id != $request->id) {
                return $this->fieldIsExists('路由别名');
            }
        }
        if ($permission = $repository->findBy('template_address', $request->template_address)) {
            if ($permission->id != $request->id) {
                return $this->fieldIsExists('路由模板');
            }
        }
        if($request->parent_id&&$request->is_menu==1){
            if($request->parent_id==$request->id){
                return $this->Json('权限添加失败',null,HttpCode::HTTP_TYPE_ERROR,false,'父级不能是自己');
            }
            if($repository->findById($request->parent_id)->parent_id==null){
                if ($repository->update($request->id, $request->except('id'))) {
                    return $this->Json("权限修改成功");
                }
            }else{
                return $this->Json('权限添加失败',null,HttpCode::HTTP_TYPE_ERROR,false,'权限菜单添加失败，上级菜单parent_id以存在');
            }
        }
        if ($repository->update($request->id, $request->except('id'))) {
            return $this->Json("权限修改成功");
        }
        return $this->Json("权限修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "没有此权限");
    }

    /**
     * 此方法定义返回数据
     * @param $name
     * @return JsonResponse
     */
    public function fieldIsExists($name)
    {
        return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, $name.'以存在');
    }

    /**
     * 删除权限
     * @param $request
     * @param PermissionRepository $repository
     * @return JsonResponse
     */
    public function deletePermission($request, PermissionRepository $repository): JsonResponse
    {
        foreach($request->ids as $value){
            $repository->findByAll('parent_id',$value)->update(['parent_id'=>null]);
            $repository->detach($value);
            $repository->delete($value);
        }
        return $this->Json("权限删除成功");
    }
}
