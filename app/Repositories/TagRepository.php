<?php
namespace App\Repositories;


use App\Models\Tags;
use Illuminate\Support\Str;

class TagRepository extends BaseRepository{

    public function __construct(Tags $model)
    {
        parent::__construct($model);
    }

    /**
     * 删除标签与文章的中间表数据
     * @param int $id
     * @param $articles_id
     * @return mixed
     */
    public function detach(int $id,$articles_id=null){
        return $this->findById($id)->articles()->detach($articles_id);
    }

    /**
     * 获取标签文章
     * @param $id
     * @return mixed
     */
    public function getTagArticle($id){
        $paginator=$this->findById($id)->articles()->orderBy("created_at","desc")->where('status',1)->paginate($this->frontPageNum());
        return $this->getPaginatorArticle($paginator);
    }

    /**
     * 获取文章分页
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
