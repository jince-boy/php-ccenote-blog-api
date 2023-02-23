<?php

namespace App\Http\Requests;

class RoleRequest extends BaseRequest
{
    protected $rules=[
        'role'=>[
            'id'=>['integer','required']
        ],
        'permission'=>[
            'id'=>['integer','required']
        ],
        'add'=>[
            'name'=>['max:191','string','required','unique:roles'],
            'description'=>['string','max:191','nullable'],
            'status'=>['min:0','max:1','required','integer'],
            'permissionIds'=>['array','required']
        ],
        'update'=>[
            'id'=>['integer','required'],
            'name'=>['max:191','string','required'],
            'description'=>['string','max:191','nullable'],
            'status'=>['min:0','max:1','required','integer'],
            'permissionIds'=>['array','required']
        ],
        'delete'=>[
            'ids'=>['array','required']
        ]

    ];
    protected $rulesMsg=[
        'role'=>[
            'id'=>'id'
        ],
        'permission'=>[
            'id'=>'id'
        ],
        'add'=>[
            'name'=>'角色名称',
            'description'=>'角色描述',
            'status'=>'角色状态',
            'permissionIds'=>'权限数组'
        ],
        'update'=>[
            'id'=>'id',
            'name'=>'角色名称',
            'description'=>'角色描述',
            'status'=>'角色状态',
            'permissionIds'=>'权限数组'
        ],
        'delete'=>[
            'ids'=>'id'
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
