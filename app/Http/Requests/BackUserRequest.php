<?php

namespace App\Http\Requests;


class BackUserRequest extends BaseRequest
{
    /**
     * @var string[][]
     * 定义所有表单的验证规则
     */
    protected $rules=[
        'search'=>[
            'username'=>['string','nullable'],
            'email'=>['string','nullable']
        ],
        'user'=>[
            'id'=>['integer','required']
        ],
        'add'=>[
            'username'=>['required','min:6','max:255','string','unique:users'],
            'name'=>['nullable','string'],
            'email'=>['required','min:6','max:255','string','email','unique:users'],
            'password'=>['required','min:6','max:255','string'],
            'url'=>['url','nullable'],
            'profile'=>['string','nullable'],
            'status'=>['min:0','max:1','required','integer']
        ],
        'update'=>[
            'id'=>['integer','required'],
            'password'=>['required','min:6','max:255','string'],
            'name'=>['nullable','string'],
            'url'=>['url','nullable'],
            'profile'=>['string','nullable'],
            'status'=>['min:0','max:1','required','integer']
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
        'search'=>[
            'username'=>'用户名',
            'email'=>'邮箱'
        ],
        'user'=>[
            'id'=>'id'
        ],
        'add'=>[
            'username'=>'用户名',
            'name'=>'名称',
            'email'=>'邮箱',
            'password'=>'密码',
            'url'=>'个人链接',
            'profile'=>'个人简介',
            'status'=>'状态'
        ],
        'update'=>[
            'password'=>'密码',
            'name'=>'姓名',
            'url'=>'个人链接',
            'profile'=>'个人简介',
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
