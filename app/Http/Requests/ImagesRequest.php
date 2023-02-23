<?php

namespace App\Http\Requests;


class ImagesRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $rules=[
        'updateAvatar'=>[
            'avatar'=>['required','image','image_min:1','image_max:280','mimes:jpeg,png,webp']
        ],
        'avatar'=>[
            'avatar'=>['required','image','image_min:1','image_max:280','mimes:jpeg,png,webp']
        ],
        'logo'=>[
            'logo'=>['required','image','image_min:1','image_max:1024','mimes:jpeg,png,webp']
        ]
    ];
    /**
     * @var string[][]
     * 定义所有的字段的说明
     */
    protected $rulesMsg=[
        'updateAvatar'=>[
            'avatar'=>'头像'
        ],
        'avatar'=>[
            'avatar'=>'头像'
        ],
        'logo'=>[
            'logo'=>'logo'
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
