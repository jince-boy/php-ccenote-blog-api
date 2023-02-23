<?php

namespace App\Http\Requests;


class AdminRequest extends BaseRequest
{
    /**
     * @var string[][]
     * 定义所有表单的验证规则
     */
    protected $rules=[
        'login'=>[
            'username'=>['required','min:6','max:255','string'],
            'password'=>['required','min:6','max:255','string'],
        ],
        'updatePassword'=>[
            'old_password'=>['required','min:6','max:255','string'],
            'new_password'=>['required','min:6','max:255','string']
        ],
        'update'=>[
            'name'=>['nullable','string'],
            'url'=>['url','nullable'],
            'profile'=>['string','nullable']
        ],
        'user'=>[
            'id'=>['integer','required']
        ],
        'add'=>[
            'username'=>['required','min:6','max:255','string','unique:admins'],
            'name'=>['nullable','string'],
            'url'=>['url','nullable'],
            'profile'=>['string','nullable'],
            'email'=>['required','min:6','max:255','string','email','unique:admins'],
            'password'=>['required','min:6','max:255','string'],
            'role_id'=>['integer','required'],
            'status'=>['min:0','max:1','required','integer']
        ],
        'data'=>[
            'id'=>['integer','required'],
            'username'=>['required','min:6','max:255','string'],
            'name'=>['nullable','string'],
            'url'=>['url','nullable'],
            'profile'=>['string','nullable'],
            'email'=>['required','min:6','max:255','string','email'],
            'password'=>['required','min:6','max:255','string'],
            'role_id'=>['integer','required'],
            'status'=>['min:0','max:1','required','integer'],
        ],
        'delete'=>[
            'ids'=>['array','required']
        ],
    ];
    /**
     * @var string[][]
     * 定义所有的字段的说明
     */
    protected $rulesMsg=[
        'login'=>[
            'username'=>'用户名或邮箱',
            'password'=>'密码',
            'code'=>'验证码'
        ],
        'updatePassword'=>[
            'old_password'=>'原密码',
            'new_password'=>'新密码'
        ],
        'update'=>[
            'name'=>'姓名',
            'url'=>'个人链接',
            'profile'=>'个人简介'
        ],
        'user'=>[
            'id'=>'id'
        ],
        'add'=>[
            'username'=>'用户名',
            'name'=>'名称',
            'email'=>'邮箱',
            'url'=>'个人链接',
            'profile'=>'个人简介',
            'password'=>'密码',
            'role_id'=>'角色',
            'status'=>'状态'
        ],
        'data'=>[
            'id'=>'id',
            'username'=>'用户名',
            'name'=>'名称',
            'url'=>'个人链接',
            'profile'=>'个人简介',
            'email'=>'邮箱',
            'password'=>'密码',
            'role_id'=>'角色',
            'status'=>'状态'
        ],
        'delete'=>[
            'ids'=>'id'
        ],

    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRules();
    }
}
