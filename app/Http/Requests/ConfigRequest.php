<?php

namespace App\Http\Requests;


class ConfigRequest extends BaseRequest
{
    protected $rules = [
        'update'=>[
            'title'=>['string','max:191','required'],
            'description'=>['string','max:191','nullable'],
            'keywords'=>['string','max:191','nullable'],
            'is_register'=>['required','integer','min:0', 'max:1'],
            'site_status'=>['required','integer','min:0','max:1'],
            'close_reason'=>['string','max:191','nullable'],
            'copyright'=>['string','max:191','nullable'],
            'record'=>['string','max:191','nullable'],
            'edition'=>['string','max:191','nullable'],
            'front_page_num'=>['required','integer'],
            'back_page_num'=>['required','integer'],
            'contact'=>['string','nullable','max:191'],
            'notice'=>['string','nullable','max:191'],
            'grey'=>['required','integer','min:0', 'max:1']
        ],
        'set'=>[
            'keyword'=>['string','nullable'],
        ]
    ];

    protected $rulesMsg = [
        'update'=>[
            'title'=>'网站标题',
            'description'=>'网站描述',
            'keywords'=>'网站关键字',
            'is_register'=>'注册状态',
            'site_status'=>'网站状态',
            'close_reason'=>'关闭理由',
            'copyright'=>'网站版权',
            'record'=>'备案信息',
            'edition'=>'网站版本',
            'front_page_num'=>'前端每页展示数量',
            'back_page_num'=>'后端每页展示数量',
            'contact'=>'联系方式',
            'notice'=>'网站公告',
            'grey'=>'网站变灰'
        ],
        'set'=>[
            'keyword'=>'评论关键字',
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
