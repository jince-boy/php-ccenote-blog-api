<?php

namespace App\Http\Requests;


class UserRequest extends BaseRequest
{
    /**
     * @var string[][]
     * 定义所有表单的验证规则
     */
    protected $rules=[
        'register'=>[
            'username'=>['required','min:6','max:255','string','unique:users'],
            'email'=>['required','min:6','max:255','string','email','unique:users'],
            'password'=>['required','min:6','max:255','string'],
            'code'=>['required']
        ],
        'getMailCode'=>[
            'email'=>['required','min:6','max:255','string','email'],
            'type'=>['required']
        ],
        'login'=>[
            'username'=>['required','min:6','max:255','string'],
            'password'=>['required','min:6','max:255','string'],
        ],
        'resetPassword'=>[
            'email'=>['required','min:6','max:255','string','email'],
            'code'=>['required'],
            'password'=>['required','min:6','max:255','string']
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
            'username'=>['string','required'],
            'type'=>['string','required']
        ]
    ];
    /**
     * @var string[][]
     * 定义所有的字段的说明
     */
    protected $rulesMsg=[
      'register'=>[
          'username'=>'用户名',
          'email'=>'邮箱',
          'password'=>'密码',
          'code'=>'验证码'
        ],
        'getMailCode'=>[
            'email'=>'邮箱',
            'type'=>'验证码类型'
        ],
        'login'=>[
            'username'=>'用户名或邮箱',
            'password'=>'密码',
            'code'=>'验证码'
        ],
        'resetPassword'=>[
            'email'=>'邮箱',
            'code'=>'验证码',
            'password'=>'新密码'
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
            'username'=>'用户名',
            'type'=>'用户类型'
        ]
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
