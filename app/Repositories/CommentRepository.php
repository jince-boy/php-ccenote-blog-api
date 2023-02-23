<?php

namespace App\Repositories;


use App\Models\Comments;

class CommentRepository extends BaseRepository
{

    public function __construct(Comments $model)
    {
        parent::__construct($model);
    }

    /**
     * 删除文章关联的评论
     * @param $id
     * @return void
     */
    public function ArticleDetachComment($id)
    {
        $this->model::where('article_id', $id)->delete();
    }

    /**
     * 删除用户关联的评论
     * @param $id
     * @return void
     */
    public function AdminDetachComment($id)
    {
        $this->model::where('user_mark', 'back')->where('user_id', $id)->delete();
    }

    /**
     * 删除用户关联的评论
     * @param $id
     * @return void
     */
    public function UserDetachComment($id)
    {
        $this->model::where('user_mark', 'front')->where('user_id', $id)->delete();
    }

    /**
     * 获取评论列表
     * @return mixed
     */
    public function getCommentList()
    {

        $paginator = $this->model::orderBy('created_at', 'desc')->paginate($this->backPageNum());
        return $this->getPaginatorComment($paginator);
    }

    /**
     * 最新评论列表
     * @return mixed
     */
    public function newCommentList()
    {
        return $this->model::where('user_mark', 'front')->orderBy('created_at', 'desc')->take(5)->get()->map(function ($contact) {
            $data = [];
            $data['article_id'] = $contact->articles->id;
            $data['content'] = $contact->content;
            $data['article_title'] = $contact->articles->title;
            $data['created_at'] = $contact->created_at->format('Y-m-d H:i:s');
            $data['comment_user_name'] = $contact->users->name;
            return $data;
        });
    }

    /**
     * 获取评论id数组
     * @param $data
     * @return array
     */
    public function getCommentIds($data): array
    {
        $arr = [];
        $arr[] = $data['id'];
        if (!$this->exists("parent_id", $data['id'])) {
            return $arr;
        }
        $parentData = $this->findByAll("parent_id", $data['id'])->get();
        foreach ($parentData as $value) {
            foreach (self::getCommentIds($value) as $id) {
                $arr[] = $id;
            }
        }
        return $arr;
    }

    /**
     * 搜索评论
     * @param $username
     * @param $usertype
     * @param UserRepository $userRepository
     * @param AdminRepository $adminRepository
     * @return mixed
     */
    public function searchComment($username, $usertype, UserRepository $userRepository, AdminRepository $adminRepository)
    {
        $paginator = [];
        if ($usertype == 'front') {
            $paginator = $this->model::orderBy('created_at', 'desc')->where('user_id', $userRepository->getUserId($username))->where('user_mark', 'front')->paginate($this->backPageNum());
        } else if ($usertype == 'back') {
            $paginator = $this->model::orderBy('created_at', 'desc')->where('user_id', $adminRepository->getAdminId($username))->where('user_mark', 'back')->paginate($this->backPageNum());
        }
        return $this->getPaginatorComment($paginator);
    }

    /**
     * 获取评论分页
     * @param $paginator
     * @return mixed
     */
    public function getPaginatorComment($paginator): mixed
    {
        $data = $paginator->makeHidden(['articles', 'article_id', 'updated_at', 'created_at', 'users', 'admins', 'user_mark','user_id'])->map(function ($contact) {

            $contact->article = ['article_title' => $contact->articles->title, 'article_id' => $contact->articles->id,'author_id'=>$contact->articles->admin_id];

            if ($contact->user_mark == 'front') {
                $contact->user=["user_id"=>$contact->user_id,"user_avatar"=>$contact->users->avatar,"user_type"=>"前台用户","username"=>$contact->users->username,'user_mark'=>$contact->user_mark];
            } else {
                $contact->user=["user_id"=>$contact->user_id,"user_avatar"=>$contact->admins->avatar,"user_type"=>"后台用户","username"=>$contact->admins->username,'user_mark'=>$contact->user_mark];
            }
            $contact->time = $contact->created_at->format('Y-m-d H:i:s');
            return $contact;
        });
        $paginator->data = $data;
        return $paginator;
    }

    /**
     * 获取前台评论分页
     * @param $article_id
     * @return mixed
     */
    public function getFrontArticleComments($article_id){
        $paginator = $this->model::orderBy('created_at', 'desc')->where('article_id',$article_id)->where('parent_id', null)->paginate($this->frontPageNum());
        $pageData = $this->getPaginatorComment($paginator)->toArray();
        $data=$this->list($pageData['data']);
        $pageData['data']=$data;
        return $pageData;
    }

    /**
     * 此方法用于生成嵌套评论列表
     * @param array $data
     * @param string|null $name
     * @param string|null $mark
     * @return array|string
     */
    public function list(array $data,string $name=null,string $mark=null): array|string
    {
        $arr = [];
        if (empty($data)) {
            return '';
        }
        foreach ($data as $value) {
            if ($child = $this->getPaginatorComment($this->model::orderBy('created_at','desc')->where('parent_id', $value['id'])->get())->toArray()) {
                $value['children'] = self::list($child,$value['user']['username'],$value['user']['user_mark']);
            }else{
                $value['children']=[];
            }
            $value['reply']=$name;
            $value['reply_mark']=$mark;
            $arr[] = $value;
        }
        return $arr;
    }
}
