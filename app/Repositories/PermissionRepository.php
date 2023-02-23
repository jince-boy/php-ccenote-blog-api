<?php
namespace App\Repositories;

use App\Models\Permissions;

class PermissionRepository extends BaseRepository{

    public function __construct(Permissions $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取权限列表
     * @return mixed
     */
    public function getPermission(){
        return $this->model->list($this->model->orderBy('order')->get()->toArray());
    }

    /**
     * 删除用户关联权限
     * @param int $id
     * @param $rolesId
     * @return mixed
     */
    public function detach(int $id, $rolesId = null){
        return $this->findById($id)->roles()->detach($rolesId);
    }
}
