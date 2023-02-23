<?php

namespace App\Repositories;


use App\Models\Articles;
use Illuminate\Support\HigherOrderTapProxy;
use Illuminate\Support\Str;

class ArticleRepository extends BaseRepository
{

    public function __construct(Articles $model)
    {
        parent::__construct($model);
    }

    /**
     * 后端获取文章列表
     * @param $status
     * @return mixed
     */
    public function getArticleList($status)
    {
        $paginator=$this->model->orderBy("is_top")->orderBy("created_at","desc")->where("status",$status)->paginate($this->backPageNum());
        return $this->getPaginatorArticle($paginator);
    }

    /**
     * 前台获取文章列表
     * @param $status
     * @return mixed
     */
    public function getFrontArticleList($status){
        $paginator=$this->model->orderBy("is_top")->orderBy("created_at","desc")->where("status",$status)->paginate($this->frontPageNum());
        return $this->getPaginatorArticle($paginator);
    }

    /**
     * 获取文章信息
     * @param $id
     * @return mixed
     */
    public function getArticle($id)
    {
        $article=$this->findById($id)->makeHidden(['categorys','admins','created_at','updated_at','page_views','admin_id'])->toArray();
        $tags=[];
        foreach ($article['tags'] as $value){
            $tags[]=$value['name'];
        }
        $article['tags']=$tags;
        return $article;
    }

    /**
     * 获取前台文章详情
     * @param $id
     * @return HigherOrderTapProxy|mixed
     */
    public function getFrontArticle($id){
        $this->model::find($id)->increment('page_views');
        return tap($this->model::with(['comments'])->find($id)->makeHidden(['category_id','categorys','admins','created_at','updated_at','admin_id','tags','comment_status','comments']),function($contact){
            $contact->author=$contact->admins->name;
            $contact->category=$contact->categorys->name;
            $contact->comment_num=$contact->comments->count();
            $tags=[];
            foreach ($contact->tags as $value) {
                $tags[]=["id"=>$value->id,'name'=>$value->name];
            }
            $contact->tag=$tags;
            return $contact;
        });
    }
    /**
     * 获取热门文章
     * @return mixed
     */
    public function getHotArticle(){
        return $this->model->orderBy('page_views','desc')->take(5)->get()->map(function($contact){
            $data=[];
            $data['id']=$contact->id;
            $data['title']=$contact->title;
            $data['cover']=$contact->cover;
            $data['page_views']=$contact->page_views;
            $data['author']=$contact->admins->name;
            return $data;
        });
    }

    /**
     * 添加文章
     * @param array $data
     * @return bool
     */
    public function addArticle(array $data): bool
    {
        if ($article = $this->create($data)) {
            $this->sync($article->id, $data['tags']);
            return true;
        }
        return false;
    }

    /**
     * 修改文章
     * @param array $data
     * @return bool
     */
    public function updateArticle(array $data): bool
    {
        if ($this->update($data['id'],$data)) {
            $this->sync($data['id'], $data['tags']);
            return true;
        }
        return false;
    }

    /**
     * 删除文章关联tag
     * @param int $id
     * @param $tags
     * @return mixed
     */
    public function detach(int $id, $tags = null)
    {
        return $this->findById($id)->Tags()->detach($tags);
    }

    /**
     * 添加文章关联tag
     * @param int $id
     * @param array $tags
     * @return void
     */
    public function sync(int $id, array $tags)
    {
        $this->findById($id)->Tags()->sync($tags);
    }

    /**
     * 搜索文章
     * @param $title
     * @return mixed
     */
    public function searchArticle($title){
        $paginator=$this->model::where('title','like','%'.$title.'%')->where('status','1')->paginate($this->backPageNum());
        return $this->getPaginatorArticle($paginator);
    }
    public function searchFrontArticle($title){
        $paginator=$this->model::where('title','like','%'.$title.'%')->where('status','1')->paginate($this->frontPageNum());
        return $this->getPaginatorArticle($paginator);
    }
    /**
     * 获取文章列表分页
     * @param $paginator
     * @return mixed
     */
    public function getPaginatorArticle($paginator): mixed
    {
        $data = $paginator->makeHidden(['password', 'created_at', 'updated_at','keywords', 'description', 'categorys', 'category_id', 'admins', 'admin_id', 'date','tags','comments'])->map(function ($contact) {
            $contact->author = $contact->admins->name;
            $contact->content=Str::limit(strip_tags($contact->content));
            $contact->category = $contact->categorys->name;
            $contact->create_time = $contact->created_at->format('Y-m-d');
            $contact->commentCount=$contact->comments->count();
            return $contact;
        });
        $paginator->data = $data;
        return $paginator;
    }
}
