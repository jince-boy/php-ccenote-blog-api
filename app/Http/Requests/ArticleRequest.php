<?php

namespace App\Http\Requests;

class ArticleRequest extends BaseRequest
{
    protected $rules = [
        'list'=>[
            'status'=>['integer','required']
        ],
        'article'=>[
            'id'=>['integer','required'],
        ],
        'add'=>[
            'title'=>['string','max:191','required'],
            'content'=>['string','required'],
            'date'=>['date_format:Y-m-d H:i:s','required'],
            'status'=>['min:0','max:1','required','integer'],
            'comment_status'=>['min:0','max:1','required','integer'],
            'is_top'=>['min:0','max:1','required','integer'],
            'keywords'=>['string','nullable'],
            'description'=>['string','nullable'],
            'category_id'=>['min:1','integer','nullable'],
            'tags'=>['array','required'],
            'cover'=>['image','mimes:jpeg,png,webp','image_min:1','image_max:600','nullable']
        ],
        'update'=>[
            'id'=>['required','integer'],
            'title'=>['string','max:191','required'],
            'content'=>['string','required'],
            'date'=>['date_format:Y-m-d H:i:s','required'],
            'status'=>['min:0','max:1','required','integer'],
            'comment_status'=>['min:0','max:1','required','integer'],
            'is_top'=>['min:0','max:1','required','integer'],
            'keywords'=>['string','nullable'],
            'description'=>['string','nullable'],
            'category_id'=>['min:1','integer','nullable'],
            'tags'=>['array','required'],
            'cover'=>['image','mimes:jpeg,png,webp','image_min:1','image_max:600','nullable']
        ],
        'add_image'=>[
            'img'=>['image','mimes:jpeg,png,webp','image_min:1','image_max:1024']
        ],
        'add_video'=>[
            'video'=>['mimes:mp4,avi','video_min:1','video_max:6144']
        ],
        'delete'=>[
            'ids'=>['array','required']
        ],
        'search'=>[
            'title'=>['string','nullable']
        ]
    ];

    protected $rulesMsg = [
        'list'=>[
            'status'=>'文章状态'
        ],
        'article'=>[
            'id'=>'id',
        ],
        'add'=>[
            'cover'=>'文章图片',
            'title'=>'文章标题',
            'content'=>'文章内容',
            'date'=>'文章日期',
            'status'=>'文章状态',
            'comment_status'=>'文章评论状态',
            'is_top'=>'是否置顶',
            'keywords'=>'文章关键字',
            'description'=>'文章描述',
            'category_id'=>'分类id',
            'tags'=>'标签ids'
        ],
        'update'=>[
            'id'=>'id',
            'cover'=>'文章图片',
            'title'=>'文章标题',
            'content'=>'文章内容',
            'date'=>'文章日期',
            'status'=>'文章状态',
            'comment_status'=>'文章评论状态',
            'is_top'=>'是否置顶',
            'keywords'=>'文章关键字',
            'description'=>'文章描述',
            'category_id'=>'分类id',
            'tags'=>'标签ids'
        ],
        'add_image'=>[
            'img'=>'文章图片'
        ],
        'add_video'=>[
            'video'=>'文章视频'
        ],
        'delete'=>[
            'ids'=>'id数组'
        ],
        'search'=>[
            'title'=>'搜索名称'
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
