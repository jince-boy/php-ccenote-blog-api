<?php

namespace App\Http\Requests;


class CategoryRequest extends BaseRequest
{
    protected $rules = [
        'category'=>[
            'id'=>['integer','required'],
        ],
        'add'=>[
            'name'=>['string','max:191','required','unique:categorys'],
            'description'=>['string','max:191','nullable'],
            'is_menu' => ['min:0', 'max:1', 'required', 'integer'],
            'order'=>['integer','nullable'],
            'icon' => ['string', 'max:191', 'nullable'],
            'parent_id' => ['nullable', 'integer']
        ],
        'update'=>[
            'id'=>['integer','required'],
            'name'=>['string','max:191','required'],
            'description'=>['string','max:191','nullable'],
            'is_menu' => ['min:0', 'max:1', 'required', 'integer'],
            'order'=>['integer','nullable'],
            'icon' => ['string', 'max:191', 'nullable'],
            'parent_id' => ['nullable', 'integer']
        ],
        'delete'=>[
            'ids'=>['array','required']
        ]
    ];

    protected $rulesMsg = [
        'category'=>[
            'id'=>'id',
        ],
        'add'=>[
            'name'=>'分类名称',
            'description'=>'分类描述',
            'is_menu'=>'是否为菜单',
            'order'=>'排序',
            'parent_id'=>'父分类id'
        ],
        'update'=>[
            'id'=>'id',
            'name'=>'分类名称',
            'description'=>'分类描述',
            'is_menu'=>'是否为菜单',
            'order'=>'排序',
            'parent_id'=>'父分类id'
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
