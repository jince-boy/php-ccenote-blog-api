<?php
namespace App\Repositories;


use App\Models\Categorys;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository{

    public function __construct(Categorys $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取分类列表
     * @return mixed
     */
    public function list(){
       return $this->model->list($this->all()->toArray());
    }

    /**
     * 获取分类中为菜单的数据
     * @return mixed
     */
    public function toMenu(){
        return $this->model->list($this->model::where('is_menu',1)->orderBy('order')->get()->toArray());
    }

    /**
     * 获取分类文章
     * @param $id
     * @return mixed
     */
    public function getCategoryArticle($id){
        $paginator=$this->findById($id)->Article()->orderBy("created_at","desc")->where('status',1)->paginate($this->frontPageNum());
        return $this->getPaginatorArticle($paginator);
    }

    /**
     * 此方法为封装单个文章内容
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
