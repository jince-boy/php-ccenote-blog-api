<?php

namespace App\Repositories;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\HigherOrderTapProxy;

class RoleRepository extends BaseRepository
{
    public function __construct(Roles $model)
    {
        parent::__construct($model);
    }

    /**
     * 给角色赋权限
     * @param int $id
     * @param array $permission
     * @return mixed
     */
    public function sync(int $id, array $permission)
    {
        return $this->findById($id)->Permissions()->sync($permission);
    }

    /**
     * 删除角色关联的权限
     * @param int $id
     * @param $permissionIds
     * @return mixed
     */
    public function detach(int $id, $permissionIds = null)
    {
        return $this->findById($id)->Permissions()->detach($permissionIds);
    }

    /**
     * 获取角色详情
     * @param int $id
     * @return HigherOrderTapProxy|mixed
     */
    public function getRoleData(int $id){

        return tap($this->model::where('id',$id)->with('permissions')->first()->makeHidden(['permissions']),function($contact){
            $permissionIds=[];
            foreach($contact->permissions->toArray() as $value){
                $permissionIds[] = $value['id'];
            }
            $contact->permissionIds=$permissionIds;
            return $contact;
        });
    }

    /**
     * 判断是否有权限
     * @param $id
     * @param $route
     * @return bool
     */
    public function isPermission($id,$route): bool
    {
        return $this->findById($id)->permissions()->where('back_api', $route)->first()?true:false;
    }

    /**
     * 用于生成权限列表（未使用）
     * 2022-7-20
     */
    public function permission(int $id)
    {
        $permission = Permissions::select(['id', 'name', 'parent_id'])->get()->toArray();
        $havePermission = $this->findById($id)->Permissions()->get(['permissions.id', 'name', 'parent_id'])->toArray();
        foreach ($permission as $key => $value) {
            $permission[$key]['have'] = false;
            foreach ($havePermission as $haveValue) {
                if ($value['id']==$haveValue['id']) {
                    $permission[$key]['have'] = true;
                }
            }
        }
        return $this->model->list($permission);
    }

    /**
     * 获取菜单
     * 2022-8-15
     */
    public function getMenu(int $roleId){
        return $this->model->list($this->findById($roleId)->Permissions()->where('is_menu',1)->where('status',1)->orderBy('order')->get()->makeHidden(['is_menu'])->toArray());
    }
}
