<?php

namespace App\Http\Requests;


class PermissionRequest extends BaseRequest
{
    protected $rules = [
        'permission' => [
            'id' => ['integer', 'required']
        ],
        'add' => [
            'name' => ['max:191', 'string', 'required', 'unique:permissions'],
            'is_menu' => ['min:0', 'max:1', 'required', 'integer'],
            'order'=>['integer','nullable'],
            'front_router' => ['max:191', 'string', 'nullable','unique:permissions'],
            'alias'=>['max:191','string','nullable','unique:permissions'],
            'template_address'=>['max:191','string','nullable'],
            'back_api' => ['max:191', 'string', 'nullable','unique:permissions'],
            'description' => ['string', 'max:191', 'nullable'],
            'icon' => ['string', 'max:191', 'nullable'],
            'parent_id' => ['nullable', 'integer'],
            'status' => ['min:0', 'max:1', 'required', 'integer']
        ],
        'update' => [
            'id' => ['integer', 'required'],
            'name' => ['max:191', 'string', 'required'],
            'is_menu' => ['min:0', 'max:1', 'required', 'integer'],
            'order'=>['integer','nullable'],
            'front_router' => ['max:191', 'string', 'nullable'],
            'alias'=>['max:191','string','nullable'],
            'template_address'=>['max:191','string','nullable'],
            'back_api' => ['max:191', 'string', 'nullable'],
            'description' => ['string', 'max:191', 'nullable'],
            'icon' => ['string', 'max:191', 'nullable'],
            'parent_id' => ['nullable', 'integer'],
            'status' => ['min:0', 'max:1', 'required', 'integer']
        ],
        'delete' => [
            'ids' => ['array', 'required']
        ]
    ];
    protected $rulesMsg = [
        'permission' => [
            'id' => 'id'
        ],
        'add' => [
            'name' => '权限名称',
            'is_menu' => '是否菜单',
            'order'=>'排序标识',
            'front_router' => '前端路由',
            'alias'=>'前端路由别名',
            'template_address'=>'路由模板',
            'back_api' => '后端api',
            'description' => '权限描述',
            'icon' => "菜单图标",
            'parent_id' => '父id',
            'status' => '权限状态'
        ],
        'update' => [
            'id' => 'id',
            'name' => '权限名称',
            'is_menu' => '是否菜单',
            'order'=>'排序标识',
            'front_router' => '前端路由',
            'alias'=>'前端路由别名',
            'template_address'=>'路由模板',
            'back_api' => '后端api',
            'description' => '权限描述',
            'icon' => "菜单图标",
            'parent_id' => '父id',
            'status' => '权限状态'
        ],
        'delete' => [
            'ids' => 'id'
        ]
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRules();
    }
}
