<?php

namespace App\Http\Requests;


class AvatarRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $rules=[
        'images'=>[
            'username'=>['string','required'],
            'type'=>['string'],
            'spec'=>['integer','required','min:120','max:640']
        ]
    ];
    /**
     * @var string[][]
     * 定义所有的字段的说明
     */
    protected $rulesMsg=[
        'images'=>[
            'username'=>'用户名',
            'type'=>'类型',
            'spec'=>'规格'
        ]
    ];
    protected $errorMsg=[
        'integer'=>'必须为数字',
        'required' => '不能为空',
        'min' => '最小为:min',
        'max' => '最大为:max',
        'string'=>'必须为字符串'
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
