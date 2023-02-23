<?php

namespace App\Services\BackService;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticleService extends BaseService
{
    /**
     * 获取文章列表
     * @param $request
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function getArticleList($request,ArticleRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->getArticleList($request->status));
    }

    /**
     * 获取文章
     * @param $request
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function getArticle($request,ArticleRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->getArticle($request->id));
    }

    /**
     * 添加文章
     * @param $request
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function addArticle($request, ArticleRepository $repository, CategoryRepository $categoryRepository, TagRepository $tagRepository): JsonResponse
    {
        $data = $request->all();
        $data['page_views'] = 0;
        $data['admin_id'] = auth('back_auth')->id();
        $tagsId=[];
        if (!$categoryRepository->exists('id', $request->category_id)) {
            return $this->Json('文章添加失败', null, HttpCode::HTTP_TYPE_ERROR, false, '分类id不存在');
        }else{
            if($categoryRepository->exists('parent_id',$request->category_id)){
                return $this->Json("文章添加失败",null, HttpCode::HTTP_TYPE_ERROR, false, "该一级分类下，存在二级分类");
            }
        }
        if (count($request->tags)!=0) {
            $tagsName=array_column($tagRepository->select('name')->toArray(), 'name');
            $tagsAll=$tagRepository->all()->toArray();
            $data['tags'] = array_map(function ($v) {
                return strtoupper($v);
            }, $data['tags']);

            $difference=array_diff($data['tags'],$tagsName);

            foreach($difference as $value){
                if($value!=null){
                    $tagsId[]=$tagRepository->create(['name'=>$value])->id;
                }
            }

            $dataDifference=array_diff($data['tags'],$difference);
            foreach($dataDifference as $v){
                foreach($tagsAll as $value){
                    if($v==$value['name']){
                        $tagsId[]=$value['id'];
                    }
                }
            }
            $data['tags']=$tagsId;
        }
        if ($request->file('cover') == null) {
            $data['cover'] = asset('images/article/default/ArticleDefault.jpg');
        } else {
            $path = $this->ArticleImg($request,'cover');
            $data['cover'] = $path;
        }
        if ($repository->addArticle($data)) {
            return $this->Json('文章添加成功');
        }

        return $this->Json("文章添加失败",null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改文章
     * @param $request
     * @param ArticleRepository $repository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @return JsonResponse
     */
    public function updateArticle($request,ArticleRepository $repository,CategoryRepository $categoryRepository,TagRepository $tagRepository): JsonResponse
    {
        $data=$request->except(['page_views','admin_id']);
        if (!$repository->exists('id',$data['id'])){
            return $this->Json('文章修改失败', null, HttpCode::HTTP_TYPE_ERROR, false, '文章id不存在');
        }
        $tagsId=[];
        if (!$categoryRepository->exists('id', $request->category_id)) {
            return $this->Json('文章修改失败', null, HttpCode::HTTP_TYPE_ERROR, false, '分类id不存在');
        }else{
            if($categoryRepository->exists('parent_id',$request->category_id)){
                return $this->Json("文章修改失败",null, HttpCode::HTTP_TYPE_ERROR, false, "该一级分类下，存在二级分类");
            }
        }
        if (count($request->tags)!=0) {
            $tagsName=array_column($tagRepository->select('name')->toArray(), 'name');
            $tagsAll=$tagRepository->all()->toArray();
            $data['tags'] = array_map(function ($v) {
                return strtoupper($v);
            }, $data['tags']);

            $difference=array_diff($data['tags'],$tagsName);

            foreach($difference as $value){
                if($value!=null){
                    $tagsId[]=$tagRepository->create(['name'=>$value])->id;
                }
            }

            $dataDifference=array_diff($data['tags'],$difference);
            foreach($dataDifference as $v){
                foreach($tagsAll as $value){
                    if($v==$value['name']){
                        $tagsId[]=$value['id'];
                    }
                }
            }
            $data['tags']=$tagsId;
        }
        if ($request->file('cover') == null) {
            $data['cover']=$repository->findById($data['id'])->cover;
        } else {
            $path = $this->ArticleImg($request,'cover');
            $data['cover'] = $path;
        }
        if ($repository->updateArticle($data)) {
            return $this->Json('文章修改成功');
        }

        return $this->Json("文章修改失败",null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");

    }

    /**
     * 删除文章
     * @param $request
     * @param ArticleRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteArticle($request,ArticleRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        foreach($request->ids as $value){
            if($repository->exists('id',$value)){
                $repository->detach($value);
                $commentRepository->ArticleDetachComment($value);
                $repository->delete($value);
            }
        }
        return $this->Json("文章删除成功");
    }

    /**
     * 上传文章图片
     * @param $request
     * @return JsonResponse
     */
    public function addArticleImg($request): JsonResponse
    {
        return $this->Json('ok',[
           'url'=>$this->ArticleImg($request,'img'),
           'alt'=>null,
           'href'=>null
        ]);
    }

    /**
     * 上传文章视频
     * @param $request
     * @return JsonResponse
     */
    public function addArticleVideo($request): JsonResponse
    {
        return $this->Json('ok',[
            'url'=>$this->ArticleVideo($request,'video'),
            'poster'=>null
        ]);
    }

    /**
     * 文章图片保存函数
     * @param $request
     * @param $name
     * @return string
     */
    public function ArticleImg($request,$name): string
    {
        $filename = Carbon::now()->getPreciseTimestamp(3);
        $img = Image::make(file_get_contents($request->file($name)->getRealPath()));
        $img->save('images/article/' . $filename . '.jpg');
        return asset('images/article/' . $filename . '.jpg');
    }

    /**
     * 文章视频保存函数
     * @param $request
     * @param $name
     * @return string
     */
    public function ArticleVideo($request,$name):string
    {
        $filename = Carbon::now()->getPreciseTimestamp(3);
        $extension = $request->file($name)->extension();
        return asset(Storage::putFileAs('images/article', $request->file($name), $filename.'.'.$extension));
    }

    /**
     * 文章搜索
     * @param $request
     * @param ArticleRepository $repository
     * @return JsonResponse
     */
    public function searchArticle($request,ArticleRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->searchArticle($request));
    }
}
