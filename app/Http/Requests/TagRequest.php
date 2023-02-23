<?php

namespace App\Http\Requests;


class TagRequest extends BaseRequest
{
    protected $rules = [
        'tag'=>[
            'id'=>['integer','required'],
        ],
        'add'=>[
            'name'=>['string','max:191','required','unique:tags']
        ],
        'update'=>[
            'id'=>['integer','required'],
            'name'=>['string','max:191','required']
        ],
        'delete'=>[
            'ids'=>['array','required']
        ]
    ];

    protected $rulesMsg = [
        'tag'=>[
            'id'=>'id',
        ],
        'add'=>[
            'name'=>'标签名称'
        ],
        'update'=>[
            'id'=>'id',
            'name'=>'标签名称'
        ],
        'delete'=>[
            'ids'=>'id数组'
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
