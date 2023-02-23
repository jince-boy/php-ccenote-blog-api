<?php

namespace App\Http\Requests;


class FileRequest extends BaseRequest
{
    protected $rules = [
        'file'=>[
            'type'=>['string','required'],
            'page'=>['integer','required']
        ],
        'set'=>[
            'keyword'=>['string','nullable'],
        ],
        'upload'=>[
            'file'=>['mimes:mp4,avi,jpeg,png,webp,zip,rar,doc,docx,xls,xlsx,txt,md','required']
        ],
        'delete'=>[
            'names'=>['array','required'],
            'type'=>['string','required']
        ]
    ];

    protected $rulesMsg = [
        'file'=>[
            'type'=>'文件类型',
            'page'=>'页码'
        ],
        'set'=>[
            'keyword'=>'评论关键字',
        ],
        'upload'=>[
            'file'=>'文件'
        ],
        'delete'=>[
            'names'=>'文件名数组',
            'type'=>'文件类型'
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
