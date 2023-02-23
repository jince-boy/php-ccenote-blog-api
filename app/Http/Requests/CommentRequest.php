<?php

namespace App\Http\Requests;


class CommentRequest extends BaseRequest
{
    protected $rules = [
        'getArticleCommentList'=>[
            'article_id'=>['integer','required']
        ],
        'search'=>[
            'username'=>['string','nullable'],
            'usertype'=>['string','required']
        ],
        'category'=>[
            'id'=>['integer','required'],
        ],
        'add'=>[
            'article_id'=>['integer','required'],
            'content'=>['string','required'],
            'parent_id' => ['nullable', 'integer']
        ],
        'update'=>[
            'id'=>['integer','required'],
            'name'=>['string','max:191','required'],
            'description'=>['string','max:191','nullable'],
            'is_menu' => ['min:0', 'max:1', 'required', 'integer'],
            'order'=>['integer','nullable'],
            'parent_id' => ['nullable', 'integer']
        ],
        'delete'=>[
            'id'=>['integer','required']
        ]
    ];

    protected $rulesMsg = [
        'getArticleCommentList'=>[
            'article_id'=>'文章id'
        ],
        'search'=>[
            'username'=>'用户名',
            'usertype'=>'用户类型'
        ],
        'category'=>[
            'id'=>'id',
        ],
        'add'=>[
            'article_id'=>'文章id',
            'content'=>'评论内容',
            'parent_id' => '评论父id'
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
