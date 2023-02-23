<?php

namespace App\Http\Requests;

class BannerRequest extends BaseRequest
{
    protected $rules = [
        'add'=>[
            'url'=>['url','nullable'],
            'description'=>['string','nullable'],
            'img'=>['required','image','image_min:1','image_max:5120','mimes:jpeg,png,webp']
        ],
        'update'=>[
            'id'=>['integer', 'required'],
            'url'=>['url','nullable'],
            'description'=>['string','nullable'],
            'img'=>['image','image_min:1','image_max:5120','mimes:jpeg,png,webp']
        ],
        'banner'=>[
            'id'=>['integer', 'required']
        ],
        'delete'=>[
            'id'=>['integer','required']
        ]
    ];

    protected $rulesMsg = [
        'add'=>[
            'url'=>'链接',
            'description'=>'描述',
            'img'=>'图片'
        ],
        'update'=>[
            'id'=>'id',
            'url'=>'链接',
            'description'=>'描述',
            'img'=>'图片'
        ],
        'banner'=>[
            'id'=>'id'
        ],
        'delete'=>[
            'id'=>'id'
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
