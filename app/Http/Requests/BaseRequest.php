<?php

namespace App\Http\Requests;

use App\Traits\HttpCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * 此类为自定义表单验证类的基类
 * 由于自定义表单认证中很多错误信息是相同的
 * 所以将共有的错误信息定义在了一个数组中，
 * 通过遍历索引来获取每个表单验证类中的字段的要求与基类中的错误信息相拼接
 */
class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return false;
    }

    /**
     * @var string[]
     * 规则错误信息
     */
    protected $errorMsg = [
        'required' => '不能为空',
        'min' => '最少字符为:min',
        'max' => '最大字符为:max',
        'string' => '必须为字符串格式',
        'unique' => '以存在',
        'json' => '不是有效得json格式',
        'array' => '必须是数组格式',
        'between' => '长度必须在:min和:max之间',
        'integer' => '必须为整型',
        'email' => '格式不正确',
        'url' => '格式不正确',
        'nullable' => '可为空',
        'date_format' => '格式不正确',
        'boolean' => '必须为布尔值',
        'mobile'=>'手机号格式不对',
        'image_min'=>'文件最小为:image_min'.'kb',
        'image_max'=>'文件最大为:image_max'.'kb',
        'video_min'=>'文件最小为:video_min'.'kb',
        'video_max'=>'文件最大为:video_max'.'kb',
        'mimes'=>'格式不正确',
        'image'=>'不正确',

    ];
    /**
     * @var array
     * 验证规则
     */
    protected $rules = [];
    /**
     * @var array
     * 验证规则字段名
     */
    protected $rulesMsg = [];

    /**
     * @return string
     * 获取最后一节路径
     * 如：/api/v1/user/login
     * 获取login
     */
    private function getLastPath(): string
    {
        $pathArray = explode("/", static::path());
        return $pathArray[sizeof($pathArray) - 1];
    }

    /**
     * @return mixed
     * 获取当前需要用到的验证规则
     */
    protected function getRules()
    {
        return $this->rules[$this->getLastPath()];
    }

    /**
     * @return array
     * 定义错误信息
     * 使用规则字段名和规则与规则错误信息来生成当前使用的字段中的错误提示信息
     */
    public function messages()
    {
        $messageArray = [];
        foreach ($this->rules[$this->getLastPath()] as $key => $value) {
            foreach ($this->getRules()[$key] as $v) {
                $name = array_key_exists($key, $this->rulesMsg[$this->getLastPath()]) == 1 ? $this->rulesMsg[$this->getLastPath()][$key] : "";
                $messageArray[$key . '.' . explode(':', $v)[0]] = $name . $this->errorMsg[explode(':', $v)[0]];
            }
        }
        return $messageArray;
    }

    /**
     * @param Validator $validator
     * @return void
     * 重写父类的failedValidation方法
     * 错误信息提示json格式的信息
     */
    protected function failedValidation(Validator $validator)
    {
//        单个错误
//        $error=$validator->errors()->first();
//        所有错误
        $error = $validator->errors()->all();
        $errors = implode(',', $error);
        throw (new HttpResponseException(response()->json([
            'code' => HttpCode::HTTP_TYPE_ERROR,
            'message' => '字段错误',
            'status' => false,
//            具体错误
//            'errors' => $validator->errors()
            'error'=>$errors
        ], 200)));
    }
}
